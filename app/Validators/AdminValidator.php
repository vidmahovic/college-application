<?php

namespace App\Validators;

class AdminValidator{

    protected $errors;
    protected $input;

    public function validate($input){

        $this->input = $input;

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:user,username',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'role_id' => 'required|exist:roles,id',
            'faculty_id' => 'null'
        ];

        $messages = [
            'required' =>'This field is required.',
            'unique' =>'This field must be unique.',
            'exists' =>'This field must exist.',
            'confirmed' => 'Passwords must match',
            'null' =>'This field can be null, unless when creating referent.',
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