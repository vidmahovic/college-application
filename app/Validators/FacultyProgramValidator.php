<?php

namespace App\Validators;

use Illuminate\Validation\Validator;

class FacultyProgramValidator extends Validator{
    protected $errors;

    public function validate($input){

        $rules = [
            'id' => 'required|alphanum|unique:faculty_programs,id',
            'name' => 'required',
            'type' => 'required|min:0|max:2',
            'faculty_id' => 'required|exists:faculty_programs,id',
            'allow_double_degree' => 'required|boolean',
            'is_regular' => 'required|boolean',
            'min_points' => 'required|integer|min:0|max:100',
            'max_accepted' => 'required|integer',
            'max_accepted_foreign' => 'required|integer'
        ];

        $validator = ApplicationValidator::make($input, $rules);
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