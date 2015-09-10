<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\Request;

class AjaxController extends Controller {

    /**
     * @return html for parameter fields in job creation form
     */
    public function postParameters()
    {
        //return "ajax worked!";
        $post = (object)Input::all();
        $simulation_id = $post->simulation_id;

      //  $simulationID = 1; //hardcoded
        $simulation = \App\Simulation::findOrFail($simulation_id);
        $parameters = $simulation->parameters;

        $html = "";
        foreach ($parameters as $parameter){
            $html .= '<div class="form-group">';
            $html .= '<label for="title">' . $parameter->name . '(' . $parameter->type . ')</label>';
            $html .= '<input class="form-control" name="parameter[' . $parameter->id . ']" type="text" value="'. $parameter->defaultVal .'">';
            $html .= '</div>';


        }
        return $html;

    }

    /**
     * @return html for example download in job creation form
     */
    public function postDownload()
    {
        $post = (object)Input::all();
        $simulation_id = $post->simulation_id;

        $html = '<a href="exampleInput/' . $simulation_id . '">download example file</a>';
        return $html;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
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
