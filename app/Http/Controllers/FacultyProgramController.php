<?php

namespace App\Http\Controllers;

use App\Models\FacultyProgram;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyProgramController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request){
        $faculties = Faculty::all();
        $types = [0,1,2];
        $is_regular = [0, 1];

        $filters['fid'] = $request->input('fid');
        $filters['type'] = $request->input('type');
        $filters['is_regular'] = $request->input('is_regular');

        if(!count($request->all()))
            $facultyPrograms = FacultyProgram::with('faculty','countAll', 'countAccepted')->paginate(10);
        else
            $facultyPrograms = FacultyProgram::with('faculty','countAll', 'countAccepted')->latest()->arrangeBy($filters)->paginate(5);

        // return $this->response->paginator($facultyPrograms, new FacultyProgramTransformer);

        return $facultyPrograms;
    }

    public function show($id){
        $facultyProgram = FacultyProgram::with('faculty','countAll', 'countAccepted')->findOrFail($id);

        // return $this->response->item($facultyProgram, new FacultyProgramTransformer);

        return $facultyProgram;
    }
}
