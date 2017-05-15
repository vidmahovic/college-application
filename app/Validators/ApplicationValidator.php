<?php

namespace App\Validators;

use App\Models\Country;
use App\Models\District;
use App\Models\ApplicationInterval;
use Carbon\Carbon;

class ApplicationValidator{

    protected $errors;
    protected $input;
    protected $gender;
    protected $isFromSlovenia;
    protected $isBornForeign;

    public function validate($input){

        $this->input = $input;

        $rules = [
            'user_id' => 'required|exists:users,id',
            'emso' => 'required|min:12|max:13',
            'gender' => 'required',
            'date_of_birth' => 'required|date|before:' . (string) Carbon::now()->subYears(5),
            'phone' => ['required', 'regex:/^[0-9]{9}$/'],

            'citizen_id' => 'required|exists:citizens,id',
            'district_id' => 'required|exists:districts,id',
            'country_id' => 'required|exists:countries,id',
            'middle_school_id' => 'required|exists:middle_schools,id',
            'profession_id' => 'required|exists:professions,id',
            'education_type_id' => 'required|exists:education_types,id',
            'graduation_type_id' => 'required|exists:graduation_types,id',

            'permanent_address' => 'required|string',
            'mailing_address' => 'required|string',
            'permanent_country_id' => 'required|exists:countries,id',
            'mailing_country_id' => 'required|exists:countries,id',
            'permanent_applications_cities_id' => 'required|exists:cities,id',
            'mailing_applications_cities_id' => 'required|exists:cities,id'
        ];

        $messages = [
            'required' =>'This field is required.',
            'integer' =>'This field must be an integer.',
            'exists' =>'This field must exist in database.',
            'min' =>'This field must be of certain numeric value.',
            'max' =>'This field must be of certain numeric value.',
            'in' =>'This field must be male or female.',
            'date' =>'This field must be of date format.',
            'before' =>'This field must be of date format and date before future.',
            'regex' =>'This field must be a valid phone number.',
            'string' =>'This field must be string value.'
        ];

        $validator = app('validator')->make($input, $rules, $messages);

        $this->gender = $this->input['gender'];
        $this->isFromSlovenia = Country::where('name','SLOVENIJA')->first()->id == $this->input['country_id'];
        $this->isBornForeign = District::where('name', 'TUJINA')->first()->id == $this->input['district_id'];

        $validator->after(function($validator)
        {
            /*
            if(($this->isFromSlovenia && $this->isBornForeign)){
                $validator->errors()->add('district_id', 'Please specify your origin!');
            }

            if($this->isFromSlovenia){
                if(!validateEMSO($this->input['emso'], $this->isFromSlovenia, $this->gender)){
                    $validator->errors()->add('emso', 'Please enter a valid EMSO!');
                }
            }*/

            $interval = ApplicationInterval::all()->first();
            $start_date = strtotime($interval->starts_at);
            $end_date = strtotime($interval->ends_at);

            $curr_date = strtotime( date('Y-m-d'));
            if(!($curr_date >= $start_date && $curr_date <= $end_date)){
                $validator->errors()->add('user_id', 'Application interval has passed!');
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

    public function validateEMSO($emso,  $isFromSlovenia, $gender){
        // 29 02 932 50 552 6
        if(strlen($emso) != 13){
            return false;
        }
        $day = intval(substr($emso,0,2));
        $month = intval(substr($emso,2,4));
        $year = intval(substr($emso,4,7)) + 1000; // 1900 - 1999
        if(!checkdate($month, $day, $year)){
            return false;
        }
        // slovenija - register = 50
        // tujci != 50
        if(!($isFromSlovenia && intval(substr($emso,7,9)) == 50)){
            return false;
        }
         // zaporedna številka; moski imajo med 000-499, zenske 500-999
        $gnumber = intval(substr($emso,10,13));
        if(!($gender == 'male' && $gnumber <= 499)){
            return false;
        }
        if(!($gender == 'female' && $gnumber >= 500 && $gnumber <= 999)){
            return false;
        }
        $factors = [];
        $factors[0] = $emso[0] * 7;
        $factors[1] = $emso[1] * 6;
        $factors[2] = $emso[2] * 5;
        $factors[3] = $emso[3] * 4;
        $factors[4] = $emso[4] * 3;
        $factors[5] = $emso[5] * 2;
        $factors[6] = $emso[6] * 7;
        $factors[7] = $emso[7] * 6;
        $factors[8] = $emso[8] * 5;
        $factors[9] = $emso[9] * 4;
        $factors[10] = $emso[10] * 3;
        $factors[11] = $emso[11] * 2;
        $sum = array_sum($factors);  
        $control = 11 - ($sum % 11);
        if($control != $emso[12]){
            return false;
        }

        return true;
    }
}
