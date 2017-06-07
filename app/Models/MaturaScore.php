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

    protected $fillable = ['emso','first_name', 'last_name', 'middle_school_id', 'profession_id', 'interval_id', 'matura_points',
        'matura_score', 'matura_done', 'general_matura', 'third_grade_mark', 'fourth_grade_mark'];

    public function interval()
    {
        return $this->belongsTo(ApplicationInterval::class, 'interval_id');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    public function middleSchool()
    {
        return $this->belongsTo(MiddleSchool::class, 'middle_school_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'subject_score',
            'matura_score_id',
            'subject_id')->withPivot(['matura_mark', '3_grade_mark', '4_grade_mark']);
    }

    public static function scopeGeneral($query) {
        return $query->where('general_matura', true);
    }

    public function scopeVocational($query) {
        return $query->where('general_matura', false);
    }

    public static function storeScores(array $scores)
    {
        $processed = 0;

        foreach($scores as $score) {

            $s = static::where('emso', $score['emso'])->first();

            if ($score['matura_points'] === '') {
                if ($s === null) {
                    $s = new static;
                    $s->emso = $score['emso'];
                    $s->first_name = $score['first_name'];
                    $s->last_name = $score['last_name'];
                    $s->save();
                    $processed++;
                }
            } else {
                if ($s === null) {
                    $s = new static;
                    $s->emso = $score['emso'];
                    $s->general_matura = $score['general_matura'];
                }

                $s->first_name = $score['first_name'];
                $s->last_name = $score['last_name'];
                $s->middle_school_id = $score['middle_school_id'];
                $s->profession_id = $score['profession_id'];
                $s->matura_points = $score['matura_points'];
                $s->matura_done = $score['matura_done'] = $score['matura_done'] === 'D' ? true : false;
                $s->third_grade_mark = $score['3_grade_mark'];
                $s->fourth_grade_mark = $score['4_grade_mark'];
                $s->interval_id = ApplicationInterval::current()->first()->id;
                $s->save();
                $processed++;
            }
        }

        return $processed;
    }


    public static function storeSubjectScores(array $scores)
    {
        $updated = 0;
        $new = 0;

        foreach ($scores as $score) {
            $s = static::where('emso', $score['emso'])->first();

            if($s !== null) {
                $s->subjectGrades()->detach($score['subject_id']);
                $s->subjectGrades()->attach($score['subject_id'], [
                    'third_grade_mark' => $score['3_grade_mark'] === '' ? null : $score['3_grade_mark'],
                    'fourth_grade_mark' => $score['4_grade_mark'] === '' ? null : $score['4_grade_mark'],
                    'matura_mark' => $score['matura_mark']
                ]);

                if($score['3_grade_mark'] === '') {
                    $updated++;
                } else {
                    $new++;
                }
            }

        }

        return ['new' => $new, 'updated' => $updated];
    }

}
