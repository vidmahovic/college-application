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
        return [
            'city' => 'required', Rule::in(City::all()),
            'country' => 'required', Rule::in(Country::all()),
            'citizen' => 'required', Rule::in(Citizen::all()),
            'faculty' => 'required', Rule::in(Faculty::all()),
            'education_type' => 'required', Rule::in(EducationType::all()),
            'graduation_type' => 'required', Rule::in(GraduationType::all()),
            'faculty_program' => 'required', Rule::in(FacultyProgram::all())
        ];
    }
}