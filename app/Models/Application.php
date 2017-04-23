<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    static $filters = [];

    public function middleSchool() {
        return $this->belongsTo(MiddleSchool::class, 'middle_school_id');
    }

    public function education() {
        return $this->belongsTo(EducationType::class, 'education_type_id');
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function nationality() {
        return $this->belongsTo(NationalityType::class, 'nationality_type_id');
    }

    public function interval(){
        return $this->belongsTo(ApplicationInterval::class, 'application_interval_id');
    }

    public function graduation(){
        return $this->belongsTo(GraduationType::class, 'graduation_type_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function citizen(){
        return $this->belongsTo(Citizen::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function applicationCities()
    {
        return $this->hasMany(ApplicationCity::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function scopeFiled($scope) {
        return $this->where('status', 'filed');
    }

    public function scopeActive($scope) {
        return $this->whereIn('status', ['created', 'saved']);
    }

    public static function createTemplate(User $applicant) {
        $app = new \StdClass;

        $app->applicant = $applicant;
        $app->date_of_birth = null;
        // TODO: Add other attributes to stdClass and return the object.

        return $app;

//        $application = new static;
//        $application->status = 'created';
//        $application->user_id = $user_id;
//        $application->education_type_id = EducationType::orderBy('name')->first()->id;
//        $application->graduation_type_id = GraduationType::orderBy('name')->first()->id;
//        $application->application_interval_id = ApplicationInterval::current()->first()->id;
//        $application->nationality_type_id = NationalityType::orderBy('type')->first()->id;
//        $application->profession_id = Profession::orderBy('name')->first()->id;
//        $application->middle_school_id = MiddleSchool::orderBy('name')->first()->id;
//        $application->citizen_id = Citizen::orderBy('name')->first()->id;
//
//        $application->save();
//
//        return $application;
    }
}
