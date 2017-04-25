<?php

namespace App\Http\Controllers\Api;

use App\Models\FacultyProgram;
use App\Transformers\FacultyProgramTransformer;
use CollegeApplication\Search\FacultyProgramSearch\FacultyProgramSearch;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class FacultyProgramController extends ApiController
{

    private $search;

    public function __construct(\Dingo\Api\Http\Request $request, FacultyProgramSearch $search)
    {
        $this->search = $search;
        parent::__construct($request);
    }

    public function index()
    {
        if($this->request->user()->cannot('get', FacultyProgram::class)) {
            throw new AuthorizationException('Unauthorized access');
        }

        $programs = $this->search->applyFiltersFromRequest($this->request)->get();

//        $programs = $this->setFilters(new FacultyProgram);
//        $programs = $this->setSorting($programs);
//        $programs = $this->setLimit($programs);

        return $this->response->collection($programs, new FacultyProgramTransformer)->addMeta('count', $programs->count());
    }

    public function show($id)
    {
        $program = FacultyProgram::find($id);

        if($program == null)
            throw new ResourceException('Resource not found');

        if($this->request->user()->cannot('view', $program))
            return $this->response->errorUnauthorized('Unauthorized access.');

        return $this->response->item($program, new FacultyProgramTransformer);
    }

    public function paginate()
    {
        if($this->request->user()->cannot('paginate', FacultyProgram::class)) {
            return $this->response->errorUnauthorized('Unauthorized access.');
        }

        $programs = $this->search->applyFiltersFromRequest($this->request);

        // $programs = $this->setSorting($programs);
        // $programs = $this->setLimit($programs);

        return $this->response->paginator(
            $programs->paginate($this->request->get('perPage') ?? 30),
            new FacultyProgramTransformer
        );
    }

    public function test()
    {
        $programs = FacultyProgram::all();
        return $programs;
    }

}
