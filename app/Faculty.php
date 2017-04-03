<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model // VISOKOSOLSKI ZAVOD
{
    protected $table = 'faculties';

    protected $fillable = ['name', 'acronym', 'district_id', 'universtiy_id'];
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'acronym' => 'string',
        'district_id' => 'integer',
        'universtiy_id' => 'integer'
    ];

    public function facultyPrograms(){
        return $this->hasMany(FacultyProgram::class);
    }
}