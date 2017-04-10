<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\FacultyProgram;
use App\Citizen;
use App\City;
use App\Application;
use App\MiddleSchool;
use App\Profession;
use App\GraduationType;
use App\EducationType;
use App\Country;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function show(){
        $countries = Country::all();
        $cities = City::all();
        $citizens = Citizen::all();
        $faculties = Faculty::all();
        $districts = District::all();
        $facultyPrograms = FacultyProgram::all();
        $education_types = EducationType::all();
        $graduation_types = GraduationType::all();

        return [$countries, $cities, $citizens, $faculties, $facultyPrograms,  $districts, $education_types, $graduation_types];
    }

    public function create(ApplicationRequest $request){
        
    }
}
