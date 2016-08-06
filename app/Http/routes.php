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

Route::get('/', 'WelcomeController@index');

// get tasks request
Route::get('api/tasks/all',array('as'=>'tasks.all','uses'=>'WelcomeController@getAllTasks'));

// get task lists
Route::get('api/tasklists/all',array('as'=>'tasklists.all','uses'=>'WelcomeController@getAllTasklists'));

// search for task
Route::get('api/tasks/search/{param}',array('as'=>'task.search','uses'=>'TaskController@searchForTasks'))->where(array('param'=>'[a-zA-Z0-9-_]+'));



Route::get('home', 'HomeController@index');

Route::resource('tasklist','TasklistController',array('except'=>array('show')));

Route::resource('task','TaskController',array('except'=>array('show')));


Route::get('tasks/status/{status}',array('as'=>'tasks.status','uses'=>'TaskController@getByStatus'))->where(array('slug'=>'[a-zA-Z0-9-_]+'));
Route::get('tasks/tasklist/{slug}',array('as'=>'tasks.list','uses'=>'TaskController@getByList'))->where(array('slug'=>'[a-zA-Z0-9-_]+'));

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
