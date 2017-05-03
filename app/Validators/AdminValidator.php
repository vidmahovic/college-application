<?php

namespace App\Validators;

class AdminValidator{

    protected $errors;
    protected $input;

    public function validate($input){

        $this->input = $input;

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|alphanum|min:8',
            'password_confirmation' => 'required',
            'role_id' => 'required|exists:roles,id',
            'faculty_id' => 'nullable'
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