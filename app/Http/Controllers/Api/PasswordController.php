<?php

namespace App\Http\Controllers\Api;

use CollegeApplication\Authentication\ResetsPasswords;
use CollegeApplication\Authentication\SendsPasswordResetEmails;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Passwords\PasswordBrokerManager;

/**
 * Class PasswordController
 *
 * @package \App\Http\Controllers\Api
 */
class PasswordController
{
    use ResetsPasswords, SendsPasswordResetEmails;

    private $request;
    private $broker;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->broker = 'users';
    }

    public function sendPasswordResetEmail()
    {
        return $this->sendResetLinkEmail($this->request);
    }

    public function resetPassword()
    {
        return $this->reset($this->request);
    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function broker()
    {
        $broker = property_exists($this, 'broker') ? $this->broker : null;
        return app('auth.password')->broker($broker);
    }


}
