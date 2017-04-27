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

            // Validations with regards to other tables
            'address.*.address' => '',
            'address.*.city_id' => '',
            'address.*.country_id' => '',
        ];
        
        $validator = ApplicationValidator::make($input, $rules);
        if($validator->fails()){
            $this->errors = $validator->messages();
            return false;
        }

        // sifrant validation

        if(! in_array($input['country_id'], Country::all()->pluck('id'))){
            $validator->errors()->add('country_id', 'Please specify a valid country!');
        }

        if(! in_array($input['citizen_id'], Citizen::all()->pluck('id'))){ // nationality_type_id
            $validator->errors()->add('citizen_id', 'Please specify your nationality!');
        }

        if(! in_array($input['permanent_applications_cities_id'], City::all()->pluck('id'))){
            $validator->errors()->add('permanent_applications_cities_id', 'Please specify a valid city!');
        }

        if(! in_array($input['mailing_applications_cities_id'], City::all()->pluck('id'))){
            $validator->errors()->add('mailing_applications_cities_id', 'Please specify a valid city!');
        }

        if(! in_array($input['district_id'], District::all()->pluck('id'))){
            $validator->errors()->add('district_id', 'Please specify a valid place of birth!');
        }

        if(! in_array($input['profession_id'], Profession::all()->pluck('id'))){
            $validator->errors()->add('profession_id', 'Please specify a valid profession!');
        }

        if(! in_array($input['middle_school_id'], MiddleSchool::all()->pluck('id'))){
            $validator->errors()->add('middle_school_id', 'Please specify a valid middle school!');
        }

        if(! in_array($input['education_type_id'], EducationType::all()->pluck('id'))){
            $validator->errors()->add('education_type_id', 'Please specify a valid education type!');
        }

        if(! in_array($input['graduation_type_id'], GraduationType::all()->pluck('id'))){
            $validator->errors()->add('graduation_type_id', 'Please specify a graduation type!');
        }

        // application requirements validation

        $gender = $input['emso');
        $isFromSlovenia = Country::where('name','SLOVENIJA']->pluck('id') == $input['country_id');
        $isBornInSLovenia = District::where('name','TUJINA']->pluck('id') != $input['district_id');

        if(!(isFromSlovenia && isBornInSLovenia)){
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
       
        $curr_date = date('Y-m-d'));
        if(!($curr_date >= $start_date && $curr_date <= $end_date)){
            $validator->errors()->add('application_interval_id', 'Application interval has passed!');
        }

        // end

        if( $validator->fails()){
            $this->errors = $validator->errors();
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
        $day = intval(substr($emso,0,2);
        $month = intval(substr($emso,2,4));
        $year = intval(substr($emso,4,7)) + 1000; // 1900 - 1999
        if(!checkdate($month, $day, $year)){
            return false;
        }
        // slovenija - register = 50
        // tujci != 50
        if(!($isFromSlovenia && intval(substr($emso,7,9) == 50)){
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