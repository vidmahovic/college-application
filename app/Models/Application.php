<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Application extends Model // PRIJAVA
{
//    protected $table = 'applications';
//
//    protected $fillable = ['emso', 'date_of_birth', 'user_id', 'profession_id', 'middle_school_id',
//        'education_type_id', 'application_interval_id','country_id', 'citizen_id', 'applications_cities_id'];
//    protected $guarded = ['id', ]; // Fillable je nasprotje od guarded, tako da če imaš manj atributov za zavarovat, samo dodaj te atribute v guarded.

//    protected $casts = [
//        'emso' => 'integer',
//        'date_of_birth' => 'date',
//        'user_id' => 'integer',
//        'profession_id' => 'integer',
//        'education_type_id' => 'integer',
//        'middle_school_id' => 'integer',
//        'application_interval_id' => 'integer',
//        'country_id' => 'integer',
//        'citizen_id' => 'integer',
//        'applications_cities_id' => 'integer'
//    ];



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
        return $this->whereIn('status', [0, 1]);
    }
}
