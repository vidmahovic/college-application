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
use App\Transformers\ApplicationTransformer;

class ApplicationController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function show() {
        $countries = Country::all();
        $cities = City::all();
        $citizens = Citizen::all();
        $faculties = Faculty::all();
        $districts = District::all();
        $facultyPrograms = FacultyProgram::all();
        $education_types = EducationType::all();
        $graduation_types = GraduationType::all();
        $middle_schooles = MiddleSchool::all();

        return $this->response->array([
            'countries'=> $countries,
            'cities'=> $cities,
            'citizens'=> $citizens,
            'faculties'=> $faculties,
            'facultyPrograms'=> $facultyPrograms,
            'districts'=> $districts,
            'education_types'=> $education_types,
            'graduation_types'=> $graduation_types,
            'middle_schooles'=> $middle_schooles
        ]);
    }

    public function create(ApplicationRequest $request) {
        $application = Application::create(request(
            ['emso', 'date_of_birth', 'user_id', 'profession_id', 'middle_school_id', 'education_type_id', 
            'application_interval_id','country_id', 'citizen_id', 'applications_cities_id'
            ]
        ));
        
        return response()->setStatusCode(201, 'The application is created successfully!');
    }

    public function sifranti()
    {
        // TODO(Vid): vrni vse sifrante
    }

    public function active()
    {
        $user = $this->request->user();
        if($user->cannot('view-active', Application::class)) {
            return $this->response->errorUnauthorized();
        }

        $application = $user->applications()->active()->latest()->first();

        if($application == null) {
            $application = Application::create([
                'status' => 'created',
                'user_id' => $user->id,
                'education_type_id' => EducationType::first()->id,
                'application_interval_id' => $application->interval()->current()->first()->id,
                'nationality_type_id' => '',
                'profession_id' => '',
                'middle_school_id' => '',
                'citizen_id' => '',
                'application_city_id' => ''
            ]);
        }

        return $this->response->item(Application::with('citizen')->first(), new ApplicationTransformer);
    }

}
