<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromocionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tipo;
    public $item;

    public function __construct($tipo, $item)
    {
        $this->tipo = $tipo;
        $this->item = $item;
    }

    public function build()
    {
        return $this->subject('¡Nueva promoción en H Barber Shop!')
            ->view('emails.promocion');
    }
}