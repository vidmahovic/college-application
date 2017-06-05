<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class MaturaScore
 *
 * @package \App\Models
 */
class MaturaScore extends Model
{
    public $timestamps = false;

    protected $fillable = ['first_name', 'last_name', 'middle_school_id', 'profession_id', 'interval_id'];

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

    public function subjectGrades()
    {
        return $this->belongsToMany(
            Grade::class,
            'subject_grade',
            'matura_score_id',
            'subject_id')->withPivot(['matura_mark', '3_grade_mark', '4_grade_mark']);
    }

    public static function scopeGeneral($query) {
        return $query->where('general_matura', true);
    }

    public function scopeVocational($query) {
        return $query->where('general_matura', false);
    }

    public static function storeScores(Collection $scores)
    {
        $new = 0;
        $updated = 0;

        foreach($scores as $score) {

            $s = static::where('emso', $score['emso'])->first();

            if($score['matura_points'] === '') {
                // Ignore altogether... Data for this entity is in the other file
                // Za te kandidate vemo, da opravljajo samo dodaten maturitetni predmet, imajo pa poklicno maturo (so v datoteki POKLMAT.txt)
//                $s = ApplicationInterval::current()->first()->maturaScores()->firstOrCreate(['emso' => $score['emso']],
//                    [
//                        'first_name' => $score['first_name'],
//                        'last_name' => $score['last_name'],
//                        'middle_school_id' => $score['middle_school_id'],
//                        'profession_id' => $score['profession_id'],
//                        'interval_id' => ApplicationInterval::current()->first()->id
//                    ]
//                );

                $updated++;
            } else {
                // Create process...
                if($s == null) {
                    $s = new static;
                    $s->emso = $score['emso'];
                }
                $s->first_name = $score['first_name'];
                $s->last_name = $score['last_name'];
                $s->middle_school_id = $score['middle_school_id'];
                $s->profession_id = $score['profession_id'];
                $s->matura_points = $score['matura_points'];
                $s->matura_done = $score['matura_done'] === 'D' ? true : false;
                $s->third_grade_mark = $score['3_grade_mark'];
                $s->fourth_grade_mark = $score['4_grade_mark'];
                $s->general_matura = $score['general_matura'];
                $s->interval_id = ApplicationInterval::current()->first()->id;
                $s->save();
                $new++;
            }
        }

        return ['new' => $new, 'updated' => $updated];
    }


    public static function storeSubjectScores(Collection $scores)
    {
        $updated = 0;
        $new = 0;

        foreach ($scores as $score) {

            if($score['3_grade_mark'] === '') {
                // Find the relation
                // Update the grade.
                $updated++;
            } else {
                $new++;
            }
        }

        return ['new' => $new, 'updated' => $updated];
    }

}
