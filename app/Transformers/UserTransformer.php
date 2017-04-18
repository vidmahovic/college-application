<?php

namespace App\Transformers;

use App\User;
use League\Fractal;

/**
 * Class UserTransformer
 *
 * @package \App\Transformers
 */
class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
            'name' => $user->name,
            'role' => $user->role->name,
            'last_login' => $user->last_login,
        ];
    }
}
