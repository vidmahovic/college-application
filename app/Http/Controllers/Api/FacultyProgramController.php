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
        if($this->request->user()->cannot('get', FacultyProgram::class)) {
            return $this->response->errorUnauthorized();
        }

        $programs = $this->setFilters(new FacultyProgram);
        $programs = $this->setSorting($programs);
        $programs = $this->setLimit($programs);
        return $this->response->collection($programs->get(), new FacultyProgramTransformer)->addMeta('count', $programs->count());
    }

    public function show($id){
        $facultyProgram = FacultyProgram::with('faculty','countAll', 'countAccepted')->findOrFail($id);
        return $facultyProgram;
    }

    public function paginate()
    {
        if($this->request->user()->cannot('paginate', FacultyProgram::class)) {
            return $this->response->errorUnauthorized();
        }

        $programs = $this->setFilters(new FacultyProgram);
        $programs = $this->setSorting($programs);
        $programs = $this->setLimit($programs);

        return $this->response->paginator($programs->paginate(30), new FacultyProgramTransformer);
    }

}
