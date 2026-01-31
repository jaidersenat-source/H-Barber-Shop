<?php
namespace App\Notifications;

use App\Models\Turno;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NuevoTurnoAdmin extends Notification
{
    use Queueable;

    public $turno;

    public function __construct(Turno $turno)
    {
        $this->turno = $turno;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nuevo turno registrado')
            ->line('Se ha registrado un nuevo turno.')
            ->line('Cliente: ' . $this->turno->tur_nombre)
            ->line('Fecha: ' . $this->turno->tur_fecha)
            ->line('Hora: ' . $this->turno->tur_hora);
    }
}