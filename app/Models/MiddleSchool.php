<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiddleSchool extends Model // SREDNJA ŠOLA
{
    protected $table = 'middle_schools';

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
