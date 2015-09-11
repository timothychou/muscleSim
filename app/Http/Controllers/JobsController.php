<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\Variable;
use App\Http\Requests\JobRequest;
use Carbon\Carbon;
use Input;
use DB;
use Image;
use Facade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use App\Commands\startSimulation;


class JobsController extends Controller {





    public function runMatlab($id)
    {
        /* runs the matlab function, hardcoded for now, but should accept the matlab function id also
        */
        exec ('nohup ./runMatlab.sh ' . $id .' > /dev/null &');
        /*
        echo 'processing';
        echo exec('scp variables/' . $id . '.txt admin@130.132.20.134:~/parameters');
        echo 'ssh admin@130.132.20.134 /Applications/MATLAB_R2015a.app/bin/matlab -nodesktop -noFigureWindows -nosplash -nodisplay -r "script_runSimCommLine\\(' . "\\'/Users/admin/parameters/". $id . ".txt\\'" . '\\)"';
        echo exec('ssh admin@130.132.20.134 /Applications/MATLAB_R2015a.app/bin/matlab -nodesktop -noFigureWindows -nosplash -nodisplay -r "script_runSimCommLine\\(' . "\\'/Users/admin/parameters/". $id . ".txt\\'" . '\\)"');
        exec('scp admin@130.132.20.134:~/mfm_ldep_web/output_file.txt results/' . $id . '.txt');
        echo 'done';
        */
    }

    /* none of jobs can be accessed without first logging in */
    public function __construct()
    {
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $finishedJobs = \Auth::user()->jobs()->Finished()->latest('posted_at')->get();
        $unFinishedJobs = \Auth::user()->jobs()->Unfinished()->latest('posted_at')->get();
		$jobs = \Auth::user()->jobs()->latest('posted_at')->get();
         //   Job::latest('posted_at')->get();

        return view('jobs.index', compact('jobs', 'finishedJobs', 'unFinishedJobs'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        /* for some reason lists is reverse order, lists('a','b') does
         * b => a
         */
        $simulations = \App\Simulation::lists('name', 'id')->all();
		return view('jobs.create', compact('simulations'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(JobRequest $request)
	{
        echo "processing";
        /*
		$job = new Job($request->only('title', 'simulation_id'));



        \Auth::user()->jobs()->save($job);*/

        $post = (object) Input::all();
        //$params = (object) Input::except('title', 'simulation_id');
        $params = $post->parameter;
        $jobId = DB::table('jobs')->insertGetId([
           'user_id'        => \Auth::user()->id,
            'title'         => $post->title,
            'simulation_id' => $post->simulation_id,


            'updated_at'    => \Carbon\Carbon::now(),
            'created_at'    => \Carbon\Carbon::now(),
        ]);

        if (Input::hasFile('thumbnail'))
            /* create params from file
             * TODO: parse file to generate params and add to database
             *
             */

        {

            $file = Input::file('thumbnail');
            $file->move('variables/', $jobId . '.txt');
            $fileData = fopen('variables/' . $jobId . '.txt', 'r');
            $insert = [];
            while (($line = fgetcsv($fileData, 0, ' ')) != FALSE)
            {
                $param = \App\Simulation::find($post->simulation_id)->parameters()->where('name', $line[0])->get();
                if (count($param) < 1)
                {
                    echo 'input file not formatted correctly';
                    echo '      ';
                    echo count($line);
                    echo $line[0];
                    echo $line[1];
                    return;
                }else
                {
                    $param = $param[0];
                }
                $insert[] = [
                    'job_id' => $jobId,
                    'parameter_id' => $param->id,
                    'name' => $param->name,
                    'value' => $line[1],
                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now(),

                ];
            }

            DB::table('variables')->insert($insert);
            /*$file->move(public_path() . '/variables/', 'my-file.jpg');*/
        }else {
            /* no params file, so just take from form */


            $insert = [];
            $inputString = '';
            foreach ($params as $paramId => $param) {
                #note array[] = stuff is same as array.add(stuff) or array_push(array, stuff)
                $paramName = \App\Parameter::findOrFail($paramId)->name;
                $insert[] = [
                    'job_id' => $jobId,
                    'parameter_id' => $paramId,
                    'name' => $paramName,
                    'value' => $param,

                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now(),

                ];

                $inputString .= $paramName . ' ' . $param . PHP_EOL;
            }

            # create input file
            file_put_contents('variables/' . $jobId . '.txt', $inputString);


            DB::table('variables')->insert($insert);
        }
        #runMatlab($jobId . '.txt');
        #Queue::push(new startSimulation());
        #$this->dispatch(new AddJob(array('title' => $post->title, 'simulation_id' => $post->simulation_id, 'id' => $jobId->id)));
        # should call func+simpleUnloadedTwitch(file_name, output_name)


        \Session::flash('message', 'Running Simulation');
        $this->runMatlab($jobId);
        return redirect('jobs');
	}





    public function overlay()
    {

        $ids = array_keys(Input::all());

        # first check that we own all the id's



        $data = \Lava::DataTable();
        $data->addNumberColumn('Time');
        $counter = 0;
        foreach ($ids as $id)
        {
            $job = \Auth::user()->jobs()->find($id);
            if ($job)
            {
                $data->addNumberColumn($job->title);

                #open file and add data from csv
                $file = fopen('results/' . $id . '.txt', 'r');
                while (($line = fgetcsv($file)) != FALSE) #one line at a time
                {
                    $row = array_fill(0, 2 + $counter, NULL);
                    $row[0] = $line[1];
                    $row[$counter + 1] = $line[0];
                    $data->addRow($row);
                }
                $counter++;
            }else {
                echo 'Jobs not found';
                return;
            }
        }



        $hAxis = \Lava::HorizontalAxis(['title' => 'Time (ms)']);
        $vAxis = \Lava::VerticalAxis(['title' => 'Sarcomere Length (µm)']);

        $linechart = \Lava::LineChart('Graph')->dataTable($data)->title('Overlay')->hAxis($hAxis)->vAxis($vAxis);

        # hard coded for now, axis labels


        return view('jobs.overlay');
        /*$alpha = [];



        if (count($ids) == 0){
            return "error, 0 selected";
        }
        $alpha = 1.0 / count($ids);
        return view('jobs.overlay', compact('ids', 'alpha'));*/
    }



	/**
	 * Display the specified resource.
	 * Download the input file
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
    {
        if ($job = \Auth::user()->jobs->find($id)) {

            return response()->download("variables/" . $id . ".txt");
        }else{
            echo "Job could not be found";
        }


	}

    /**
     * Download an example input from simulation_id
     */
    public function exampleInput($id)
    {
        $simulation = \App\Simulation::findOrFail($id);
        return response()->download("parameters/" . $id . "/" . $simulation->name . ".txt");

    }

    /**
     * Download output file
     */
    public function output($id)
    {
        if (\Auth::user()->jobs()->find($id)){
            return response()->download("results/" . $id . ".txt");
        }else{
            echo "Job could not be found";
        }
    }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return 'editing';
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return 'updating';
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $job = Job::find($id);
		$job->delete();
        exec('rm results/' . $id . '.txt');
        exec('rm variables/' . $id . '.txt');
        return redirect('jobs');
	}

}

