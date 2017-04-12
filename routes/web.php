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

$api = app('api.router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function($api) {

    $api->post('login', 'AuthController@login');
    $api->post('password/email', 'PasswordController@email');
    $api->post('password/reset', 'PasswordController@reset');

    $api->get('/programs','FacultyProgramController@index');
    $api->get('/programs/{id}', 'FacultyProgramController@show');
    $api->get('/application','ApplicationController@show');
    $api->post('/application','ApplicationController@create');

    // Routes for authenticated users (require "Authorization: Bearer [token]" header with a valid token)
    $api->group(['middleware' => 'api.auth'], function($api) {
        // Add portected routes here.
    });
});
