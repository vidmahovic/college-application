<?php

namespace CollegeApplication\Authentication;

use App\User;

/**
 * Class SendConfirmationEmail
 *
 * @package \CollegeApplication\Authentication
 */
class SendRegistrationVerificationEmail
{

    public function handle(User $user)
    {
        $user->sendConfirmationEmail(str_random(30));
    }
}
