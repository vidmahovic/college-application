<?php

namespace App\Transformers;

use App\Models\City;
use League\Fractal;

/**
 * Class CityTransformer
 *
 * @package \App\Transformers
 */
class CityTransformer extends Fractal\TransformerAbstract
{
    public function transform(City $city)
    {
        return [
            'name' => $city->name
        ];
    }
}
