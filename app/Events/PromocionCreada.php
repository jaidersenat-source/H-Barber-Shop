<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PromocionCreada
{
    use Dispatchable, SerializesModels;

    public $tipo;
    public $item;

    public function __construct($tipo, $item)
    {
        $this->tipo = $tipo; // 'servicio' o 'producto'
        $this->item = $item;
    }
}