<?php
namespace App\Listeners;

use App\Events\TurnoRegistrado;
use App\Notifications\NuevoTurnoAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notifications;
use Illuminate\Support\Facades\Log;

class NotificarAdminNuevoTurno implements ShouldQueue
{
    public function handle(TurnoRegistrado $event)
{
    Log::info('Listener NotificarAdminNuevoTurno ejecutado', ['turno_id' => $event->turno->tur_id]);
    
    // Busca usuarios admin
    $admins = \App\Models\Usuario::where('rol', 'admin')->get();
    Log::info('Admins encontrados', ['count' => $admins->count()]);         
    foreach ($admins as $admin) {
        Log::info('Procesando admin', ['admin_doc' => $admin->per_documento]);
        
        // Busca la persona relacionada
        $persona = \App\Models\Persona::where('per_documento', $admin->per_documento)->first();
        
        if ($persona) {
            Log::info('Persona encontrada', ['correo' => $persona->per_correo]);
            
            if ($persona->per_correo) {
                try {
                    Log::info('Enviando correo a admin', ['email' => $persona->per_correo]);
                    \Illuminate\Support\Facades\Mail::to($persona->per_correo)
                        ->queue(new \App\Mail\TurnoAdminMail($event->turno));
                    Log::info('Correo admin encolado exitosamente');
                } catch (\Throwable $e) {
                    Log::error('Error enviando correo admin', ['error' => $e->getMessage()]);
                }
            } else {
                Log::warning('Admin sin correo', ['admin_doc' => $admin->per_documento]);
            }
        } else {
            Log::warning('Persona no encontrada para admin', ['admin_doc' => $admin->per_documento]);
        }
    }
 }
}