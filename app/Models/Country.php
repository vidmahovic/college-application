<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model // DRŽAVA
{
    protected $table = 'countries';

    protected $fillable = ['id', 'name', 'eu'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'eu' => 'boolean'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
