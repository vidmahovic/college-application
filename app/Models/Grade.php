<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model // OCENA, PIVOT MED VPISNICO IN PREDMETOM
{
    protected $table = 'grades';
    protected $fillable = ['application_id', 'subject_id', 'grade'];
    protected $guarded = ['id'];

    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
