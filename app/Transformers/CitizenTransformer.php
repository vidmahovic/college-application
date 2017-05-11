<?php

namespace App\Transformers;

use App\Models\Citizen;
use League\Fractal;

/**
 * Class CitizenTransformer
 *
 * @package \App\Transformers
 */
class CitizenTransformer extends Fractal\TransformerAbstract
{

    public function transform(Citizen $citizen)
    {
        return [
            'id' => $citizen->id,
            'name' => $citizen->name
        ];
    }

}
