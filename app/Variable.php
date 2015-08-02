<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model {

	public function job()
    {
        return $this->belongsTo('App\Job');
    }

}
