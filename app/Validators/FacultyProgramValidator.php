<?php

namespace App\Validators;

class FacultyProgramValidator{

    protected $errors;
    protected $input;

    public function validate($input){

        $this->input = $input;

        $rules = [
            'id' => 'required|alphanum|unique:faculty_programs,id',
            'name' => 'required',
            'type' => 'required|min:0|max:2',
            'faculty_id' => 'required|exists:faculties,id',
            'allow_double_degree' => 'required|boolean',
            'is_regular' => 'required|boolean',
            'min_points' => 'required|integer|min:0|max:100',
            'max_accepted' => 'required|integer',
            'max_accepted_foreign' => 'required|integer'
        ];

        $messages = [
            'required' =>'This field is required.',
            'alphanum' =>'This field must be an alphanum value.',
            'unique' =>'This field must be unique.',
            'min' =>'This field must be of certain value.',
            'max' =>'This field must be of certain value.',
            'exists' =>'This field must exist.',
            'boolean' =>'This field must be true or false',
            'integer' =>'This field must be an integer.',
        ];

        $validator = app('validator')->make($input, $rules, $messages);

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