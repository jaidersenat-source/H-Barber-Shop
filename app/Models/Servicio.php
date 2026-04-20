<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'serv_id';

    protected $fillable = [
        'serv_nombre',
        'serv_descripcion',
        'serv_categoria',
        'serv_precio',
        'serv_duracion',
        'serv_estado',
        'serv_descuento',
        'serv_servicios_incluidos',
    ];

    protected $casts = [
        'serv_servicios_incluidos' => 'array',
    ];

    /**
     * Indica si este servicio es un combo.
     */
    public function esCombo(): bool
    {
        return $this->serv_categoria === 'combos';
    }

    /**
     * Obtiene los servicios incluidos en este combo.
     */
    public function serviciosIncluidos()
    {
        if (!$this->esCombo() || empty($this->serv_servicios_incluidos)) {
            return collect();
        }

        return static::whereIn('serv_id', $this->serv_servicios_incluidos)
            ->where('serv_categoria', '!=', 'combos')
            ->get();
    }

    public function turnos()
    {
        return $this->hasMany(\App\Models\Turno::class, 'serv_id', 'serv_id');
    }
}

