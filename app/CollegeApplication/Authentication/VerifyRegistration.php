<?php

namespace CollegeApplication\Authentication;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyRegistration extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $code;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($verification_code)
    {
        $this->code = $verification_code;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You are receiving this email because you registered with our College Application app with this email.')
            ->action('Confirm Registration', url('/register/verify') . '/'.$this->code)
            ->line('If you did not register, no further action is required.');
    }
}
