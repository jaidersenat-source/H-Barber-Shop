<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';              // nombre de la tabla
    protected $primaryKey = 'usuario_id';       // clave primaria

    public $timestamps = true;

    protected $fillable = [
        'per_documento',
        'usuario',
        'password',
        'rol',
        'ultimo_acceso',
        'estado',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
    ];

    // Necesario para que Laravel sepa cuál es la contraseña
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Relación con persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'per_documento', 'per_documento');
    }

    // ¿Está activo?
    public function isActive(): bool
    {
        return $this->estado === 'activo';
    }

    // Scope para usuarios activos
    public function scopeActive($query)
    {
        return $query->where('estado', 'activo');
    }
    /**
     * Devuelve el correo electrónico asociado a la persona para recuperación de contraseña.
     */
    public function getEmailForPasswordReset()
    {
        return $this->persona ? $this->persona->per_correo : null;
    }

    /**
     * Permite buscar usuario por el correo de persona para recuperación de contraseña.
     */
    public function scopeWhereEmail($query, $email)
    {
        return $query->whereHas('persona', function ($q) use ($email) {
            $q->where('per_correo', $email);
        });
    }

        /**
     * Indica a Laravel a qué correo enviar las notificaciones (como el reset de contraseña).
     */
    public function routeNotificationForMail($notification = null)
    {
        return $this->persona ? $this->persona->per_correo : null;
    }

     // Notificación personalizada de recuperación de contraseña
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
