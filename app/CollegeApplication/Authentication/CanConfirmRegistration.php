<?php

namespace CollegeApplication\Authentication;

use CollegeApplication\Authentication\VerifyRegistration;
use Illuminate\Auth\Notifications\ResetPassword;

trait CanConfirmRegistration
{

    public function getRegistrationConfirmationEmail()
    {
        return $this->email;
    }

    protected function saveVerificationCode($verification_code)
    {
        $this->verification_code = $verification_code;
        $this->save();
    }

    public function sendConfirmationEmail($verification_code)
    {
        $this->notify(new VerifyRegistration($verification_code));
        $this->saveVerificationCode($verification_code);
    }

}
