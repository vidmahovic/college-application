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

$app->get('register/verify/{code}', ['as' => 'register.verify', 'uses' => 'Api\AuthController@confirmRegistration']);

// Password reset route (has to be without prefix due to Mailer requirements).
$app->group(['middleware' => 'api.throttle'], function($app) {
    $app->get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

    $api = app('api.router');

    $api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function($api) {
        /*
        $api->get('applications/{id}/calculate', 'CalculationController@calculate');
        $api->get('applications/calculate', 'CalculationController@index');
        $api->get('applications/classify/eu', 'CalculationController@classifyEU');
        $api->get('applications/classify/foreign', 'CalculationController@classifyForeign');
        */

        // Authentication routes
        $api->post('register', 'AuthController@register');
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
            $api->get('programs/{id}', 'FacultyProgramController@show');
            $api->post('programs/create', 'FacultyProgramController@create');
            $api->post('programs/update/{id}', 'FacultyProgramController@update');
            $api->delete('programs/{id}', 'FacultyProgramController@destroy');
            $api->post('programs/{id}', 'FacultyProgramController@destroy');
            $api->post('programs/{id}/conditions', 'ConditionController@create');
            $api->get('subjectsAndProfessions', 'ConditionController@subjectsAndProfessions');
            $api->get('program/{id}/ability', 'AbilityController@applied');
            $api->post('program/{id}/ability', 'AbilityController@create');
            $api->post('ability/{pid}', 'AbilityController@insert');

            // APPLICATION
            //$api->get('applications/accepted/paginate', 'ApplicationController@acceptedPaginated');
            $api->get('applications/accepted', 'ApplicationController@accepted');
            $api->get('applications/active', 'ApplicationController@active');
            $api->get('applications/paginate', 'ApplicationController@paginate');
            $api->get('applications', 'ApplicationController@index');
            $api->get('applications/sifranti', 'ApplicationController@sifranti');
            //$api->get('applications/{id}','ApplicationController@show');
            $api->post('applications','ApplicationController@create');
            $api->delete('applications/{application}', 'ApplicationController@archive');
            $api->put('applications/{id}', 'ApplicationController@update');

            //STAFF
            $api->get('faculties', 'AdminController@faculties');
            //$api->get('faculties/{faculty}/applications', 'FacultyController@applications');
            $api->post('create', 'AdminController@create');

            // ENROLLMENT SERVICE (FILE UPLOAD)
            $api->post('upload/general-matura', 'UploadController@storeGeneralMatura');
            $api->post('upload/vocational-matura', 'UploadController@storeVocationalMatura');

            // CALCULATION
            $api->get('applications/{id}/calculate', 'CalculationController@calculate');
            $api->get('applications/calculate', 'CalculationController@index');
            $api->get('classify/eu', 'CalculationController@classifyEU');
            $api->get('classify/foreign', 'CalculationController@classifyForeign');
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
