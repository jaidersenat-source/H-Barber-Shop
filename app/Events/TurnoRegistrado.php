<?php
namespace App\Events;

use App\Models\Turno;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TurnoRegistrado
{
    use Dispatchable, SerializesModels;

    public $turno;

    public function __construct(Turno $turno)
    {
        $this->turno = $turno;
    }
}