<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationInterval extends Model
{
    use SoftDeletes;

    protected $table = 'application_intervals';

    protected $fillable = ['starts_at', 'ends_at'];

    protected $guarded = ['id'];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function maturaScores()
    {
        return $this->hasMany(MaturaScore::class, 'interval_id');
    }

    public function scopeCurrent($scope) {
        return $scope->where('starts_at', '<=', Carbon::now())->where('ends_at', '>=', Carbon::now());
    }

}
