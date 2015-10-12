<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', 'RootController@index');
Route::get('home', function()
{
    return redirect('/');
});

Route::get('temp', function(){
    $name = 'Heart simulation';
    $parameters = ['size', 'count', 'iterations'];
    return view('jobs/create2', compact('parameters', 'name'));
});

Route::get('jobs/ajax/parameters', 'AjaxController@postParameters');
Route::get('jobs/ajax/simulations', 'AjaxController@postDownload');

Route::get('jobs/overlay', 'JobsController@overlay');
Route::get('jobs/overlaySelect', 'JobsController@overlaySelect');

Route::get('jobs/exampleInput/{id}', 'JobsController@exampleInput');

Route::get('jobs/output/{id}', 'JobsController@output');
Route::resource('jobs', 'JobsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('test', 'JobsController@runMatlab');

Route::get('tst', function(){

    exec ('nohup ./runMatlab.sh 37 > /dev/null &');

});

Route::get('jobs/destroy/{id}', 'JobsController@destroy');
Route::get('simulations/destroy/{id}', 'SimulationsController@destroy');
$debug = True;
if ($debug) {
    Route::resource('simulations', 'SimulationsController');
}