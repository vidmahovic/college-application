<?php

namespace App\Http\Controllers;

use App\FacultyProgram;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;



class FacultyProgramController extends Controller
{
    //$fractal = new Manager();
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(){
        $fractal = new Manager();
        $facultyPrograms = FacultyProgram::all()->toArray();;

        $resource = new Collection($facultyPrograms, function(array $facultyProgram) {
            return [
                'id'      => (int) $facultyProgram['id'],
                'name'   => $facultyProgram['name'],
                'faculty_id'    => (int) $facultyProgram['faculty_id'],
                'allow_double_degree'    => (int) $facultyProgram['allow_double_degree'],
                'is_regular'    => (boolean) $facultyProgram['is_regular'],
                'min_points'    => (int) $facultyProgram['min_points'],
                'created_at'    => (date_parse($facultyProgram['created_at'])),
                'updated_at'    =>  (date_parse($facultyProgram['updated_at']))
            ];
        });

        return $fractal->createData($resource)->toJson();
    }

    public function show($id){
        $task = FacultyProgram::find($id);
        return $task;
    }
}
