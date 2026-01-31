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
        'serv_precio',
        'serv_duracion',
        'serv_estado',
        'serv_descuento'
    ];
}
