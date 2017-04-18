<?php

namespace App\Transformers;

use App\Models\GraduationType;
use League\Fractal;

/**
 * Class GraduationTypeTransformer
 *
 * @package \App\Transformers
 */
class GraduationTypeTransformer extends Fractal\TransformerAbstract
{
    public function transform(GraduationType $graduation)
    {
        return [
            'id' => $graduation->id,
            'name' => $graduation->name
        ];
    }
}
