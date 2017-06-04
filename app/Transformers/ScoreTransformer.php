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
            'total' => $item->total,
            'new' => $item->new,
            'updated' => $item->updated,
        ];
    }

    public function includeErrors($item) {
        //dd($item->errors);
        if(count($item->errors))
            return $this->collection(collect($item->errors), new ScoreErrorTransformer);
    }
}
