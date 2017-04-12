<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use App\Models\FacultyProgram;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Application;
use App\Models\GraduationType;
use App\Models\EducationType;
use App\Models\Country;

class ApplicationController extends ApiController
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
        $application = Application::create(request(
            ['emso', 'date_of_birth', 'user_id', 'profession_id', 'middle_school_id', 'education_type_id', 
            'application_interval_id','country_id', 'citizen_id', 'applications_cities_id'
            ]
        ));
        
        return response()->setStatusCode(201, 'The application is created successfully!');
    }
}
