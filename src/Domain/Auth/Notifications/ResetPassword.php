<?php

namespace Dystore\Api\Domain\Auth\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends BaseNotification
{
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array|string
    {
        return ['mail'];
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Set a new password'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

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
