<?php
namespace App\Mail;

use App\Models\Turno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TurnoClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $turno;

    public function __construct(Turno $turno)
    {
        $this->turno = $turno;
    }

    public function build()
    {
        return $this->subject('Confirmación de tu turno')
            ->view('emails.turno_cliente');
    }
}