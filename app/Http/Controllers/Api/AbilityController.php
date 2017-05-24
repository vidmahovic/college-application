<?php

namespace App\Http\Controllers\Api;

use App\Models\AbilityTest;
use App\Models\Application;
use App\Models\ApplicationAbilityTest;
use Dingo\Api\Http\Request;
use App\Validators\AbilityValidator;

class AbilityController extends ApiController
{
    protected $validator;

    public function __construct(Request $request, AbilityValidator $validator)
    {
        parent::__construct($request);
        $this->validator = $validator;
    }

    public function applied($id){ // seznam mej in kdo je prijavljen na ta program s testom sposobnosti
        $applied = Application::all()->applicationWish($id)->get();

        $ability = AbilityTest::where('faculty_program_id', $id)->first();

        return $this->response->array([
            'applied'=> $applied,
            'ability_test'=> $ability
        ]);
    }

    public function create($id){
        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        $ability_test = AbilityTest::create([
            'faculty_program_id' => $id,
            'min_points' => $this->request["min_points"],
            'max_points' => $this->request["max_points"]
        ]);

        $ability_test_id = $ability_test->id;

        // TODO: parse, foreach
        $app_ability_test = ApplicationAbilityTest::create([
            'application_id' => 1,
            'ability_test_id' => $ability_test_id,
            'points' => 0
        ]);

        return $this->response->created();
    }
}
