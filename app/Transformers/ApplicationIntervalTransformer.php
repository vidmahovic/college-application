<?php

namespace App\Transformers;

use App\Models\ApplicationInterval;
use League\Fractal;

/**
 * Class ApplicationTransformer
 *
 * @package \App\Transformers
 */
class ApplicationIntervalTransformer extends Fractal\TransformerAbstract
{

    public function transform(ApplicationInterval $interval)
    {
        return [
            'id' => $interval->id,
            'starts_at' => $interval->starts_at,
            'ends_at' => $interval->ends_at
        ];
    }
}
