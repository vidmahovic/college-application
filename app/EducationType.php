<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationType extends Model // IZOBRAZBA
{
    protected $table = 'education_types';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}