<?php

namespace App\Services;

use App\Models\ClienteMembresia;

class MembresiaService
{
    /**
     * PASO 1 — Detectar si un cliente tiene membresía activa y vigente.
     *
     * Busca en clientes_membresias por cedula:
     *   - estado = 'activa'
     *   - fecha_fin >= hoy  (no vencida por fecha)
     *
     * Retorna la instancia de ClienteMembresia con su relación membresia cargada,
     * o null si no hay membresía aplicable.
     */
    public function detectarActiva(string $cedula): ?ClienteMembresia
    {
        return ClienteMembresia::with('membresia')
            ->where('cliente_cedula', $cedula)
            ->where('estado', 'activa')
            ->where('fecha_fin', '>=', now()->toDateString())
            ->latest('fecha_inicio')
            ->first();
    }

    /**
     * PASO 2 — Calcular el precio final aplicando el beneficio de membresía.
     *
     * Lee el JSON 'beneficios' de la membresía asociada:
     *
     *   Caso GRATIS  → { "tipo": "gratis",      "usos_limite": 5,  "servicios_aplicables": [] }
     *   Caso PCT     → { "tipo": "porcentaje",  "descuento_pct": 20, "servicios_aplicables": [] }
     *
     * Si 'servicios_aplicables' no está vacío, el beneficio solo aplica si
     * $serv_id está en esa lista.
     *
     * Retorna un array con:
     *   - precio_final       : float   → lo que se cobra al cliente
     *   - precio_original    : float   → precio sin descuento
     *   - descuento_membresia: float   → monto descontado
     *   - tipo_descuento     : string|null → 'gratis', 'porcentaje' o null
     *   - aplica             : bool    → si el beneficio fue aplicado
     */
    public function aplicarBeneficio(ClienteMembresia $clienteMembresia, float $precioOriginal, ?int $servId = null): array
    {
        $membresia  = $clienteMembresia->membresia;
        $beneficios = $membresia->beneficios ?? [];

        $tipo              = $beneficios['tipo'] ?? null;
        $usosLimite        = (int) ($beneficios['usos_limite'] ?? 0);
        $descuentoPct      = (float) ($beneficios['descuento_pct'] ?? 0);
        $serviciosAplican  = $beneficios['servicios_aplicables'] ?? [];

        // Si la membresía especifica servicios concretos, verificar que este esté incluido
        if (!empty($serviciosAplican) && $servId !== null && !in_array($servId, $serviciosAplican)) {
            return $this->sinBeneficio($precioOriginal);
        }

        // Caso GRATIS: verificar que quedan usos disponibles
        if ($tipo === 'gratis') {
            if ($usosLimite > 0 && $clienteMembresia->usos_usados >= $usosLimite) {
                // Límite alcanzado — no aplica beneficio
                return $this->sinBeneficio($precioOriginal);
            }

            return [
                'precio_final'        => 0.0,
                'precio_original'     => $precioOriginal,
                'descuento_membresia' => $precioOriginal,
                'tipo_descuento'      => 'gratis',
                'aplica'              => true,
            ];
        }

        // Caso PORCENTAJE
        if ($tipo === 'porcentaje' && $descuentoPct > 0) {
            $descuento   = round($precioOriginal * $descuentoPct / 100, 2);
            $precioFinal = round($precioOriginal - $descuento, 2);

            return [
                'precio_final'        => $precioFinal,
                'precio_original'     => $precioOriginal,
                'descuento_membresia' => $descuento,
                'tipo_descuento'      => 'porcentaje',
                'aplica'              => true,
            ];
        }

        // Sin tipo reconocido
        return $this->sinBeneficio($precioOriginal);
    }

    /**
     * PASO 3 — Incrementar el uso de la membresía y desactivarla si alcanza el límite.
     *
     * Llama a este método UNA VEZ por detalle de factura donde aplica == true.
     * Usa lockForUpdate para evitar condiciones de carrera si dos facturas
     * se generan simultáneamente para el mismo cliente.
     */
    public function incrementarUso(ClienteMembresia $clienteMembresia): void
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($clienteMembresia) {
            // Recargar con lock para evitar concurrencia
            $cm = ClienteMembresia::with('membresia')
                ->where('id', $clienteMembresia->id)
                ->lockForUpdate()
                ->first();

            if (!$cm) return;

            $cm->increment('usos_usados');
            $cm->refresh();

            $beneficios = $cm->membresia->beneficios ?? [];
            $tipo       = $beneficios['tipo'] ?? null;
            $usosLimite = (int) ($beneficios['usos_limite'] ?? 0);

            // Solo desactivar automáticamente si es tipo 'gratis' con límite definido
            if ($tipo === 'gratis' && $usosLimite > 0 && $cm->usos_usados >= $usosLimite) {
                $cm->update(['estado' => 'vencida']);
            }
        });
    }

    // ─── Helpers privados ────────────────────────────────────────────────────

    private function sinBeneficio(float $precio): array
    {
        return [
            'precio_final'        => $precio,
            'precio_original'     => $precio,
            'descuento_membresia' => 0.0,
            'tipo_descuento'      => null,
            'aplica'              => false,
        ];
    }
}
