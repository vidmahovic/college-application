<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationsPrograms extends Model // PIVOT MED VPISNIM LISTOM IN PROGRAMOM
{
    protected $table = 'applications_programs';

    protected $fillable = ['id', 'application_id', 'program_id', 'status', 'choice_number'];
    //protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'application_id' => 'integer',
        'program_id' => 'integer',
        'status' => 'boolean', // sprejet, zavrnjen
        'choice_number' => 'integer' //1,2,3
    ];

    public function facultyProgram(){
        return $this->belongsTo(FacultyProgram::class);
    }
}