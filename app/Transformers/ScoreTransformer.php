<?php

namespace App\Transformers;

use League\Fractal;

/**
 * Class ScoreTransformer
 *
 * @package \App\Transformers
 */
class ScoreTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = ['errors'];

    public function transform($item) {
        return [
            'candidates' => $item->candidates,
            'subjects' => $item->subjects
        ];
    }

    public function includeErrors($item) {
        //dd($item->errors);
        if(count($item->errors))
            return $this->collection(collect($item->errors), new ScoreErrorTransformer);
    }

    public function includeCandidates($item) {
        $candidates = $item->candidates;
        return $this->array([
            'total' => $candidates['total'],
            'successful' => $candidates['successful']
        ]);
    }

    public function includeSubjects($item) {
        $subjects = $item->subjects;
        return $this->array([
            'total' => $subjects['total'],
            'new' => $subjects['new'],
            'updated' => $subjects['updated']
        ]);
    }
}
