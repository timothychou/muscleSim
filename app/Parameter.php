<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/* instances of parameter represent a parameter that a simulation has
 * each simulation may have multiple parameters, but only one simulation
 * per parameter
 */
class Parameter extends Model {

	public function simulation()
    {
        return $this->belongsTo('App\Simulation');
    }
}
