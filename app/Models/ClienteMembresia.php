<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteMembresia extends Model
{
    protected $table = 'clientes_membresias';

    protected $fillable = [
        'cliente_cedula',
        'membresia_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'usos_usados',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'membresia_id');
    }

    // Auto-actualizar estado según fechas
    public function actualizarEstado(): void
    {
        if ($this->estado === 'cancelada') return;

        if ($this->fecha_fin < now()->toDateString()) {
            $this->update(['estado' => 'vencida']);
        }
    }
}