<?php

use \App\Http\Controllers;

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

$app->get('/faculty_programs','FacultyProgramController@index');
$app->get('faculty_programs/{id:[0-9]+}', 'FacultyProgramController@show');
//$app->get('faculty_programs/{id}/faculty_id/{fid}', 'FacultyProgramController@faculty', ['id' => $id, 'fid' => $fid]);

// php artisan make:seeder FacultyProgramsSeeder