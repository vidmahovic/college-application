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

    public function create($id){ // POST: /programs/{id}/conditions
        /*
        $conditions = EnrollmentCondition::all()->where('faculty_program_id',$id)->toArray();
        if(is_array($conditions)){
            EnrollmentCondition::destroy($conditions);
        }
        else{
            EnrollmentCondition::findOrFail($conditions)->delete();
        }
        */

        if(! $this->validator->validate($this->request->all(), $id)){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }
        // [
        //  {name : 0, type : 0, conditions_subject_id : null, conditions_profession_id : null, weight : 40},
        //  {name : 0, type : 0, conditions_subject_id : null, conditions_profession_id : null, weight : 60}
        // ]

        // TODO: create

        return null;
    }

}