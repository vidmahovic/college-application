<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use App\Models\FacultyProgram;
use App\Models\Citizen;
use App\Models\City;
use App\Models\District;
use App\Models\Application;
use App\Models\GraduationType;
use App\Models\EducationType;
use App\Models\Country;
use App\Models\MiddleSchool;
use App\Models\ApplicationPrograms;

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
        $middle_schools = MiddleSchool::all();
        $facultyProgramsDD = FacultyProgram::all()->where('allow_double_degree',true);

        $application = new Application;

        return response()->json(['countries'=> $countries,
                                'cities'=> $cities,
                                'citizens'=> $citizens,
                                'faculties'=> $faculties, 
                                'facultyPrograms'=> $facultyPrograms,
                                'facultyProgramsDD'=> $facultyProgramsDD,
                                'districts'=> $districts,
                                'education_types'=> $education_types,
                                'graduation_types'=> $graduation_types,
                                'middle_schooles'=> $middle_schools,
                                'application' => $application
                                ], 200);
    }

    public function create(ApplicationRequest $request){
        $application = Application::create(request(
            ['emso', 'date_of_birth', 'user_id', 'middle_school_id', 
                'education_type_id', 'graduation_type_id', 'profession_id',
                'district_birth_id', 'country_id', 'citizen_id', 'applications_cities_id'
            ]
        ));

        $interval = ApplicationInterval::latest()->first()->pluck('id');
        $application->application_interval_id = $interval;

        $aid = $application->pluck('id');
        $allPrograms = FacultyProgram::all()->pluck('id');

        if($allPrograms->contains(request('faculty_program_1_id')){
            ApplicationPrograms::create([ 
                'application_id' => $aid, 
                'faculty_program_id' => request('faculty_program_1_id'), 
                'status' => false, 
                'choice_number' => 1
            ]);
        }
        if($allPrograms->contains(request('faculty_program_2_id')){
            ApplicationPrograms::create([ 
                'application_id' => $aid, 
                'faculty_program_id' => request('faculty_program_2_id'), 
                'status' => false, 
                'choice_number' => 2
            ]);
        }
        if($allPrograms->contains(request('faculty_program_3_id')){
            ApplicationPrograms::create([ 
                'application_id' => $aid, 
                'faculty_program_id' => request('faculty_program_3_id'), 
                'status' => false, 
                'choice_number' => 3
            ]);
        }
        
        return response()->setStatusCode(201, 'The application is created successfully!');
    }
}
