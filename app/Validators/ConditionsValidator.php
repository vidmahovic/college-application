<?php

namespace App\Validators;

use App\Models\Subject;
use App\Models\Profession;

class ConditionsValidator
{
    protected $errors;
    protected $input;
    protected $subjects;
    protected $professions;

    public function validate($input){

        $subjects = Subject::all()->pluck('id')->toArray();
        $professions = Profession::all()->pluck('id')->toArray();
        $types = [0 => 'Splošna in poklicna matura', 1 => 'Splošna matura', 2 => 'Poklicna matura'];
        $names = [0 =>'Uspeh na maturi', 1 => 'Uspeh v 3. in 4. letniku', 2 => 'Uspeh pri dodatnem predmetu',
            3 => 'Uspeh pri predpisanem predmetu', 4 => 'Uspeh pri preizkusu nadarjenosti', 5 => 'Poklic'];

        $this->subjects = $subjects;
        $this->professions = $professions;
        $this->input = $input;

        $rules = [
            'conditions' => 'required'
        ];

        $messages = [
            'required' =>'You must specify atleast one condition.'
        ];

        $validator = app('validator')->make($input, $rules, $messages);

        $validator->after(function($validator)
        {
            $conditions = $this->input['conditions']['data'];

            $prev = 0;
            $weights = 0;
            for($i = 0; $i < count($conditions); $i = $i + 1){
                $current = $conditions[$i];
                $type = $current["type"];

                if($type > 2 || $type < 0){
                    $validator->errors()->add('conditions', 'Type must be valid!');
                }

                if($prev != $type){
                    $prev = $type;
                    $weights = 0;
                }
                switch ($current["name"]) {
                    case 0:
                    case 1:
                        if ($current["conditions_subject_id"] == null && $current["weight"] > 0) {
                            $weights = $weights + $current["weight"];
                        } else {
                            $validator->errors()->add('conditions', 'Invalid data, both null!');
                        }
                        break;
                    case 2:
                    case 3:
                    case 4:
                        if ((in_array($current["conditions_subject_id"], $this->subjects) || $this->subjects == null) && $current["conditions_profession_id"] == null && $current["weight"] > 0) {
                            $weights = $weights + $current['weight'];
                        } else {
                            $validator->errors()->add('conditions', 'Invalid data, add subject!');
                        }
                        break;
                    case 5:
                        if ($current["conditions_subject_id"] == null && in_array($current["conditions_profession_id"], $this->professions) && $current["weight"] == null) {
                        } else {
                            $validator->errors()->add('conditions', 'Invalid data, add profession!');
                        }
                        break;
                    default:
                        $validator->errors()->add('conditions', 'Invalid condition name!');
                }
            }
            if($weights != 100){
                $validator->errors()->add('conditions', "Sum of weights must be 100!");
            }
        });

        if($validator->fails()){
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    public function errors(){
        return $this->errors;
    }
}