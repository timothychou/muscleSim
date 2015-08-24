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

    public function runMatlab($filename)
    {
        /* runs the matlab function, hardcoded for now, but should accept the matlab function id also
        */
        exec('matlab -nodesktop -nosplash "function_name(' . $filename . ')"');
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
		$jobs = \Auth::user()->jobs()->latest('posted_at')->get();
         //   Job::latest('posted_at')->get();

        return view('jobs.index', compact('jobs'));

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
            $file->move(public_path(). '/variables/', $jobId . '.txt');
            /*$file->move(public_path() . '/variables/', 'my-file.jpg');*/
        }else {
            /* no params file, so just take from form */


            $insert = [];

            foreach ($params as $paramId => $param) {
                $insert[] = [
                    'job_id' => $jobId,
                    'parameter_id' => $paramId,
                    'name' => \App\Parameter::findOrFail($paramId)->name,
                    'value' => $param,

                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now(),

                ];
            }

            DB::table('variables')->insert($insert);
        }
        #runMatlab($jobId . '.txt');
        #Queue::push(new startSimulation());
        #$this->dispatch(new AddJob(array('title' => $post->title, 'simulation_id' => $post->simulation_id, 'id' => $jobId->id)));
        # should call func+simpleUnloadedTwitch(file_name, output_name)
        return redirect('jobs');
	}





    public function overlay()
    {

        $ids = array_keys(Input::all());
        $alpha = [];



        if (count($ids) == 0){
            return "error, 0 selected";
        }
        $alpha = 1.0 / count($ids);
        return view('jobs.overlay', compact('ids', 'alpha'));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        echo $id;
        $job = Job::find($id);
        return $job;
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

        return redirect('jobs');
	}

}

