<?php
namespace App\Listeners;

use App\Events\ClienteFidelizado;
use App\Mail\ClienteFidelizadoMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EnviarCorreoFidelizacion implements ShouldQueue
{
    public function handle(ClienteFidelizado $event)
    {
        $correo = $event->turno->tur_correo;
        if (!$correo) {
            Log::warning('Cliente fidelizado sin correo', ['turno_id' => $event->turno->tur_id]);
            return;
        }
        try {
            Log::info('Enviando correo de fidelización', ['email' => $correo]);
            Mail::to($correo)
                ->queue(new ClienteFidelizadoMail($event->turno, $event->fidelizacion));
            Log::info('Correo de fidelización encolado exitosamente');
        } catch (\Throwable $e) {
            Log::error('Error enviando correo fidelización', ['error' => $e->getMessage()]);
        }
    }
}