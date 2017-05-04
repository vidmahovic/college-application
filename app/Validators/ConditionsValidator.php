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

    public function validate($input, $fid){

        $subjects = Subject::all();
        $professions = Profession::all();
        $types = [0 => 'Splošna in poklicna matura', 1 => 'Splošna matura', 2 => 'Poklicna matura'];
        $names = [0 =>'Uspeh na maturi', 1 => 'Uspeh v 3. in 4. letniku', 2 => 'Uspeh pri dodatnem predmetu',
            3 => 'Uspeh pri predpisanem predmetu', 4 => 'Uspeh pri preizkusu nadarjenosti', 5 => 'Poklic'];

        $this->subjects = $subjects;
        $this->professions = $professions;
        $this->input = $input;
        $this->fid = $fid;

        $rules = [
            'conditions' => 'required'
        ];

        $messages = [
            'required' =>'You must specify atleast one condition.'
        ];

        $validator = app('validator')->make($input, $rules, $messages);

        $validator->after(function($validator)
        {
            $conditions = json_decode($this->input['conditions'], true);

            if($conditions[0]['type'] == 0){ // splosna in poklicna matura
                $weights = 0;
                for($i = 0; $i < count($conditions); $i = $i + 1){
                    $current = $conditions[$i];
                    switch($current['name']) {
                        case 0:
                        case 1:
                            if ($current['conditions_subject_id'] == null && $current['conditions_profession_id'] == null && $current['weight'] > 0) {
                                $weights = $weights + $current['weight'];
                            } else {
                                $validator->errors()->add('conditions', 'Invalid data!');
                            }
                            break;
                        case 2:
                        case 3:
                        case 4:
                            if (in_array($current['conditions_subject_id'], $this->subjects) && $current['conditions_profession_id'] == null && $current['weight'] > 0) {
                                $weights = $weights + $current['weight'];
                            } else {
                                $validator->errors()->add('conditions', 'Invalid data!');
                            }
                            break;
                        case 5:
                            if ($current['conditions_subject_id'] == null && in_array($current['conditions_profession_id'], $this->professions) && $current['weight'] == null) {
                                $weights = $weights + $current['weight'];
                            } else {
                                $validator->errors()->add('conditions', 'Invalid data!');
                            }
                            break;
                    }
                }
                if($weights != 100){
                    $validator->errors()->add('conditions', 'Weight must be 100% when summed!');
                }
            }
            else{ // posebej splosna in poklicna matura

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