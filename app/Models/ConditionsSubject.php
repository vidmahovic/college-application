<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionsSubject extends Model // PIVOT MED POGOJI IN PREDMETI
{
    protected $table = 'conditions_subject';

    protected $fillable = ['enrollment_condition_id','subject_id'];

    public function enrollmentCondition()
    {
        return $this->belongsTo(EnrollmentCondition::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}