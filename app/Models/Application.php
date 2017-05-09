<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Application extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['applicationCities', 'applicationsPrograms'];

    static $filters = [];

    protected $table = 'applications';

    protected $fillable = ['user_id', 'emso', 'gender', 'date_of_birth', 'phone', 'country_id', 'citizen_id', 'district_id',
        'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id', 'status'];

    public function middleSchool() {
        return $this->belongsTo(MiddleSchool::class, 'middle_school_id');
    }

    public function education() {
        return $this->belongsTo(EducationType::class, 'education_type_id');
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
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

    public function cities()
    {
        return $this->belongsToMany(City::class, 'application_cities', 'application_id', 'city_id')
            ->withPivot(['address_type', 'address', 'country_name']);
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

    public function applicationsPrograms()
    {
        return $this->hasMany(ApplicationsPrograms::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function scopeFiled($scope) {
        return $scope->where('status', 'filed');
    }

    public function scopeActive($scope) {
        return $scope->whereIn('status', ['created', 'saved']);
    }

    public static function createTemplate(User $applicant)
    {
        $app = new static;
        $app->user = $applicant;
        return $app;
    }
}
