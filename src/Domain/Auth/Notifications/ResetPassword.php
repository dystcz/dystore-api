<?php

namespace Dystore\Api\Domain\Auth\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseNotification;

class ResetPassword extends BaseNotification
{
    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route(
            name: 'v1.auth.users.passwords.set-new-password',
            parameters: [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ],
            absolute: false
        ));
    }
}
