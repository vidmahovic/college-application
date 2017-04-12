<?php

namespace App\Http\Controllers\Api;

use App\Models\FacultyProgram;
use App\Models\Faculty;
use App\Transformers\FacultyProgramTransformer;
use League\Fractal\Resource\Collection;
use Illuminate\Http\Request;

class FacultyProgramController extends ApiController
{

    public function index()
    {
        $programs = $this->setFilters(new FacultyProgram);
        return $this->response->paginator($programs->paginate(30), new FacultyProgramTransformer);
    }

    public function show($id){
        $facultyProgram = FacultyProgram::with('faculty','countAll', 'countAccepted')->findOrFail($id);
        return $facultyProgram;
    }
}
