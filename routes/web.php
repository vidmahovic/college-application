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
    $api->post('password/email', 'PasswordController@sendPasswordResetEmail');
    $api->post('password/reset', 'PasswordController@resetPassword');

    $api->get('/programs','FacultyProgramController@index');
    $api->get('/programs/{id}', 'FacultyProgramController@show');
    $api->get('/application','ApplicationController@show');
    $api->post('/application','ApplicationController@create');

    $api->group(['middleware' => 'api.auth'], function($api) {

//        $api->get('/programs','FacultyProgramController@index');
//        $api->get('/programs/{id}', 'FacultyProgramController@show');
//        $api->get('/application','ApplicationController@show');
//        $api->post('/application','ApplicationController@create');

    });
});

//$app->group(['prefix' => 'api', 'namespace' => 'Api'], function() use($app) {
//    // Authentication routes
//    $app->post('login', 'AuthController@login');
//    $app->post('password-reset', 'AuthController@password');
//
//
//    $app->get('/programs','FacultyProgramController@index');
//    $app->get('/programs/{id}', 'FacultyProgramController@show');
//
//    $app->get('/application','ApplicationController@show');
//    $app->post('/application','ApplicationController@create');
//
//});
