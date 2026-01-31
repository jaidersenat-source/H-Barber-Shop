<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FacturaDetalle extends Model
{
    protected $table = 'factura_detalle';
    protected $primaryKey = 'facdet_id';
    public $timestamps = true;

    protected $fillable = [
        'fac_id',
        'serv_id',
        'serv_precio',
        'serv_nombre',
    ];

    // Relación con Factura
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'fac_id', 'fac_id');
    }

    // Relación con Servicio
    public function servicios()
    {
        return $this->belongsTo(Servicio::class, 'serv_id', 'serv_id');
    }
}
