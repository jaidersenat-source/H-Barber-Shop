<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('password/reset', $this->token) . '?email=' . urlencode($notifiable->email);
        return (new MailMessage)
            ->subject('Recupera tu contraseña - Barbería')
            ->view('emails.password_reset', [
                'url' => $url,
                'user' => $notifiable,
            ]);
    }
}
