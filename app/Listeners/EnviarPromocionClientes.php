<?php
namespace App\Listeners;

use App\Events\PromocionCreada;
use App\Mail\PromocionMail;
use App\Models\Turno;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnviarPromocionClientes implements ShouldQueue
{
    public function handle(PromocionCreada $event)
    {
        // Obtener todos los correos únicos de clientes registrados en turnos
        $correos = Turno::whereNotNull('tur_correo')
            ->pluck('tur_correo')
            ->unique()
            ->filter(function($correo){ return filter_var($correo, FILTER_VALIDATE_EMAIL); });

        Log::info('Enviando promoción a clientes', ['total' => $correos->count()]);
        foreach ($correos as $correo) {
            try {
                Mail::to($correo)
                    ->queue(new PromocionMail($event->tipo, $event->item));
            } catch (\Throwable $e) {
                Log::error('Error enviando promoción', ['email' => $correo, 'error' => $e->getMessage()]);
            }
        }
    }
}