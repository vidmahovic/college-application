<?php

namespace App\Http\Controllers;

use App\FacultyProgram;

class FacultyProgramController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(){
        $tasks = FacultyProgram::all();
        return $tasks;
    }
}
