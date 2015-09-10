<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Simulation;
use App\Parameter;
use Input;
use DB;
use Image;
use Facade;
use Illuminate\Support\Facades\Queue;
use App\Commands\startSimulation;

class SimulationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $simulations = Simulation::all();
        return view('simulations.index', compact('simulations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('simulations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = (object) Input::all();

        $file = Input::file('thumbnail');

        $simulationID = DB::table('simulations')->insertGetId([
            'name'         => $post->name,
            'updated_at'    => \Carbon\Carbon::now(),
            'created_at'    => \Carbon\Carbon::now(),
        ]);

        $file->move(public_path(). '/parameters/'. $simulationID . '/' , $post->name . '.txt'); #note comma, 2nd param is file name

        # parse file
        $fileData = fopen('parameters/' . $simulationID . '/' . $post->name . '.txt', 'r');
        $insert = [];
        while (($line = fgetcsv($fileData, 0, ' ')) != FALSE)
        {
            $insert[] = [
                'name' => $line[0],
                'type' => 'float',
                'defaultVal' => $line[1],
                'simulation_id' => $simulationID,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now()
            ];
        }


        DB::table('parameters')->insert($insert);

        return redirect('simulations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
