<?php
namespace App\Mail;

use App\Models\Turno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TurnoPagoConfirmadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $turno;
    public $servicio;
    public $barbero;

    public function __construct(Turno $turno, $servicio = null, $barbero = null)
    {
        $this->turno = $turno;
        $this->servicio = $servicio;
        $this->barbero = $barbero;
    }

    public function build()
    {
        return $this->subject('✅ Pago Confirmado - Tu turno está confirmado')
            ->view('emails.turno_pago_confirmado');
    }
}