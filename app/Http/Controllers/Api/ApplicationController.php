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
use Dingo\Api\Http\Request;

class ApplicationController extends ApiController {

    protected $validator;

    public function __construct(Request $request, ApplicationValidator $validator){
        $this->validator = $validator;
        parent::__construct($request);
    }

    public function create() // shrani, vendar ne odda prijave
    {
        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors(); // return redirect()->back()->withErrors($this->validator->errors())->withInput();
            return $this->response->errorBadRequest($errors);
        }

        if(! $this->request->input('wishes')){
            return $this->response->errorBadRequest("You must insert atleast one wish!");
        }

        $application = Application::create($this->request->only(
            'user_id', 'emso', 'gender', 'date_of_birth', 'phone', 'country_id', 'citizen_id', 'district_id',
                'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id'
        ));

        // status -> default -> created
        $application->application_interval_id = ApplicationInterval::latest()->first();
        $application->save();

        $aid = $application->id;

        // create pivot tables cities

        $permanent_address = ApplicationCity::create([
                'application_id' => $aid,
                'city_id' => $this->request->input('permanent_applications_cities_id'),
                'address' => $this->request->input('permanent_address'),
                'address_type' => 'permanent']);

        $mailing_address = ApplicationCity::create([
                'application_id' => $aid,
                'city_id' => $this->request->input('mailing_applications_cities_id'),
                'address' => $this->request->input('mailing_address'),
                'address_type' => 'mailing']);

        // create pivot tables programs -> min 1 wish, max 3 wishes

        $faculties = Faculty::all()->pluck('id')->toArray();
        $wishes = ($this->request->input('wishes'))->toJson;

        // [{faculty_id, is_double_degree, programs_id: [p1_id,p2_id]}, {faculty_id, is_double_degree, programs_id: [p1_id]}]

        for($i = 1; $i <= 3; $i++){
            $wish = $wishes[$i];
            if($wish["is_double_degree"] == false && in_array($wish["programs_id"],$faculties)){
                $ap = ApplicationsPrograms::create([
                    'application_id' => $aid,
                    'faculty_program_id' => $wish["programs_id"],
                    'status' => false,
                    'choice_number' => $i]);
            }
            else if($wish["is_double_degree"] == true && in_array($wish["programs_id"][0],$faculties) && in_array($wish["programs_id"][1],$faculties)){
                for($j = 0; $j <= 1; $j++){
                    $ap = ApplicationsPrograms::create([
                        'application_id' => $aid,
                        'faculty_program_id' => $wish["programs_id"][$j],
                        'status' => false,
                        'choice_number' => $i]);
                }
            }
        }

        return $this->response->created('Application created');
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

    public function update($id)
    {
        $application = Application::findOrFail($id);

        if($application == null) {
            return $this->response->errorNotFound();
        }

        // TODO: update
    }

    public function store($id)
    {
        $application = Application::findOrFail($id);

        if($application == null) {
            return $this->response->errorNotFound();
        }

        // TODO: store
        // $application->status = 'filed';
        // KAKSNI SO STATUSI -> created, save, filed?
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
}
