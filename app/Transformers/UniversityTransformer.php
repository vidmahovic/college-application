<?php

namespace App\Transformers;

use App\Models\University;
use League\Fractal;

/**
 * Class UniversityTransformer
 *
 * @package \App\Transformers
 */
class UniversityTransformer extends Fractal\TransformerAbstract
{
    public function transform(University $university)
    {
        return [
            'id' => $university->id,
            'name' => $university->name
        ];
    }
}
