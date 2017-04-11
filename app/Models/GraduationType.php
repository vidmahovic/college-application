<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduationType extends Model // ZAKLJUČEK ŠOLE
{
    protected $table = 'graduation_types';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
