<?php

namespace App\Http\Controllers\Api;

use CollegeApplication\Authentication\AuthenticatesUsers;
use CollegeApplication\Authentication\ThrottlesLogins;
use Illuminate\Http\Request;

/**
 * Class AuthController
 *
 * @package \App\Http\Controllers\Api
 */
class AuthController extends ApiController
{
    use AuthenticatesUsers,ThrottlesLogins;

    protected $login_attempts = 3;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);

            return $this->sendLockoutResponse($this->request);
        }

        if ($this->attemptLogin($this->request)) {
            return $this->sendLoginResponse($this->request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($this->request);

        return $this->sendFailedLoginResponse($this->request);
    }


    public function register() {
        $this->validateRegisterParams($this->request);
        // Validate the request
        // Parse the data

    }

    public function password() {

    }
}
