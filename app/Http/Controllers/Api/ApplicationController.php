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
use App\Transformers\ApplicationTemplateTransformer;
use CollegeApplication\Search\ApplicationSearch\ApplicationSearch;
use Dingo\Api\Exception\ResourceException;
use App\Validators\ApplicationValidator;
use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApplicationController extends ApiController {

    protected $validator;
    protected $search;

    public function __construct(Request $request, ApplicationValidator $validator, ApplicationSearch $search) {
        $this->validator = $validator;
        $this->search = $search;
        parent::__construct($request);
    }

    public function index()
    {
        $user = $this->request->user();

        if($user->cannot('get', Application::class))
            throw new UnauthorizedHttpException('Basic');

        // If user is a referent for the faculty, allow him to view only applications that are connected to his faculty.
        if($user->isReferent())
            $this->request['filters'] = ['faculty_id' => $user->faculty_id];

        // Send only applications with status 'filed'
        $applications = $this->search->applyFiltersFromRequest($this->request)->filed()->get();

        return $this->response->collection($applications, new ApplicationTransformer)->addMeta('count', $applications->count());
    }

    public function paginate()
    {
        $user = $this->request->user();

        if($user->cannot('paginate', Application::class))
            throw new UnauthorizedHttpException('Basic');

        // If user is a referent for the faculty, allow him to view only applications that are connected to his faculty.
        if($user->isReferent())
            $this->request['filters'] = ['faculty_id' => $user->faculty_id];

        // Send only applications with status 'filed'
        $applications = $this->search
            ->applyFiltersFromRequest($this->request)
            ->filed()
            ->paginate($this->request->get('perPage') ?? 30);

        return $this->response->paginator($applications, new ApplicationTransformer);
    }

    public function create()
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
