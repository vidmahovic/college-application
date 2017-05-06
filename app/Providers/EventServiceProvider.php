<?php

namespace App\Providers;

use CollegeApplication\Authentication\SendRegistrationVerificationEmail;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'UserHasRegistered' => [
            SendRegistrationVerificationEmail::class,
        ],
    ];
}
