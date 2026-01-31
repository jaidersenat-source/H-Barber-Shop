<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fidelizacion extends Model
{
    protected $table = 'fidelizacion';
    protected $primaryKey = 'fid_id';

    protected $fillable = [
        'tur_id',
        'tur_cedula',
        'tur_celular',
        'tur_nombre',
        'visitas_acumuladas',
        'cortes_gratis',
        'fecha_actualizacion'
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'tur_id', 'tur_id');
    }
}
