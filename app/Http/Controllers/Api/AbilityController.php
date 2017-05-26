<?php

namespace App\Http\Controllers\Api;

use App\Models\AbilityTest;
use App\Models\Application;
use App\Models\ApplicationAbilityTest;
use App\Models\ApplicationsPrograms;
use Dingo\Api\Http\Request;
use App\Validators\AbilityValidator;
use Dingo\Api\Exception\ResourceException;

class AbilityController extends ApiController
{
    protected $validator;

    public function __construct(Request $request, AbilityValidator $validator)
    {
        parent::__construct($request);
        $this->validator = $validator;
    }

    public function applied($id){
        // TODO: policy

        $applied = ApplicationsPrograms::with('application')->where('faculty_program_id', $id)->get();
        // $applied = Application::with('applicationsPrograms', $id, 'applicationAbilityTest')->where('status', 'filed')->get();

        $ability = AbilityTest::where('faculty_program_id', $id)->first();

        return $this->response->array([
            'applied'=> $applied,
            'ability_test'=> $ability
        ]);
    }

    public function create($id){
        // TODO: policy

        $exists = AbilityTest::where('faculty_program_id', $id)->first();

        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        if($exists == null){
            throw new ResourceException('Resource not found');
        }
        else{
            AbilityTest::destroy($exists->id);
        }

        AbilityTest::create([
            'faculty_program_id' => $id,
            'min_points' => $this->request["min_points"],
            'max_points' => $this->request["max_points"]
        ]);

        return $this->response->created();
    }

    public function insert($pid){
        // TODO: policy

        $ability_test = AbilityTest::where('faculty_program_id',$pid)->first();

        if($ability_test == null){
            throw new ResourceException('Resource not found');
        }

        $results = $this->request->input('results');

        if($results == null){
            return $this->response->errorBadRequest("You must enter results of the test");
        }

        $applications = Application::all()->pluck('id')->toArray();

        for($i = 0; $i < count($results); $i = $i + 1){
            $curr = $results[$i];

            if(!in_array($curr["aid"], $applications)){
                return $this->response->errorBadRequest("Invalid application id!");
            }

            if($curr["points"] > $ability_test->max_points || $curr["points"] < -1){
                return $this->response->errorBadRequest("Points must be between ability test min/max points!");
            }
        }

        $previous = ApplicationAbilityTest::where('ability_test_id', $ability_test->id)->get()->pluck('id')->toArray();
        ApplicationAbilityTest::destroy($previous);

        for($i = 0; $i < count($results); $i = $i + 1){
            $curr = $results[$i];

            $application_ability_test = ApplicationAbilityTest::create([
                'application_id' => $curr["aid"],
                'ability_test_id' => $ability_test->id,
                'points' => $curr["points"]
            ]);
        }

        return $this->response->created();
    }
}
