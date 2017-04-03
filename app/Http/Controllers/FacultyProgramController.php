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

        $faculties = Faculty::all();
        $types = [0,1,2];
        $is_regular = [0,1];

        $filters['fid'] = $request->input('fid'); // fakulteta ID
        $filters['type'] = $request->input('type'); // uni, vs, mag program
        $filters['is_regular'] = $request->input('is_regular'); // redni, izredni studij

        if(intval($filters['fid']) > 0 || intval($filters['type']) >= 0 || intval($filters['type']) <= 2 || $filters['is_regular'] == "true" || $filters['is_regular'] == "false")
            $facultyPrograms = FacultyProgram::latest()->filter($filters)->toArray();
        else
            $facultyPrograms = FacultyProgram::latest()->get()->toArray();

        // TODO: pagination

        /*
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
        */
        return $facultyPrograms;
    }

    public function show($id){
        $facultyProgram = FacultyProgram::findOrFail($id);
        return $facultyProgram;
    }
}
