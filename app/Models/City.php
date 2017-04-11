<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model // POŠTA
{
    protected $table = 'cities';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function applicationCities()
    {
        return $this->hasMany(ApplicationCity::class);
    }
}
