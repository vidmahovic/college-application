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

        if(isFromSlovenia && isBornInSLovenia){
            // OK
        }

        return [
            'city' => 'required', Rule::in(City::all()->pluck('id')),
            'country' => 'required', Rule::in(Country::all()->pluck('id')),
            'citizen' => 'required', Rule::in(Citizen::all()->pluck('id')),
            'district_birth' => 'required', Rule::in(District::all()->pluck('id')),
            'faculty' => 'required', Rule::in(Faculty::all()->pluck('id')),
            'education_type' => 'required', Rule::in(EducationType::all()->pluck('id')),
            'graduation_type' => 'required', Rule::in(GraduationType::all()->pluck('id')),
            'faculty_program' => 'required', Rule::in(FacultyProgram::all()->pluck('id'))
        ];
    }
}