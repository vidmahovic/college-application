<?php

use App\Models\FacultyProgram;

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

$app->get('api', function() {
    return app('files')->get(public_path('/swagger-ui/index.html'));
});

// Password reset route (has to be without prefix due to Mailer requirements).
$app->group(['middleware' => 'api.throttle'], function($app) {
    $app->get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

    $api = app('api.router');

    $api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function($api) {

        // tests, without auth
        $api->get('test_all', function() { return FacultyProgram::all(); });
        $api->post('test_create', 'FacultyProgramController@create');
        $api->post('test_update/{id}', 'FacultyProgramController@update');
        $api->delete('test_delete/{id}', 'FacultyProgramController@destroy');
        
        $api->post('staff_all', 'AdminController@index');
        $api->post('staff_test', 'AdminController@create');

        // Authentication routes
        $api->post('login', 'AuthController@login');
        $api->post('password/email', 'PasswordController@sendPasswordResetEmail');
        $api->post('password/reset', 'PasswordController@resetPassword');

        // Protected routes
        $api->group(['middleware' => 'api.auth'], function($api) {

            // USER
            $api->post('user/password', 'UserController@password');
            $api->get('user', 'UserController@user');

            // PROGRAM
            $api->get('programs/paginate', 'FacultyProgramController@paginate');
            $api->get('programs','FacultyProgramController@index');
            //$api->get('programs/{id}', 'FacultyProgramController@show');

            // APPLICATION
            $api->get('applications/active', 'ApplicationController@active');
            $api->get('applications/sifranti', 'ApplicationController@sifranti');
            //$api->get('applications/{id}','ApplicationController@show');
            $api->post('applications','ApplicationController@create');
            $api->delete('applications/{application}', 'ApplicationController@archive');
            $api->put('applications/{id}', 'ApplicationController@update');
        });
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
