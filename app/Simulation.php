<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * This class represents the simulations that a user is able to run
 * Each job has a simulation
 */
class Simulation extends Model {


    /*
     * returns the jobs of this simulation
     * This function could be used later on so certain machines
     * that can do a certain simulation will do all the jobs of that simulation
     */
	public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function parameters()
    {
        return $this->hasMany('App\Parameter');
    }

}
