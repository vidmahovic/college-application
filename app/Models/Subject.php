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

    public function scopeForVocationalMatura($query) {
        return $query->where('id', 'like', 'L%');
    }

    public function scopeForGeneralMatura($query) {
        return $query->where('id', 'like', 'M%');
    }

    public function isVocational()
    {
        return (bool) preg_match("/L[0-9]+", $this->id);
    }

    public function isGeneral()
    {
        return (bool) preg_match("/M[0-9]+", $this->id);
    }

    public function isCapabilityTest()
    {
        return (bool) preg_match("/S[0-9]+", $this->id);
    }

    public function isThirdGrade()
    {
        return (bool) preg_match("/T[0-9]+", $this->id);
    }

    public function isFourthGrade()
    {
        return (bool) preg_match("/Y[0-9]+", $this->id);
    }

    public function isThirdAndFourthGrade()
    {
        return (bool) preg_match("/X[0-9]+", $this->id);
    }

    public function isFinalExam()
    {
        return (bool) preg_match("/Z[0-9]+", $this->id);
    }

    public function isCombinedSuccess()
    {
        return (bool) preg_match("/U[0-9]+", $this->id);
    }



}
