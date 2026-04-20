<?php
namespace App\Events;

use App\Models\Turno;
use App\Models\Fidelizacion;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClienteFidelizado
{
    use Dispatchable, SerializesModels;

    public $turno;
    public $fidelizacion;

    public function __construct(Turno $turno, Fidelizacion $fidelizacion)
    {
        $this->turno = $turno;
        $this->fidelizacion = $fidelizacion;
    }
}