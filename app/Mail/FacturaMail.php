<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $factura;
    public $pdfContent;

    public function __construct($factura, $pdfContent)
    {
        $this->factura = $factura;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Factura de tu servicio en la barbería')
            ->view('emails.factura')
            ->attachData($this->pdfContent, 'factura_'.$this->factura->fac_id.'.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}