<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \App\City;
use \App\Country;
use \App\Citizen;
use \App\Faculty;
use \App\EducationType;
use \App\GraduationType;
use \App\FacultyProgram;
use \App\ApplicationInterval;

class ApplicationRequest extends FormRequest {

    public function authorize(){
        return true;
    }

    public function rules(){

        $isFromSlovenia = Country::where('name','SLOVENIJA')->pluck('id') == $request->input('country');
        $isBornInSLovenia = District::where('name','TUJINA')->pluck('id') == $request->input('district_birth');

        if(!(isFromSlovenia && isBornInSLovenia)){
            return false;
        }

        $dob = $request->input('date_of_birth');
        if(!checkdate(date("m",strtotime($dob), date("d",strtotime($dob), date("Y",strtotime($dob))){
            return false;
        }

        $gender = 'M' // TODO: get from user data!

        if(!validateEMSO($request->input('emso'), $isFromSlovenia, $gender)){
            return false;
        }

        $interval = ApplicationInterval::latest()->first();
        $start_date = $interval->start_at->format('Y-m-d');
        $end_date = $interval->ends_at->format('Y-m-d');

       
        $curr_date = date('Y-m-d'));
        if(!($curr_date >= $start_date && $curr_date <= $end_date)){
            return false;
        }

        return [
            'application_city_id' => 'required', Rule::in(City::all()->pluck('id')),
            'country_id' => 'required', Rule::in(Country::all()->pluck('id')),
            'citizen_id' => 'required', Rule::in(Citizen::all()->pluck('id')),
            'district_birth' => 'required', Rule::in(District::all()->pluck('id')),
            'faculty' => 'required', Rule::in(Faculty::all()->pluck('id')),
            'profession_id' => 'required', Rule::in(Profession::all()->pluck('id')),
            'middle_school_id' => 'required', Rule::in(MiddleSchool::all()->pluck('id')),
            'education_type_id' => 'required', Rule::in(EducationType::all()->pluck('id')),
            'graduation_type_id' => 'required', Rule::in(GraduationType::all()->pluck('id')),
            'faculty_program_1' => Rule::in(FacultyProgram::all()->pluck('id')),
            'faculty_program_2' => Rule::in(FacultyProgram::all()->pluck('id')),
            'faculty_program_3' => Rule::in(FacultyProgram::all()->pluck('id'))
        ];
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
        if(!($gender = 'M' && $gnumber <= 499)){
            return false;
        }
        if(!($gender = 'F' && $gnumber >= 500 && $gnumber <= 999)){
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