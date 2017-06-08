<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model // OBCINA
{
    protected $table = 'districts';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function faculties()
    {
        return $this->hasMany(Faculty::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeLocal($query)
    {
        return $query->whereNotLike('name', '%TUJINA%');
    }

    public function scopeForeign($query)
    {
        return $query->whereLike('name', '%TUJINA%');
    }
}
