<?php

namespace App\Validators;

class FacultyProgramValidator extends Validator{
    protected $errors;

    public function validate($input){

        $rules = [
            'id' => 'required|alphanum|unique:faculty_programs,id',
            'name' => 'required',
            'faculty_id' => 'required|integer',
            'allow_double_degree' => 'required|boolean',
            'type' => 'required|exists:faculty_programs,id',
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