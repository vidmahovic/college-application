<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model // OCENA, PIVOT MED VPISNICO IN PREDMETOM
{
    protected $table = 'grades';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function maturaScore()
    {
        return $this->belongsTo(MaturaScore::class, 'matura_score_id');
    }
}
