<?php

namespace App\Http\Controllers;

use App\FacultyProgram;
use App\Faculty;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Illuminate\Http\Request;

class FacultyProgramController extends Controller
{
    //$fractal = new Manager();
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request){
        $fractal = new Manager();
        $fid = $request->input('fid');

        if(intval($fid) > 0)
            $facultyPrograms = FacultyProgram::with('faculty')->latest()->facultyFilter($fid)->get()->toArray();
        else
            $facultyPrograms = FacultyProgram::latest()->get()->toArray();

        $resource = new Collection($facultyPrograms, function(array $facultyProgram) {
            return [
                'id'      => (int) $facultyProgram['id'],
                'name'   => $facultyProgram['name'],
                'faculty_id'    => (int) $facultyProgram['faculty_id'],
                'allow_double_degree'    => (int) $facultyProgram['allow_double_degree'],
                'is_regular'    => (boolean) $facultyProgram['is_regular'],
                'min_points'    => (int) $facultyProgram['min_points']
            ];
        });

        return $fractal->createData($resource)->toJson();
    }

    public function show($id){
        $facultyProgram = FacultyProgram::findOrFail($id);
        return $facultyProgram;
    }
}
