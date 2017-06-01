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

    public function grades() {
        return $this->hasMany(Grade::class);
    }
}