<?php

namespace App\Transformers;

use App\Models\NationalityType;
use League\Fractal;

/**
 * Class NationalityTypeTransformer
 *
 * @package \App\Transformers
 */
class NationalityTypeTransformer extends Fractal\TransformerAbstract
{

    public function transform(NationalityType $nationality_type)
    {
        return [
            'id' => $nationality_type->id,
            'type' => $nationality_type->type
        ];
    }


}
