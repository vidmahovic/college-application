<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model // OBCINA
{
    protected $table = 'districts';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}