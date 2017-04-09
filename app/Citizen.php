<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model // DRZAVLJAN
{
    protected $table = 'citizens';

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