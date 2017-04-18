<?php

namespace App\Transformers;

use App\Models\MiddleSchool;
use League\Fractal;

/**
 * Class MiddleSchoolTransformer
 *
 * @package \App\Transformers
 */
class MiddleSchoolTransformer extends Fractal\TransformerAbstract
{
    public function transform(MiddleSchool $school)
    {
        return [
            'id' => $school->id,
            'name' => $school->name
        ];
    }


}
