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
            'password' => [
                'required',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
                'min:8'
            ]
        ]);
    }

    protected function validateRegisterParams(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => [
                'required',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
                'min:8'
            ],
            'confirm_password' => 'required|same:password'
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

    public function getUserFromRequest(Request $request): User
    {
        return User::where($this->username(), $request->only($this->username()))->firstOrFail();
    }

}
