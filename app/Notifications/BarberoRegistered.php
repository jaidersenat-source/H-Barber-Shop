<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;

class BarberoRegistered extends Notification
{
    use Queueable;

    protected $usuario;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "El barbero con cédula {$this->usuario->per_documento} se registró y está pendiente de activación.",
            'usuario_id' => $this->usuario->usuario_id,
            'per_documento' => $this->usuario->per_documento,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nuevo barbero registrado')
                    ->line("El barbero con cédula {$this->usuario->per_documento} se registró y está pendiente de activación.")
                    ->action('Ir al panel', url('/admin/personal'));
    }
}
