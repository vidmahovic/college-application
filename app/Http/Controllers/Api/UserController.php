<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use Dingo\Api\Exception\UpdateResourceFailedException;

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
        $validator = $this->validateRequest([
            'old_password' => 'required',
            'new_password' => ['required', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/']
        ]);

        if($validator->fails())
            throw new UpdateResourceFailedException('Could not update the password', $validator->errors());

        $user = $this->request->user();

        if(! app('hash')->check($this->request->get('old_password'), $user->password))
            throw new UpdateResourceFailedException('Could not update password', ['old_password' => 'Password mismatch']);

        $user->password = bcrypt($this->request->get('new_password'));
        $user->save();

        return $this->response->noContent();
    }

}
