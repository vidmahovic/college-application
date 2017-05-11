<?php

namespace App\Transformers;

use App\Models\Profession;
use League\Fractal;

/**
 * Class ProfessionTransformer
 *
 * @package \App\Transformers
 */
class ProfessionTransformer extends Fractal\TransformerAbstract
{
    public function transform(Profession $profession)
    {
        return [
            'id' => $profession->id,
            'name' => $profession->name
        ];
    }

}
