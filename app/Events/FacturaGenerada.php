<?php
namespace App\Events;

use App\Models\Factura;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FacturaGenerada
{
    use Dispatchable, SerializesModels;

    public $factura;

    public function __construct(Factura $factura)
    {
        $this->factura = $factura;
    }
}