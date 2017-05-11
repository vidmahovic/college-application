<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentCondition extends Model // POGOJI
{
    protected $table = 'enrollment_conditions';

    public $timestamps = false;

    protected $fillable = ['faculty_program_id', 'name', 'type', 'conditions_subject_id', 'conditions_profession_id', 'weight'];
        // type -> 0 (splošna in poklicna matura), 1 (splošna matura), 2 (poklicna matura)
        // conditions_profession_id -> nullable, če je subject
        // conditions_subject_id -> nullable, če je profession
        // weight -> nullable, če je profession

    public function facultyProgram(){
        return $this->belongsTo(FacultyProgram::class);
    }

    public function conditionsProfession(){
        return $this->hasMany(ConditionsProfession::class);
    }

    public function conditionsSubject(){
        return $this->hasMany(ConditionsSubject::class);
    }
}