<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model // PRIJAVA
{
    protected $table = 'applications';

    protected $fillable = ['emso', 'date_of_birth', 'user_id', 'profession_id', 'middle_school_id', 
        'education_type_id', 'application_interval_id','country_id', 'citizen_id', 'applications_cities_id'];
    protected $guarded = ['id'];

    protected $casts = [
        'emso' => 'integer',
        'date_of_birth' => 'date',
        'user_id' => 'integer',
        'profession_id' => 'integer',
        'education_type_id' => 'integer',
        'middle_school_id' => 'integer',
        'application_interval_id' => 'integer',
        'country_id' => 'integer',
        'citizen_id' => 'integer',
        'applications_cities_id' => 'integer'
    ];

    public function middleSchool(){
        return $this->belongsTo(MiddleSchool::class);
    }

    public function educationType(){
        return $this->belongsTo(EducationType::class);
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    public function applicationInterval(){
        return $this->belongsTo(ApplicationInterval::class);
    }

    public function graduationType(){
        return $this->belongsTo(GraduationType::class);
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
}