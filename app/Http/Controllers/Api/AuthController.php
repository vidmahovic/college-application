<?php

namespace App\Http\Controllers\Api;


use App\Models\Role;
use App\Transformers\UserTransformer;
use App\User;
use Carbon\Carbon;
use CollegeApplication\Authentication\AuthenticatesUsers;
use CollegeApplication\Authentication\ThrottlesLogins;
use Dingo\Api\Exception\ValidationHttpException;
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
            throw new ValidationHttpException($e->validator->errors());
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

                $user = $this->getUserFromRequest($this->request);

                // If a student did not activate his account, he cannot login to the app.
                if($user->isStudent() && (! $user->activated()))
                    return $this->response->errorUnauthorized('User is not activated');

                $this->clearLoginAttempts($this->request);
                $user->saveToken($jwt_token);
                $user->update(['last_login' => Carbon::now()]);

                return $this->response->item($user, new UserTransformer)->addMeta('api_token', $jwt_token);

            }

            $this->incrementLoginAttempts($this->request);
            return $this->response->errorNotFound('User not found');

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $this->incrementLoginAttempts($this->request);
            return $this->response->errorUnauthorized('Tokan has expired');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $this->incrementLoginAttempts($this->request);
            return $this->response->errorUnauthorized('Token is invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $this->incrementLoginAttempts($this->request);
            return $this->response->errorBadRequest('Token not provided');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($this->request);
        return $this->response->error('Something went wrong');

    }


    public function register()
    {
        try {
            $this->validateRegisterParams($this->request);
        } catch(ValidationException $e) {
            throw new ValidationHttpException($e->validator->errors());
        }

        $role = Role::student()->first();

        $user = User::create([
            'email' => $this->request->email,
            'name' => $this->request->name,
            'username' => $this->request->username,
        ]);
        $user->password = bcrypt($this->request->password);
        $user->activation_email_sent_at = Carbon::now();
        $user->activation_expires_at = Carbon::tomorrow();
        $user->role()->associate($role);
        $user->save();

        event('UserHasRegistered', $user);

        return $this->response->accepted();
    }

    public function confirmRegistration($verification_code)
    {
        $user = User::where('verification_code', $verification_code)->first();

        $validator = $this->getValidationFactory()->make([
            'verification_code' => $verification_code,
            'verification_expires' => $user->activation_expires_at ?? null
        ], [
            'verification_code' => 'required|exists:users,verification_code'
        ]);
        // Validate activation expiration only if a user is found
        $validator->sometimes('verification_expires', 'after_or_equal:'. Carbon::now(), function($input) {
            return $input->verification_expires != null;
        });

        if($validator->fails()) {
            return view('auth.verify')->withErrors($validator);
        }

        $user->activated_at = Carbon::now();
        $user->verification_code = null;
        $user->save();

        return view('auth.verify', ['email' => $user->email]);
    }
}
