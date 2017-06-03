<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbilityTest extends Model // TEST SPOSOBNOSTI
{
    protected $table = 'abilities_test';
    protected $fillable = ['faculty_program_id', 'max_points', 'min_points'];
    protected $guarded = ['id'];

    public function faculty(){
        return $this->belongsTo(FacultyProgram::class, 'faculty_program_id');
    }

    public function applicationAbilityTests(){
        return $this->hasMany(ApplicationAbilityTest::class);
    }
}
