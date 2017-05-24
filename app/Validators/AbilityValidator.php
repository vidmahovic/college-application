<?php

namespace App\Validators;

class AbilityValidator{

    protected $errors;
    protected $input;

    public function validate($input){

        $this->input = $input;

        $rules = [
            'min_points' => 'required|integer',
            'max_points' => 'required|integer',
        ];

        $messages = [
            'required' =>'This field is required.',
            'integer' =>'This field must be an integer.'
        ];

        $validator = app('validator')->make($input, $rules, $messages);

        $validator->after(function($validator)
        {
            if($this->input["min_points"] > $this->input["max_points"]){
                $validator->errors()->add('min_points', 'Threshold values are invalid!');
            }

            if($this->input["min_points"] < 0 || $this->input["max_points"] < 0){
                $validator->errors()->add('min_points', 'Threshold values must be bigger than zero!');
            }

            // validate applicants
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