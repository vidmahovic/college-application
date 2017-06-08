<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model // DRZAVLJAN
{
    protected $table = 'citizens';

    protected $fillable = ['id', 'name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeBornSlovenian($query)
    {
        return $query->whereIn('id', [1,5]);
    }

    public function scopebornForeigner($query)
    {
        return $query->whereNotIn('id', [1,5]);
    }

    public function scopeFromSloveniaOrEu($query)
    {
        return $query->whereIn('id', [1,5,6]);
    }

    public function scopeFromOtherCountries($query)
    {
        return $query->whereNotIn('id', [1,5,6]);
    }
}
