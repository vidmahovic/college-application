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
        $is_regular = [0, 1];

        $filters['fid'] = $request->input('fid');
        $filters['type'] = $request->input('type');
        $filters['is_regular'] = $request->input('is_regular');

        if(!count($request->all()))
            $facultyPrograms = FacultyProgram::with('faculty')->paginate();
        else
            $facultyPrograms = FacultyProgram::with('faculty')->latest()->arrangeBy($filters)->paginate(2);

        /*
        $resource = new Collection($facultyPrograms, function(array $facultyProgram) {
            return [
                'id'      => (int) $facultyProgram['id'],
                'name'   => $facultyProgram['name'],
                'acronym'    => $facultyProgram['acronym'],
                'min_points'    => (int) $facultyProgram['min_points']
            ];
        });

        return $fractal->createData($resource)->toJson();
        */

        return $facultyPrograms;
    }

    public function show($id){
        $facultyProgram = FacultyProgram::with('faculty')->findOrFail($id);
        return $facultyProgram;
    }
}
