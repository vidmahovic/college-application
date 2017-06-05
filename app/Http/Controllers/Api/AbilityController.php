<?php

namespace App\Http\Controllers\Api;

use App\Models\AbilityTest;
use App\User;
use App\Models\Application;
use App\Models\ApplicationAbilityTest;
use App\Models\ApplicationsPrograms;
use App\Models\EnrollmentCondition;
use App\Models\FacultyProgram;
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

        $conditions = EnrollmentCondition::where('faculty_program_id', $id)->get();
        $ability = false;
        $applied = null;
        $users = [];

        for($i = 0; $i < count($conditions); $i = $i + 1){
            if($conditions[$i]["name"] == 4){
                $ability = AbilityTest::where('faculty_program_id', $id)->first();
                if($ability == null){
                    $ability = true;
                }
                else {
                    $applied = ApplicationAbilityTest::with('application')->where('ability_test_id', $ability->id)->get();
                    $user_ids = $applied->pluck('application')->pluck("user_id");
                    $users = User::whereIn('id', $user_ids)->get();

                    /*
                    for($i = 0; $i < count($applied); $i = $i + 1){
                        $curr = $applied[$i];
                        $curr["name"] = $users[$i];
                    }
                    */
                }
            }
        }

        return $this->response->array([
            'ability_test'=> $ability,
            'applied' => $applied,
            'users' => $users
        ]);
    }

    public function create($id){
    // TODO: policy

    $exists = AbilityTest::where('faculty_program_id', $id)->first();
    $applications = null;

    if(! $this->validator->validate($this->request->all())){
        $errors = $this->validator->errors();
        return $this->response->errorBadRequest($errors);
    }

    if($exists != null){
        AbilityTest::destroy($exists->id);
        $application_programs = ApplicationsPrograms::where('faculty_program_id', $id)->pluck('id')->toArray();
        ApplicationAbilityTest::destroy($application_programs);
    }

    $ability = AbilityTest::create([
        'faculty_program_id' => $id,
        'min_points' => $this->request["min_points"],
        'max_points' => $this->request["max_points"]
    ]);

    $applications = ApplicationsPrograms::where('faculty_program_id', $id)->pluck('application_id')->toArray();
    if($applications != null) {
        for ($i = 0; $i < count($applications); $i = $i + 1) {
            ApplicationAbilityTest::create([
                'application_id' => $applications[$i],
                'ability_test_id' => $ability->id,
                'points' => -1
            ]);
        }
    }

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
            return $this->response->errorBadRequest("Vnesite rezultate preizkusa!");
        }

        $applications = Application::all()->pluck('id')->toArray();

        for($i = 0; $i < count($results); $i = $i + 1){
            $curr = $results[$i];

            if(!in_array($curr["aid"], $applications)){
                return $this->response->errorBadRequest("Neveljavna vpisnica!");
            }

            if($curr["points"] > $ability_test->max_points || $curr["points"] < -1){
                return $this->response->errorBadRequest("Točke morajo biti med mejami!");
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
