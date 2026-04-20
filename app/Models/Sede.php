<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sede';
    protected $primaryKey = 'sede_id';

     public $timestamps = true;

    protected $fillable = [
        'sede_nombre',
        'sede_direccion',
        'sede_logo',
        'sede_telefono',
        'sede_slogan',
        'sede_descripcion',
        'sede_lat',
        'sede_lng'
    ];
}
