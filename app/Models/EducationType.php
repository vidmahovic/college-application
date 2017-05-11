<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationType extends Model // IZOBRAZBA - KLASIUS SRV
{
    protected $table = 'education_types';

    protected $fillable = ['id', 'name', 'level', 'graduation_type'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'level' => 'string',
        'graduation_type' => 'string'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
