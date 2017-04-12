<?php

namespace CollegeApplication\Authentication;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

trait AuthenticatesUsers
{
    use ProvidesConvenienceMethods;

    protected $username = 'email';

    public function username() {
        return $this->username;
    }

    protected  function validateLoginParams(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required|min:8'
        ]);
    }

    protected function validateRegisterParams(Request $request)
    {
        $this->validate($request, [
           // TODO (Vid): Set registration rules.
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }


}
