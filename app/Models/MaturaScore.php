<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * Class MaturaScore
 *
 * @package \App\Models
 */
class MaturaScore extends Model
{
    public $timestamps = false;

    protected $fillable = ['matura_points', 'matura_done', 'general_matura', 'third_grade_mark', 'fourth_grade_mark'];


    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }


    public static function scopeGeneral($query) {
        return $query->where('general_matura', true);
    }

    public function scopeVocational($query) {
        return $query->where('general_matura', false);
    }

    public function setMaturaDoneAttribute($matura_done) {
        if(is_bool($matura_done))
            $this->attributes['matura_done'] = $matura_done;
        else
            $this->attributes['matura_done'] = $matura_done === 'D';
    }

    public static function deleteOldRecords(bool $for_general_matura) {
        if($for_general_matura)
            $scores = static::where('general_matura', true)->orWhere('general_matura', null)->get();
        else
            $scores = static::where('general_matura', false)->get();

        foreach($scores as $score) {
            $application = $score->application()->first();
            if($application !== null) $application->subjects()->detach();
            $score->delete();
        }
    }

}
