<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table = 'faculties';

    protected $fillable = ['name', 'address', 'city_id'];
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'city_id' => 'integer'
    ];

    public function facultyPrograms(){
        return $this->hasMany(FacultyProgram::class);
    }

    public function city(){
        return $this->BelongsTo(City::class);
    }
}