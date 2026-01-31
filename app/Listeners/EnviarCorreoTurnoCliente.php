<?php
namespace App\Listeners;

use App\Events\TurnoRegistrado;
use App\Mail\TurnoClienteMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnviarCorreoTurnoCliente implements ShouldQueue
{
    public function handle(TurnoRegistrado $event)
    {
        Log::info('Listener EnviarCorreoTurnoCliente ejecutado', [
            'turno_id' => $event->turno->tur_id,
            'tur_correo' => $event->turno->tur_correo
        ]);
        
        if (!$event->turno->tur_correo) {
            Log::warning('El turno no tiene correo del cliente', ['turno_id' => $event->turno->tur_id]);
            return;
        }
        
        try {
            Log::info('Enviando correo al cliente', ['email' => $event->turno->tur_correo]);
            Mail::to($event->turno->tur_correo)
                ->queue(new TurnoClienteMail($event->turno));
            Log::info('Correo cliente encolado exitosamente');
        } catch (\Throwable $e) {
            Log::error('Error enviando correo cliente', ['error' => $e->getMessage()]);
        }
    }
}