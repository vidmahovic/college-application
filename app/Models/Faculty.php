<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model // VISOKOSOLSKI ZAVOD
{
    protected $table = 'faculties';

    protected $fillable = ['id', 'name', 'acronym', 'id_district', 'id_university'];
    //protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'acronym' => 'string',
        'id_district' => 'integer',
        'id_university' => 'integer'
    ];

    public function facultyPrograms(){
        return $this->hasMany(FacultyProgram::class);
    }

    public function university(){
        return $this->belongsTo(University::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }
}
