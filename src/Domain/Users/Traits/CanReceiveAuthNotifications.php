<?php

namespace Dystore\Api\Domain\Users\Traits;

use Dystore\Api\Domain\Users\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Config;

trait CanReceiveAuthNotifications
{
    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        /** @var User $this */
        $notificationClass = Config::get(
            'dystore.domains.auth.notifications.reset_password',
            ResetPassword::class,
        );

        $this->notify(new $notificationClass($token));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        /** @var User $this */
        $notificationClass = Config::get(
            'dystore.domains.auth.notifications.verify_email',
            VerifyEmail::class,
        );

        $this->notify(new $notificationClass);
    }
}
