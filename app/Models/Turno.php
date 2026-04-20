<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turno';
    protected $primaryKey = 'tur_id';
    public $timestamps = true;

    protected $fillable = [
        'dis_id','serv_id','combo_id','per_documento','tur_fecha','tur_hora','tur_duracion',
        'tur_nombre','tur_cedula','tur_celular', 'tur_correo', 'tur_fecha_nacimiento','tur_estado',
        'tur_estado_pago', 'tur_anticipo', 'tur_referencia_pago', 'tur_fecha_pago'
    ];

    public function disponibilidad()
    {
        return $this->belongsTo(Disponibilidad::class, 'dis_id', 'dis_id');
    }

    // Relación a Factura
    public function factura()
    {
        return $this->hasOne(Factura::class, 'tur_id', 'tur_id');
    }

    // Relación al barbero (via disponibilidad)
    public function barbero()
    {
        return $this->belongsTo(Persona::class, 'per_documento', 'per_documento');
    }

    // Relación al servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'serv_id', 'serv_id');
    }

    

    // Cliente temporal (usando los datos del turno mismo)
    public function getClienteAttribute()
    {
        return (object) [
            'nombre' => $this->tur_nombre,
            'email' => $this->tur_correo,
            'cedula' => $this->tur_cedula,
            'celular' => $this->tur_celular,
        ];
    }

}
