<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model // UNIVERZA
{
    protected $table = 'universities';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }
}
