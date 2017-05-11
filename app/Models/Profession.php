<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model // POKLIC
{
    protected $table = 'professions';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function conditionsProfession()
    {
        return $this->hasMany(ConditionsProfession::class);
    }
}
