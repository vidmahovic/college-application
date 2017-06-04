<?php

namespace App\Transformers;

use League\Fractal;

/**
 * Class ScoreErrorTransformer
 *
 * @package \App\Transformers
 */
class ScoreErrorTransformer extends Fractal\TransformerAbstract
{
    public function transform(array $errors) {
        return [
            'emso' => $errors['emso'],
            'name' => $errors['first_name'] . ' ' . $errors['last_name']
        ];
    }
}
