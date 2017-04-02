<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = ['name', 'zip_code', 'state'];
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'zip_code' => 'string',
        'state' => 'integer'
    ];

    public function faculties(){
        return $this->hasMany(Faculty::class);
    }
}