<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClienteFidelizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $turno;
    public $fidelizacion;

    public function __construct($turno, $fidelizacion)
    {
        $this->turno = $turno;
        $this->fidelizacion = $fidelizacion;
    }

    public function build()
    {
        return $this->subject('¡Felicidades! Has ganado un corte gratis')
            ->view('emails.fidelizacion');
    }
}