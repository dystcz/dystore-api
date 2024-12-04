<?php

namespace Dystore\Api\Domain\Users\Traits;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Config;

trait CanReceiveAuthNotifications
{
    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $notificationClass = Config::get(
            'dystore.domains.auth.notifications.reset_password',
            ResetPassword::class,
        );

        $this->notify(new $notificationClass($token));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $notificationClass = Config::get(
            'dystore.domains.auth.notifications.verify_email',
            VerifyEmail::class,
        );

        $this->notify(new $notificationClass);
    }
}
