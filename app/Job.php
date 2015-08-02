<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Job extends Model {

    protected $fillable = [
        'title',
        'parameters',
    ];

    /* treat the following as carbon instances */
    protected $dates = ['finished_at', 'predicted_end'];

    public function setPostedAtAttribute($date)
    {
        $this->attributes['posted_at'] = Carbon::parse($date);
    }

    public function scopeFinished($query)
    {
        $query->whereNotNull('finished_at');
    }

    public function scopeUnfinished($query)
    {
        $query->whereNull('finished_at');
    }

    /*
     * get job's user who posted it
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     * get the simulation object that this job is for
    */
    public function simulation()
    {
        return $this->belongsTo('App\Simulation');
    }

    /* each job has many variables, i.e. the values for the parameters of the simulation
    */
    public function variables()
    {
        return $this->hasMany('App\Variable');
    }
}




