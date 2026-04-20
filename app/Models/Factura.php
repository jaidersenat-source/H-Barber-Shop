<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'fac_id';
    public $timestamps = true;

    protected $fillable = [
        'fac_fecha',
        'sede_id',
        'tur_id',
        'fac_total',
        'fac_total_con_descuento',
        'fac_abono',
        'membresia_descuento',
    ];

    // Relación con Turno
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'tur_id', 'tur_id');
    }

    // Relación con Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id', 'sede_id');
    }

    // Relación con Detalles
    public function detalles()
    {
        return $this->hasMany(FacturaDetalle::class, 'fac_id', 'fac_id');
    }
}
