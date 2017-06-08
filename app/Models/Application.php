<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;

class Application extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    const PERMANENT_ADDRESS_TYPE = 0;
    const MAILING_ADDRESS_TYPE = 1;

    protected $cascadeDeletes = ['applicationCities', 'applicationsPrograms'];

    static $filters = [];

    protected $table = 'applications';

    protected $fillable = ['user_id', 'emso', 'gender', 'date_of_birth', 'phone', 'country_id', 'citizen_id', 'district_id',
        'middle_school_id', 'profession_id', 'education_type_id', 'graduation_type_id', 'status'];

    public function applicationCities() {
        return $this->belongsTo(ApplicationCity::class);
    }

    public function applicationsPrograms() {
        return $this->hasMany(ApplicationsPrograms::class);
    }

    public function applicationsProgramsId($id) {
        return $this->hasMany(ApplicationsPrograms::class)->where('faculty_program_id', $id);
    }

    public function applicationsAbilityTests() {
        return $this->hasMany(ApplicationAbilityTest::class);
    }

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

    public function citizen(){
        return $this->belongsTo(Citizen::class);
    }

    public function mailingAddress()
    {
        return $this->cities()->wherePivot('address_type', self::MAILING_ADDRESS_TYPE);
    }

    public function permanentAddress()
    {
        return $this->cities()->wherePivot('address_type', self::PERMANENT_ADDRESS_TYPE);
    }

    public function cities()
    {
        return $this
            ->belongsToMany(City::class, 'application_cities', 'application_id', 'city_id')
            ->withPivot('address', 'address_type');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'application_cities', 'application_id', 'country_id')
            ->withPivot('address', 'address_type');
    }

    public function permanentCountry()
    {
        return $this->countries()->wherePivot('address_type', self::PERMANENT_ADDRESS_TYPE);
    }

    public function mailingCountry()
    {
        return $this->countries()->wherePivot('address_type', self::MAILING_ADDRESS_TYPE);
    }

    public function countryOfBirth()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function districtOfBirth()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function applicationAbilityTests()
    {
        return $this->hasMany(ApplicationAbilityTest::class, 'id');
    }

    public function wishes()
    {
        return $this
            ->belongsToMany(FacultyProgram::class, 'applications_programs', 'application_id', 'faculty_program_id')
            ->withPivot('status', 'choice_number', 'points');
    }

    public function acceptedWish()
    {
        return $this->wishes()->wherePivot('status', true);
    }

    public function firstWish()
    {
        return $this->wishes()->wherePivot('choice_number', 1);
    }

    public function secondWish()
    {
        return $this->wishes()->wherePivot('choice_number', 2);
    }

    public function thirdWish()
    {
        return $this->wishes()->wherePivot('choice_number', 3);
    }

    public function specificWish($id)
    {
        return $this->wishes()->wherePivot('faculty_program_id', $id);
    }

    public function grades() {
        return $this->hasMany(Grade::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function scopeFiled($scope) {
        return $scope->where('applications.status', 'filed');
    }

    public function scopeActive($scope) {
        return $scope->whereIn('applications.status', ['created', 'saved']);
    }

    public function scopeAccepted($query) {
        return $query->has('acceptedWish');
    }

    public function scopeFromEuOrSlovenia($query)
    {
        return $query->whereIn('citizen_id', Citizen::fromSloveniaOrEu()->pluck('id')->toArray());
    }

    public function scopeFromOtherCountries($query)
    {
        return $query->whereIn('citizen_id', Citizen::fromOtherCountries()->pluck('id')->toArray());
    }

    public static function createTemplate(User $applicant)
    {
        $app = new static;
        $app->user = $applicant;
        return $app;
    }
}
