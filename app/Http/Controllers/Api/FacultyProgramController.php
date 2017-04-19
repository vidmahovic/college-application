<?php

namespace App\Http\Controllers\Api;

use App\Models\FacultyProgram;
use App\Transformers\FacultyProgramTransformer;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Auth\Access\AuthorizationException;

class FacultyProgramController extends ApiController
{

    public function index()
    {
        if($this->request->user()->cannot('get', FacultyProgram::class)) {
            throw new AuthorizationException('Unauthorized access');
        }

        $programs = $this->setFilters(new FacultyProgram);
        $programs = $this->setSorting($programs);
        $programs = $this->setLimit($programs);

        return $this->response->collection($programs = $programs->get(), new FacultyProgramTransformer)->addMeta('count', $programs->count());
    }

    public function show($id)
    {
        $program = FacultyProgram::find($id);

        if($program == null)
            throw new ResourceException('Resource not found');

        if($this->request->user()->cannot('view', $program))
            throw new AuthorizationException('Unauthorized access');

        return $this->response->item($program, new FacultyProgramTransformer);
    }

    public function paginate()
    {
        if($this->request->user()->cannot('paginate', FacultyProgram::class)) {
            throw new AuthorizationException('Unauthorized access');
        }

        $programs = $this->setFilters(new FacultyProgram);
        $programs = $this->setSorting($programs);
        $programs = $this->setLimit($programs);

        return $this->response->paginator($programs->paginate(30), new FacultyProgramTransformer);
    }

}
