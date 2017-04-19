<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;

/**
 * Class UserController
 *
 * @package \App\Http\Controllers\Api
 */
class UserController extends ApiController
{
    public function user()
    {
        return $this->response->item($this->request->user(), new UserTransformer);
    }

    public function password()
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required'
        ];
    }

}
