<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model // PREDMET
{
    protected $table = 'subjects';

    protected $fillable = ['id', 'name'];

    public $timestamps = false;

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function conditionsSubject()
    {
        return $this->hasMany(ConditionsSubject::class);
    }

    public function maturaGrades()
    {
        return $this->belongsToMany(
            MaturaScore::class,
            'subject_score',
            'subject_id',
            'matura_score_id')->withPivot(['matura_mark', '3_grade_mark', '4_grade_mark']);
    }

    public function generalMaturaScores()
    {
        return $this->maturaGrades()->where('general_matura', true);
    }

    public function vocationalMaturaScores()
    {
        return $this->maturaGrades()->where('general_matura', false);
    }

    public function grades() {
        return $this->hasMany(Grade::class);
    }
}
