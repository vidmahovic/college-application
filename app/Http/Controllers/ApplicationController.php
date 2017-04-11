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
        $districts = District::all();
        $universities = University::all();
        $faculties = Faculty::all();
        $facultyPrograms = FacultyProgram::all()->with('faculty');
        $middleSchools = MiddleSchool::all();
        $professions = Profession::all();   
        $education_types = EducationType::all();
        $graduation_types = GraduationType::all();

        $application = Application::with('educationType','profession', 'graduationType', 'citizen', 'country', 'district')
            ->findOrFail($id);

        return [$countries, $cities, $citizens, $districts, $universities,  $faculties, $facultyPrograms, 
            $middleSchools, $professions, $education_types, $graduation_types, $application];
    }

    public function create(ApplicationRequest $request){
        $application = Application::create(request()->all());

        return response()->setStatusCode(201, 'The application was created successfully!');
    }

    public function update($id, ApplicationRequest $request){
        $application = Application::findOrFail($id);
        $application->update(request()->all()); 

        return response()->setStatusCode(200, 'The application was updated successfully!');
    }

    public function delete($id){
        $interval = ApplicationInterval::latest()->first();
        $start_date = $interval->start_at->format('Y-m-d');
        $end_date = $interval->ends_at->format('Y-m-d');
       
        $curr_date = date('Y-m-d'));
        if($curr_date >= $start_date && $curr_date <= $end_date){ // TODO: razen, če je vpisna služba, ona lahko briše po roku
            $application = Application::find($id);
            $application->delete(); // soft delete

            return response()->setStatusCode(204, 'The application was deleted successfully!');
        }
        else {
            return response()->setStatusCode(403, 'The application delete was denied!');
        }
        
    }
}
