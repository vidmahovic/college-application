<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use CollegeApplication\Authentication\AuthenticatesUsers;
use CollegeApplication\Authentication\ThrottlesLogins;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class AuthController
 *
 * @package \App\Http\Controllers\Api
 */
class AuthController extends ApiController
{
    use AuthenticatesUsers, ThrottlesLogins;

    private $request;
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    private $jwt;

    public function __construct(Request $request, JWTAuth $jwt)
    {
        $this->request = $request;
        $this->jwt = $jwt;
    }

    public function login()
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {

            if (! $token = $this->jwt->attempt($this->request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
//        if ($this->hasTooManyLoginAttempts($this->request)) {
//            $this->fireLockoutEvent($this->request);
//
//            return $this->sendLockoutResponse($this->request);
//        }
//
//        if ($this->attemptLogin($this->request)) {
//            return $this->sendLoginResponse($this->request);
//        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
//        $this->incrementLoginAttempts($this->request);
//
//        return $this->sendFailedLoginResponse($this->request);
    }


    public function register() {
        $this->validateRegisterParams($this->request);
        // Validate the request
        // Parse the data

    }

    public function password() {

    }
}
