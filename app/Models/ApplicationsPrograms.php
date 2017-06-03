<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationsPrograms extends Model // PIVOT MED VPISNIM LISTOM IN PROGRAMOM
{
    protected $table = 'applications_programs';
    protected $fillable = ['application_id', 'faculty_program_id', 'status', 'choice_number'];
    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'application_id' => 'integer',
        'faculty_program_id' => 'string',
        'status' => 'boolean', // sprejet, zavrnjen
        'choice_number' => 'integer' //1,2,3
    ];

    public function facultyProgram() {
        return $this->belongsTo(FacultyProgram::class);
    }

    public function application() {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
