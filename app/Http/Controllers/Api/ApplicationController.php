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
use App\Models\Profession;
use App\Transformers\ApplicationTransformer;
use App\Transformers\ApplicationTemplateTransformer;
use Dingo\Api\Exception\ResourceException;
use App\Validators\ApplicationValidator;
use Dingo\Api\Http\Request;

class ApplicationController extends ApiController {

    protected $validator;

    public function __construct(Request $request, ApplicationValidator $validator){
        $this->validator = $validator;
        parent::__construct($request);
    }

    public function create()
    {
        $user = $this->request->user();

        if ($user->cannot('create', Application::class)) {
            return $this->response->errorUnauthorized();
        }

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
        if($this->request->input('status') == 'file'){
            $application->status = 'filed';
        }
        $application->application_interval_id = ApplicationInterval::latest()->first();
        $application->save();

        $aid = $application->id;

        // create pivot tables cities

        $permanent_address = ApplicationCity::create([
                'application_id' => $aid,
                'city_id' => $this->request->input('permanent_applications_cities_id'),
                'address' => $this->request->input('permanent_address'),
                'country_name' => $this->request->input('permanent_country_name'),
                'address_type' => 0]);

        $mailing_address = ApplicationCity::create([
                'application_id' => $aid,
                'city_id' => $this->request->input('mailing_applications_cities_id'),
                'address' => $this->request->input('mailing_address'),
                'country_name' => $this->request->input('mailing_country_name'),
                'address_type' => 1]);

        // create pivot tables programs -> min 1 wish, max 3 wishes

        $faculties = Faculty::all()->pluck('id')->toArray();
        $wishes = json_decode($this->request->input('wishes'), true);

        for($i = 0; $i < count($wishes); $i = $i + 1){
            $current = $wishes[$i];
            $num = count($current["programs_id"]);
            // validate wishes
            for($j = 0; $j < $num; $j = $j + 1){
                $program = $current["programs_id"][$j];
                $ap = ApplicationsPrograms::create([
                    'application_id' => $aid,
                    'faculty_program_id' => $program,
                    'status' => false,
                    'choice_number' => $i+1]);
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
            return $this->response->item(Application::createTemplate($user), new ApplicationTemplateTransformer);
        }

        return $this->response->item($application, new ApplicationTransformer);
    }


    public function archive($id)
    {
        $user = $this->request->user();

        if ($user->cannot('archive', Application::class)) {
            return $this->response->errorUnauthorized();
        }

        $application = Application::find($id);

        if($application->status != 'filed'){
            return $this->response->errorBadRequest("Application cannot be deleted!");
        }

        $application->delete();

        return $this->response->noContent();
    }

    public function update($id)
    {
        $user = $this->request->user();

        if ($user->cannot('update', Application::class)) {
            return $this->response->errorUnauthorized();
        }

        $application = Application::findOrFail($id);
        if($application->status == 'filed'){
            return $this->response->errorBadRequest("Application already filed!");
        }

        if($application == null) {
            return $this->response->errorNotFound();
        }

        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        if(! $this->request->input('wishes')){
            return $this->response->errorBadRequest("You must insert atleast one wish!");
        }

        $application->update($this->request->only(
            'user_id', 'emso', 'gender', 'date_of_birth', 'phone', 'country_id', 'citizen_id', 'district_id',
            'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id'
        ));

        if($this->request->input('status') == 'file'){
            $application->status = 'filed';
        }
        $application->application_interval_id = ApplicationInterval::latest()->first();
        $application->save();

        $cities = (ApplicationCity::all()->where('application_id',$id)->pluck('id'))->toArray();
        for($i = 0; $i < count($cities); $i = $i + 1){
            ApplicationCity::destroy($cities[$i]);
        }

        $programs = (ApplicationsPrograms::all()->where('application_id',$id)->pluck('id'))->toArray();
        for($i = 0; $i < count($programs); $i = $i + 1){
            ApplicationsPrograms::destroy($programs[$i]);
        }

        $permanent_address = ApplicationCity::create([
            'application_id' => $id,
            'city_id' => $this->request->input('permanent_applications_cities_id'),
            'address' => $this->request->input('permanent_address'),
            'country_id' => $this->request->input('permanent_country_id'),
            'address_type' => 0]);

        $mailing_address = ApplicationCity::create([
            'application_id' => $id,
            'city_id' => $this->request->input('mailing_applications_cities_id'),
            'address' => $this->request->input('mailing_address'),
            'country_id' => $this->request->input('mailing_country_id'),
            'address_type' => 1]);

        $wishes = json_decode($this->request->input('wishes'), true);

        for($i = 0; $i < count($wishes); $i = $i + 1){
            $current = $wishes[$i];
            $num = count($current["programs_id"]);
            // validate wishes
            for($j = 0; $j < $num; $j = $j + 1){
                $program = $current["programs_id"][$j];
                $ap = ApplicationsPrograms::create([
                    'application_id' => $id,
                    'faculty_program_id' => $program,
                    'status' => false,
                    'choice_number' => $i+1]);
            }
        }

        return $this->response->created('Application updated');
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
        $professions = Profession::all();

        return $this->response->array([
            'countries'=> $countries,
            'cities'=> $cities,
            'citizens'=> $citizens,
            'faculties'=> $faculties,
            'facultyPrograms'=> $facultyPrograms,
            'districts'=> $districts,
            'education_types'=> $education_types,
            'graduation_types'=> $graduation_types,
            'middle_schooles'=> $middle_schooles,
            'professions'=> $professions
        ]);
    }
}
