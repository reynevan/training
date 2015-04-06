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

Route::get('/', 'TrainingsController@index');

Route::get('home', 'TrainingsController@index');

Route::resource('trainings', 'TrainingsController');

Route::resource('exercises', 'ExercisesController');

Route::resource('users', 'UsersController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('series', 'SeriesController@store');

Route::put('series', 'SeriesController@update');

Route::post('series_exercises', 'SeriesExercisesController@store');
