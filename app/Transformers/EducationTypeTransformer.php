<?php

namespace App\Transformers;

use App\Models\EducationType;
use League\Fractal;

/**
 * Class EducationTypeTransformer
 *
 * @package \App\Transformers
 */
class EducationTypeTransformer extends Fractal\TransformerAbstract
{

    public function transform(EducationType $education_type)
    {
        return [
            'id' => $education_type->id,
            'name' => $education_type->name,
            'level' => $education_type->level,
            'graduation_type' => $education_type->graduation_type
        ];
    }

}
