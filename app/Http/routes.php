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

Route::get('jobs/overlay', 'JobsController@overlay');
Route::resource('jobs', 'JobsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('test', function(){
    echo(shell_exec("ls 2>&1"));

});