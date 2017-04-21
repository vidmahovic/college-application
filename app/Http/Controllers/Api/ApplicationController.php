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
use Dingo\Api\Exception\ResourceException;

class ApplicationController extends ApiController {

    public function create() {

        $application = Application::create(request(
            ['emso', 'date_of_birth', 'user_id', 'profession_id', 'middle_school_id', 'education_type_id', 
            'application_interval_id','country_id', 'citizen_id', 'applications_cities_id'
            ]
        ));

        return $this->response->created('Application created');
    }

    public function sifranti()
    {
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

    public function active()
    {
        $user = $this->request->user();

        if ($user->cannot('view-active', Application::class)) {
            return $this->response->errorUnauthorized();
        }

        $application = $user->applications()->active()->latest()->first();

        if($application == null) {
            $application = Application::createTemplate($user->id);
        }

        return $this->response->item($application, new ApplicationTransformer);
    }


    public function archive($id)
    {
        $application = Application::find($id);

        if($application == null) {
            throw new ResourceException('Resource not found');
        }

        if($this->request->user()->cannot('archive', $application)) {
            return $this->response->errorUnauthorized();
        }

        $application->delete();
        return $this->response->noContent('Resource archived');
    }
}
