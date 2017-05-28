<?php

namespace App\Http\Controllers\Api;

use App\Models\FacultyProgram;
use App\Transformers\FacultyProgramTransformer;
use App\Validators\FacultyProgramValidator;
use CollegeApplication\Search\FacultyProgramSearch\FacultyProgramSearch;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Pagination\LengthAwarePaginator;

class FacultyProgramController extends ApiController
{

    private $search;
    protected $validator;

    public function __construct(Request $request, FacultyProgramSearch $search, FacultyProgramValidator $validator)
    {
        $this->search = $search;
        $this->validator = $validator;
        parent::__construct($request);
    }

    public function index()
    {
        if($this->request->user()->cannot('get', FacultyProgram::class)) {
            throw new AuthorizationException('Unauthorized access');
        }

        $programs = $this->search->applyFiltersFromRequest($this->request)->get()
            ->load('faculty')->sort(function($programA, $programB) {
                if($programA->faculty->name === $programB->faculty->name) {
                    if($programA->type === $programB->type) {
                        return $programA->is_regular <=> $programB->is_regular;
                    }
                    return $programA->type <=> $programB->type;
                }
                return $programA->faculty->name <=> $programB->faculty->name;
            });


//        $programs = $this->setFilters(new FacultyProgram);
//        $programs = $this->setSorting($programs);
//        $programs = $this->setLimit($programs);

        return $this->response->collection($programs, new FacultyProgramTransformer)->addMeta('count', $programs->count());
    }

    public function create(){
        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        $faculty_program = FacultyProgram::create($this->request->all());

        return $this->response->created();
    }

    public function update($id){

        $max_accepted = $this->request->input('max_accepted');
        $max_accepted_foreign = $this->request->input('max_accepted_foreign');

        if(intval($max_accepted) < 1 && intval($max_accepted_foreign) < 1){
            return $this->response->errorBadRequest("Enter a valid number for max accepted!");
        }

        $faculty_program = FacultyProgram::findOrFail($id);

        $faculty_program->max_accepted = $max_accepted;
        $faculty_program->max_accepted_foreign = $max_accepted_foreign;
        $faculty_program->save();

        return $this->response->created();
    }

    public function destroy($id){
        FacultyProgram::destroy($id);
        return $this->response->noContent();
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

        $programs = $this->search->applyFiltersFromRequest($this->request)->get()
            ->load('faculty')->sort(function($programA, $programB) {
                if($programA->faculty->name === $programB->faculty->name) {
                    if($programA->type === $programB->type) {
                        return $programA->is_regular <=> $programB->is_regular;
                    }
                    return $programA->type <=> $programB->type;
                }
                return $programA->faculty->name <=> $programB->faculty->name;
            });

        $page = $this->request->get('page') ?? 1;
        $perPage = $this->request->get('perPage') ?? 30;

        $paginator = new LengthAwarePaginator($programs->forPage($page, $perPage), $programs->count(), $perPage, $page, [
            'path' => $this->request->url()
        ]);

        // $programs = $this->setSorting($programs);
        // $programs = $this->setLimit($programs);

        return $this->response->paginator($paginator, new FacultyProgramTransformer);
    }
}
