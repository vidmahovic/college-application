<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionsProfession extends Model // PIVOT MED POGOJI IN POKLICI
{
    protected $table = 'conditions_profession';

    protected $fillable = ['enrollment_condition_id','profession_id'];

    public function enrollmentCondition()
    {
        return $this->belongsTo(EnrollmentCondition::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}