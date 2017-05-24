<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model // DRŽAVA
{
    protected $table = 'countries';

    protected $fillable = ['id', 'name', 'eu'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'eu' => 'boolean'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function applicationCities()
    {
        return $this->hasMany(ApplicationCity::class);
    }

    public function scopeEuropean($query)
    {
        return $query->where('eu', true);
    }

    public function scopeForeign($query)
    {
        return $query->whereNotLike('name', '%SLOVENIJA%');
    }

    public function scopeLocal($query)
    {
        return $query->whereLike('name', '%SLOVENIJA%');
    }

    public function isEuropean() {
        return !! $this->eu;
    }
}
