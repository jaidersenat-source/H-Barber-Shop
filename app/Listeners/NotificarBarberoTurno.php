<?php
namespace App\Listeners;

use App\Events\TurnoRegistrado;
use App\Notifications\TurnoBarbero;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotificarBarberoTurno implements ShouldQueue
{
    public function handle(TurnoRegistrado $event)
    {
        Log::info('Listener NotificarBarberoTurno ejecutado', ['turno_id' => $event->turno->tur_id]);
        
       $barbero = $event->turno->barbero;
    if (!$barbero) {
        Log::warning('No se encontró el barbero para el turno', ['turno_id' => $event->turno->tur_id]);
        return;
    }
    
    Log::info('Barbero encontrado', ['barbero_doc' => $barbero->per_documento, 'correo' => $barbero->per_correo]);
    if (!$barbero->per_correo) {
        Log::warning('El barbero no tiene email configurado', ['barbero_doc' => $barbero->per_documento]);
        return;
    }

    try {
        Log::info('Enviando correo al barbero', ['email' => $barbero->per_correo]);
        \Illuminate\Support\Facades\Mail::to($barbero->per_correo)
            ->queue(new \App\Mail\TurnoBarberoMail($event->turno));
        Log::info('Correo barbero encolado exitosamente');
    } catch (\Throwable $e) {
        Log::error('Error enviando correo barbero', ['error' => $e->getMessage()]);
    }
    }
}