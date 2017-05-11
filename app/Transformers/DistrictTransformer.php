<?php

namespace App\Transformers;

use App\Models\District;
use League\Fractal;

/**
 * Class DistrictTransformer
 *
 * @package \App\Transformers
 */
class DistrictTransformer extends Fractal\TransformerAbstract
{
    public function transform(District $district)
    {
        return [
            'id' => $district->id,
            'name' => $district->name
        ];
    }
}
