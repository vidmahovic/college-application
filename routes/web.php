<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('index');
});

$app->group(['prefix' => 'api'], function() use($app) {

    $app->get('/faculty_programs','FacultyProgramController@index');
    $app->get('/faculty_programs/{id}', 'FacultyProgramController@show');

    $app->get('/application','ApplicationController@show');
    $app->post('/application','ApplicationController@create');

});
