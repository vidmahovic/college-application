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
use App\Transformers\AcceptedApplicationsTransformer;
use App\Transformers\ApplicationTransformer;
use App\Transformers\ApplicationTemplateTransformer;
use CollegeApplication\Search\ApplicationSearch\ApplicationSearch;
use Dingo\Api\Exception\ResourceException;
use App\Validators\ApplicationValidator;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApplicationController extends ApiController {

    protected $validator;
    protected $search;

    public function __construct(Request $request, ApplicationValidator $validator, ApplicationSearch $search) {
        $this->validator = $validator;
        $this->search = $search;
        parent::__construct($request);
    }

    public function accepted()
    {
        $user = $this->request->user();

        if($user->cannot('get', Application::class))
            throw new UnauthorizedHttpException('Basic');

        if($user->isReferent())
            $this->request['filters'] = array_merge($this->request['filters'], ['faculty_id' => $user->faculty_id]);

        $applications_si_eu = $this->search
            ->applyFiltersFromRequest($this->request)
            ->accepted()->fromEuOrSlovenia()->get();
        $applications_other = $this->search
            ->applyFiltersFromRequest($this->request)
            ->accepted()->fromOtherCountries()->get();

        $apps = new \stdClass;
        $apps->fromEu = $this->groupAccepted($applications_si_eu);
        $apps->fromOther = $this->groupAccepted($applications_other);

        return $this->response->item($apps, new AcceptedApplicationsTransformer);
    }

    public function index()
    {
        $user = $this->request->user();

        if($user->cannot('get', Application::class))
            throw new UnauthorizedHttpException('Basic');

        // If user is a referent for the faculty, allow him to view only applications that are connected to his faculty.
        if($user->isReferent())
            $this->request['filters'] = array_merge($this->request['filters'], ['faculty_id' => $user->faculty_id]);

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
            $this->request['filters'] = array_merge($this->request['filters'], ['faculty_id' => $user->faculty_id]);

        // Send only applications with status 'filed'
        $applications = $this->search
            ->applyFiltersFromRequest($this->request)
            ->filed()
            ->paginate($this->request->get('perPage') ?? 30);

        return $this->response->paginator($applications, new ApplicationTransformer);
    }

    public function create()
    {
        $user = $this->request->user();

        if(!($user->isStudent() && $user->applications()->count() == 0)){
            return $this->response->errorBadRequest("Application already exists!");
        }

        if ($user->cannot('create', Application::class)) {
            return $this->response->errorUnauthorized();
        }
        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        $wish_ids = collect(array_pluck($this->request->input('wishes'), 'programs_id'))->flatten();

        if($wish_ids->isEmpty()) {
            throw new BadRequestHttpException("At least one wish must be provided.");
        }

        $application = Application::create($this->request->only(
            'user_id', 'emso', 'gender', 'date_of_birth', 'phone', 'citizen_id', 'district_id',
                'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id'
        ));

        $application->status = $this->request->input('status') ?? 'created';
        $application->application_interval_id = ApplicationInterval::current()->first()->id;
        // Save birth address data
        $application->district_id = $this->request->input('district_id');
        $application->country_id = $this->request->input('country_id');

        $application->save();

        $permanent_address = City::find($this->request->input('permanent_applications_cities_id'));
        $mailing_address = City::find($this->request->input('mailing_applications_cities_id'));

        // Create pivot tables for addresses.
        $application->cities()->detach();
        $application->cities()->attach([
            $permanent_address->id => [
                'address' => $this->request->input('permanent_address'),
                'address_type' => 0,
                'country_id' => $this->request->input('permanent_country_id')
            ]
        ]);
        $application->cities()->attach([
            $mailing_address->id => [
                'address' => $this->request->input('mailing_address'),
                'address_type' => 1,
                'country_id' => $this->request->input('mailing_country_id')
            ]
        ]);

        $enopredmetni = FacultyProgram::all()->where('allow_double_degree',false)->pluck('id')->toArray();
        $dvopredmetni = FacultyProgram::all()->where('allow_double_degree',true)->pluck('id')->toArray();
        $wishes = $this->request->input('wishes');

        for($i = 0; $i < count($wishes); $i = $i + 1){
            $current = $wishes[$i];
            $num = count($current["programs_id"]);
            /*
            if($num > 2){
                return $this->response->errorBadRequest("Too many wishes!");
            }
            if($num == 1) {
                if(!in_array($current["programs_id"][0], $enopredmetni)) {
                    return $this->response->errorBadRequest("Invalid wish, needs another double degree");
                }
            }
            if($num == 2) {
                if(!(in_array($current["programs_id"][0],$dvopredmetni) && in_array($current["programs_id"][1],$dvopredmetni))){
                    return $this->response->errorBadRequest("Invalid wish, one is double degree other is not!");
                }
            }
            */
            for($j = 0; $j < $num; $j = $j + 1){
                $program = $current["programs_id"][$j];
                $ap = ApplicationsPrograms::create([
                    'application_id' => $application->id,
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
        //->active()
        $application = $user->applications()->latest()->first();
        if($application == null) {
            return $this->response->item(Application::createTemplate($user), new ApplicationTemplateTransformer);
        }

        return $this->response->item($application, new ApplicationTransformer);
    }


    public function archive($id)
    {
        $user = $this->request->user();
        $application = Application::find($id);

        if ($user->cannot('archive', $application)) {
            return $this->response->errorUnauthorized();
        }


        if($application->status != 'filed'){
            return $this->response->errorBadRequest("Application cannot be deleted!");
        }

        $application->delete();

        return $this->response->noContent();
    }

    public function update($id)
    {
        $user = $this->request->user();
        // if ($user->cannot('update', Application::class)) {
        //     return $this->response->errorUnauthorized();
        // }
        $application = Application::findOrFail($id);

        if($application->status == 'filed'){
            return $this->response->errorBadRequest("Application already filed!");
        }

        if(! $this->validator->validate($this->request->all())){
            $errors = $this->validator->errors();
            return $this->response->errorBadRequest($errors);
        }

        $wish_ids = collect(array_pluck($this->request->input('wishes'), 'programs_id'))->flatten();

        if($wish_ids->isEmpty()) {
            throw new BadRequestHttpException("At least one wish must be provided.");
        }

        $application->update($this->request->only(
            'user_id', 'emso', 'gender', 'date_of_birth', 'country_id', 'phone', 'citizen_id', 'district_id',
            'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id'
        ));

        $application->status = $this->request->input('status') ?? 'created';
        $application->application_interval_id = ApplicationInterval::current()->first()->id;
        // Save birth address data
        $application->district_id = $this->request->input('district_id');
        $application->country_id = $this->request->input('country_id');

        $application->save();

        $cities = (ApplicationCity::all()->where('application_id',$id)->pluck('id'))->toArray();
        for($i = 0; $i < count($cities); $i = $i + 1){
            ApplicationCity::destroy($cities[$i]);
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

        $curr_wishes = ApplicationsPrograms::all()->where('application_id',$id)->pluck('id');
        for($i = 0; $i < count($curr_wishes); $i = $i + 1){
            ApplicationsPrograms::destroy($curr_wishes[$i]);
        }

        $enopredmetni = FacultyProgram::all()->where('allow_double_degree',false)->pluck('id')->toArray();
        $dvopredmetni = FacultyProgram::all()->where('allow_double_degree',true)->pluck('id')->toArray();
        $wishes = $this->request->input('wishes');

        for($i = 0; $i < count($wishes); $i = $i + 1){
            $current = $wishes[$i];
            $num = count($current["programs_id"]);
            /*
            if($num > 2){
                return $this->response->errorBadRequest("Too many wishes!");
            }
            if($num == 1) {
                if(!in_array($current["programs_id"][0], $enopredmetni)) {
                    return $this->response->errorBadRequest("Invalid wish, needs another double degree");
                }
            }
            if($num == 2) {
                if(!(in_array($current["programs_id"][0],$dvopredmetni) && in_array($current["programs_id"][1],$dvopredmetni))){
                    return $this->response->errorBadRequest("Invalid wish, one is double degree other is not!");
                }
            }
            */
            for($j = 0; $j < $num; $j = $j + 1){
                $program = $current["programs_id"][$j];
                $ap = ApplicationsPrograms::create([
                    'application_id' => $application->id,
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

    private function groupAccepted(Collection $applications) {
        return $applications->load('acceptedWish.faculty')->sort(function($appA, $appB) {
            $programA = $appA->acceptedWish->first();
            $programB = $appB->acceptedWish->first();
            if($programA->faculty->name === $programB->faculty->name) {
                if($programA->name === $programB->name) {
                    if($programA->type === $programB->type) {
                        return $programB->pivot->points <=> $programA->pivot->points;
                    }
                    return $programA->type <=> $programB->type;
                }
                return $programA->name <=> $programB->name;
            }
            return $programA->faculty->name <=> $programB->faculty->name;
        });
    }
}
