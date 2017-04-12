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
        // First, we need to validate Request params
        $this->validateLoginParams($this->request);

        // Then, we need to check if we need to send
        // a lockout response to the User
        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);

            return $this->sendLockoutResponse($this->request);
        }

        try {
            // We can now try to authenticate the User against
            // his credentials...
            if ($jwt_token = $this->attemptLogin($this->request)) {

                $this->clearLoginAttempts($this->request);
                $this->saveToken($this->request, $jwt_token);

                return response()->json(compact('jwt_token'));

            }

            $response = response()->json(['user_not_found'], 404);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $response = response()->json(['token_expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $response = response()->json(['token_invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $response = response()->json(['token_absent' => $e->getMessage()], 500);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($this->request);

        return $response;

    }


    public function register() {
        $this->validateRegisterParams($this->request);
        // Validate the request
        // Parse the data
        // etc.
        // TODO (Vid): implement registration logic.
    }

    public function password() {

    }

}
