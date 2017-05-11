<?php

namespace App\Transformers;

use App\Models\Country;
use League\Fractal;

/**
 * Class CountryTransformer
 *
 * @package \App\Transformers
 */
class CountryTransformer extends Fractal\TransformerAbstract
{
    public function transform(Country $country)
    {
        return [
            'id' => $country->id,
            'name' => $country->name,
            'eu' => $country->eu
        ];
    }

}
