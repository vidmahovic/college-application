<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use App\Models\FacultyProgram;
use App\Models\Citizen;
use App\Models\City;
use App\Models\District;
use App\Models\Application;
use App\Models\ApplicationCity;
use App\Models\ApplicationInterval;
use App\Models\ApplicationsPrograms;
use App\Models\GraduationType;
use App\Models\EducationType;
use App\Models\Country;
use App\Models\MiddleSchool;
use App\Transformers\ApplicationTransformer;
use Dingo\Api\Exception\ResourceException;
use App\Validators\ApplicationValidator;
use Illuminate\Http\Request;

class ApplicationController extends ApiController {

    protected $validator;

    public function __construct(ApplicationValidator $validator){
        $this->validator = $validator;
    }

    public function create(Request $request) { // shrani, vendar ne odda prijave

        if(! $this->validator->validate($request->all())){
            $errors = $this->validator->errors()->toArray(); // return redirect()->back()->withErrors($this->validator->errors())->withInput();
            return $this->response->error($errors, 400); 
        }

        $application = Application::create(request(
            ['user_id', 'emso', 'gender', 'date_of_birth', 'phone', 'country_id', 'citizen_id', 'district_id',
                'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id'
            ]
        ));

        // status -> default -> created
        $application->application_interval_id = ApplicationInterval::latest()->first();
        $application->save();

        $aid = $application->id;

        // create pivot tables cities

        $permanent_address = ApplicationCity::create([
                'application_id' => $aid,
                'city_id' => $request->input('permanent_applications_cities_id'),
                'address' => $request->input('permanent_address'),
                'address_type' => 'permanent']);

        $mailing_address = ApplicationCity::create([
                'application_id' => $aid,
                'city_id' => $request->input('mailing_applications_cities_id'),
                'address' => $request->input('mailing_address'),
                'address_type' => 'mailing']);

        // create pivot tables programs -> min 1 wish, max 3 wishes
        // 1 wish required

        $faculties = Faculty::all()->pluck('id')->toArray();
        $wishes = ($request->input('wishes'))->toJson;

        /*
             [{ faculty_id, is_double_degre, programs_id: [p1_id,p2_id]}, {...}]
        */

        // TODO
        /*
            $ap1 = ApplicationsPrograms::create([
                'application_id' => $aid,
                'faculty_program_id' => $request->input('faculty_p_1'),
                'status' => false,
                'choice_number' => 1]);
        */

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

        return $this->response->noContent();
    }
}
