<?php

namespace App\Http\Controllers\Api;

use App\Models\EnrollmentCondition;
use App\Models\Profession;
use App\Models\Subject;
use App\Validators\ConditionsValidator;
use Dingo\Api\Http\Request;

class ConditionController extends ApiController
{
    protected $validator;
    public function __construct(Request $request, ConditionsValidator $validator)
    {
        $this->validator = $validator;
        parent::__construct($request);
    }

    public function subjectsAndProfessions()
    {
        $subjects = Subject::all();
        $professions = Profession::all();
        $types = [0 => 'Splošna in poklicna matura', 1 => 'Splošna matura', 2 => 'Poklicna matura'];
        $names = [0 =>'Uspeh na maturi', 1 => 'Uspeh v 3. in 4. letniku', 2 => 'Uspeh pri dodatnem predmetu',
            3 => 'Uspeh pri predpisanem predmetu', 4 => 'Uspeh pri preizkusu nadarjenosti', 5 => 'Poklic'];
        return $this->response->array([
            'subjects'=> $subjects,
            'professions'=> $professions,
            'types'=> $types,
            'names'=> $names
        ]);
    }

    public function show($id){
        return EnrollmentCondition::all()->where('faculty_program_id', $id);
    }

    public function create($id)
    {
        // TODO: policy

        $conditions = (EnrollmentCondition::all()->where('faculty_program_id',$id)->pluck('id'))->toArray();
        for($i = 0; $i < count($conditions); $i = $i + 1){
            EnrollmentCondition::destroy($conditions[$i]);
        }

        if (!$this->validator->validate($this->request->all())) {
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        $conditions = json_decode($this->request->input('conditions'), true);

        for($i = 0; $i < count($conditions); $i = $i + 1){
            $type = $conditions[$i]["type"];
            $data = $conditions[$i]["data"];
            for($j = 0; $j < count($data); $j = $j + 1) {
                $current = $data[$j];

                EnrollmentCondition::create([
                    'faculty_program_id' => $id,
                    'name' => $current["name"],
                    'type' => $type,
                    'conditions_subject_id' => $current["conditions_subject_id"],
                    'conditions_profession_id' => $current["conditions_profession_id"],
                    'weight' => $current["weight"]
                ]);
            }
        }

        return $this->response->created();
    }
}