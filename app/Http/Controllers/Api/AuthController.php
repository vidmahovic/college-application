<?php

namespace App\Http\Controllers\Api;


use App\Transformers\UserTransformer;
use Carbon\Carbon;
use CollegeApplication\Authentication\AuthenticatesUsers;
use CollegeApplication\Authentication\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthController
 *
 * @package \App\Http\Controllers\Api
 */
class AuthController extends ApiController
{
    use AuthenticatesUsers, ThrottlesLogins;


    public function login()
    {
        // First, we need to validate Request params
        try {
            $this->validateLoginParams($this->request);
        } catch(ValidationException $e) {
            return $this->response->errorBadRequest('Validation has failed');
        }

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
                $user = $this->saveToken($this->request, $jwt_token);
                $user->update(['last_login' => Carbon::now()]);
                return $this->response->item($user, new UserTransformer)->addMeta('api_token', $jwt_token);

            }

            $response = $this->response->errorNotFound('User not found');

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $response = $this->response->errorUnauthorized('Tokan has expired');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $response = $this->response->errorUnauthorized('Token is invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $response = $this->response->errorBadRequest('Token not provided');
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
}
