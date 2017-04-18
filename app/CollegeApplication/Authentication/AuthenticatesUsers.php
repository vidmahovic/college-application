<?php

namespace CollegeApplication\Authentication;

use App\User;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use Tymon\JWTAuth\JWTAuth;

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
            'password' => 'required|min:6' // TODO (Vid): validate password adhering to specifications.
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
        //return Auth::guard();
        return app(JWTAuth::class);
    }

    protected function credentials(Request $request)
    {
        return $request->only([$this->username(), 'password']);
    }

    protected function saveToken(Request $request, string $token) : User
    {
        $user = User::where($this->username(), $request->only($this->username()))->firstOrFail();
        $user->api_token = $token;
        $user->save();
        return $user;
    }


}
