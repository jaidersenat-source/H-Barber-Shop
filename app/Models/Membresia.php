<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table = 'membresias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion_meses',
        'beneficios',
        'activo',
        'imagen',
        'orden',
    ];

    protected $casts = [
        'beneficios' => 'array',
        'activo'     => 'boolean',
        'precio'     => 'decimal:2',
    ];

    // Relación con clientes
    public function clientesMembresias()
    {
        return $this->hasMany(ClienteMembresia::class, 'membresia_id');
    }

    public function clientesActivos()
    {
        return $this->clientesMembresias()->where('estado', 'activa');
    }

    // Helper: etiqueta de duración legible
    public function etiquetaDuracion(): string
    {
        return match ($this->duracion_meses) {
            1  => '1 mes',
            3  => '3 meses',
            6  => '6 meses',
            12 => '1 año',
            default => $this->duracion_meses . ' meses',
        };
    }

    // Scope: solo activas para sitio público
    public function scopeActivas($query)
    {
        return $query->where('activo', true)->orderBy('orden')->orderBy('precio');
    }

    /**
     * Devuelve los beneficios siempre como array de strings legibles,
     * independientemente de si se guardaron como array indexado o como objeto JSON.
     */
    public function beneficiosLista(): array
    {
        $raw = $this->beneficios ?? [];

        if (empty($raw)) {
            return [];
        }

        // Formato estructurado nuevo: {"tipo":"gratis"|"porcentaje", ...}
        if (isset($raw['tipo'])) {
            if ($raw['tipo'] === 'gratis') {
                $usos = (int) ($raw['usos_limite'] ?? 0);
                $linea = $usos > 0 ? "Descuento: Gratis (hasta {$usos} usos)" : 'Descuento: Gratis (usos ilimitados)';
            } else {
                $pct   = $raw['descuento_pct'] ?? 0;
                $linea = "Descuento: {$pct}% en servicios";
            }
            $servs = $raw['servicios_aplicables'] ?? [];
            $result = [$linea];
            if (!empty($servs)) {
                $nombres = \App\Models\Servicio::whereIn('serv_id', $servs)->pluck('serv_nombre')->toArray();
                if ($nombres) {
                    $result[] = 'Aplica en: ' . implode(', ', $nombres);
                }
            } else {
                $result[] = 'Aplica en: todos los servicios';
            }
            return $result;
        }

        // Array indexado de strings (formato antiguo simple)
        if (isset($raw[0])) {
            return array_values(array_filter(
                array_map(fn($b) => is_scalar($b) ? trim((string) $b) : null, $raw),
                fn($b) => $b !== null && $b !== ''
            ));
        }

        // Objeto JSON / array asociativo (formato legacy)
        $result = [];
        foreach ($raw as $key => $value) {
            if (is_scalar($value)) {
                $result[] = ucfirst($key) . ': ' . $value;
            } elseif (is_array($value) && !empty($value)) {
                $result[] = ucfirst($key) . ': ' . implode(', ', array_filter($value, 'is_scalar'));
            }
        }
        return $result;
    }
}