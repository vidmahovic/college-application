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
        if(!checkdate(month, day, year)){ // TODO
            return false;
        }

        $validEMSO = validateEMSO($request->input('emso'));

        // TODO application interval

        return [
            'city' => 'required', Rule::in(City::all()->pluck('id')),
            'country' => 'required', Rule::in(Country::all()->pluck('id')),
            'citizen' => 'required', Rule::in(Citizen::all()->pluck('id')),
            'district_birth' => 'required', Rule::in(District::all()->pluck('id')),
            'faculty' => 'required', Rule::in(Faculty::all()->pluck('id')),
            'education_type' => 'required', Rule::in(EducationType::all()->pluck('id')),
            'graduation_type' => 'required', Rule::in(GraduationType::all()->pluck('id')),
            'faculty_program_1' => Rule::in(FacultyProgram::all()->pluck('id')),
            'faculty_program_2' => Rule::in(FacultyProgram::all()->pluck('id')),
            'faculty_program_3' => Rule::in(FacultyProgram::all()->pluck('id'))
        ];
    }

    public function validateEMSO($emso){
        // 29 02 932  50 552 6

        if(strlen($emso) != 13){
            return false;
        }

        $day = intval(substr($emso,0,2));
        $month = intval(substr($emso,2,4));
        $year = intval(substr($emso,4,7)) + 1000; // 1900 - 1999

        if(!checkdate($month, $day, $year)){
            return false;
        }

        // TODO register, zaporedna stevilka: 50 552

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
    }
}