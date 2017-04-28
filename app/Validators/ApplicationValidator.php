<?php

namespace App\Validators;

class ApplicationValidator extends Validator{
    protected $errors;

    public function validate($input){

        $rules = [
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:' . (string) Carbon::now()->subYears(14),
            'phone' => ['required', 'regex:/^\+(?:[0-9]●?){6,14}[0-9]$/'],
            'permanent_address' => 'required|alphanum',
            'mailing_address' => 'required|alphanum',
            'permanent_applications_cities_id' => 'required|exists:cities,id',
            'mailing_applications_cities_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'citizen_id' => 'required|exists:citizens,id',
            'district_id' => 'required|exists:districts,id',
            'middle_school_id' => 'required|exists:middle_schools,id',
            'profession_id' => 'required|exists:professions,id',
            'education_type_id' => 'required|exists:education_types,id',
            'graduation_type_id' => 'required|exists:graduation_types,id'
        ];

        $validator = ApplicationValidator::make($input, $rules);

        // application requirements validation

        $gender = $input['emso'];
        $isFromSlovenia = Country::where('name','SLOVENIJA')->pluck('id') == $input['country_id'];
        $isBornInSLovenia = District::where('name','TUJINA')->pluck('id') != $input['district_id'];

        if(!($isFromSlovenia && $isBornInSLovenia)){
            $validator->errors()->add('country_id', 'Please specify your nationality!');
        }

        if($isFromSlovenia){
            if(!validateEMSO($input['emso'], $isFromSlovenia, $gender)){
                $validator->errors()->add('emso', 'Please enter a valid EMSO!');
            }
            else {
                // generate emso
                $digits = 12;
                $generated = rand(pow(10, $digits-1), pow(10, $digits)-1);
                $input['emso'] = $generated;
            }
        }

        $interval = ApplicationInterval::latest()->first();
        $start_date = $interval->start_at->format('Y-m-d');
        $end_date = $interval->ends_at->format('Y-m-d');
       
        $curr_date = date('Y-m-d');
        if(!($curr_date >= $start_date && $curr_date <= $end_date)){
            $validator->errors()->add('application_interval_id', 'Application interval has passed!');
        }

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
        if(!($gender = 'male' && $gnumber <= 499)){
            return false;
        }
        if(!($gender = 'female' && $gnumber >= 500 && $gnumber <= 999)){
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