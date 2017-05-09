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

//    public function applicationCities()
//    {
//        return $this->hasMany(ApplicationCity::class);
//    }

    public function applications()
    {
        return $this
            ->belongsToMany(Application::class, 'application_cities', 'city_id', 'application_id')
            ->withPivot('address', 'address_type');
    }
}
