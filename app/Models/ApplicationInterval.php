<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationInterval extends Model // OBDOBJE PRIJAVE
{
    protected $table = 'applications_interval';

    protected $fillable = ['starts_at', 'ends_at', 'deleted_at'];

    protected $guarded = ['id'];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'deleted_at' => 'date'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
