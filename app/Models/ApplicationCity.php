<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationCity extends Model // PIVOT MED PIJAVO IN POŠTO
{
    protected $table = 'application_cities';

    protected $fillable = ['application_id', 'city_id', 'address', 'address_type'];

    protected $guarded = ['id'];

    protected $casts = [
        'application_id' => 'integer',
        'city_id' => 'integer',
        'address' => 'string',
        'address_type' => 'integer'
    ];

     public function city(){
        return $this->belongsTo(City::class);
    }

     public function application(){
        return $this->belongsTo(Application::class);
    }
}