<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Producto;
use App\Models\Kit;
use App\Models\Personal_Sede;
use App\Models\Disponibilidad;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Mail\TurnoPagoPendienteMail;
use App\Mail\TurnoPagoConfirmadoMail;
use App\Mail\TurnoClienteMail;
use App\Mail\TurnoAdminMail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Membresia;


class HomeController extends Controller
{
    public function servicios()
    {
        $servicios = Cache::remember('public.servicios_activos', 600, function () {
            return Servicio::where('serv_estado', 'activo')->get();
        });
        
        return view('Home.Servicio', compact('servicios'));
    }

    public function membresias()
    {
        $membresias = Cache::remember('public.membresias_activas', 600, function () {
            return Membresia::where('activo', true)->orderBy('orden')->orderBy('nombre')->get();
        });
        
        return view('Home.Membresias', compact('membresias'));
    }

    public function index()
{
    // Obtener los 4 servicios más agendados (populares) por cantidad de turnos
    $serviciosDestacados = Servicio::where('serv_estado', 1)
        ->withCount(['turnos as total_turnos' => function($query) {
            $query->where('tur_estado', '!=', 'cancelado');
        }])
        ->orderByDesc('total_turnos')
        ->take(4)
        ->get();

    // Obtener productos destacados (activos, limitados a 8 para el carousel)
    $productosDestacados = Producto::where('pro_estado', 1)
        ->orderBy('pro_nombre')
        ->take(8)
        ->get();

    return view('welcome', compact('serviciosDestacados', 'productosDestacados'));
}

    public function productos()
    {
        $productos = Cache::remember('public.productos_activos', 600, function () {
            return Producto::where('pro_estado', 1)->orderBy('pro_nombre')->get();
        });
        
        return view('Home.Productos', compact('productos'));
    }

    public function nosotros()
    {
        // Obtener todos los barberos activos
        $barberos = \App\Models\Personal_Sede::where('persede_estado', 'activo')->with('persona.usuario')->get();
        $admin = \App\Models\Usuario::where('rol', 'admin')->with('persona')->first();
        return view('Home.Nosotros', compact('barberos', 'admin'));
    }

    public function enviarContacto(Request $request)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email',
        'telefono' => 'nullable|string|max:30',
        'asunto' => 'required|string',
        'mensaje' => 'required|string',
    ]);

    Mail::send('emails.contacto', $data, function($message) use ($data) {
        $message->to('hbrbrshop@gmail.com')
                ->subject('Nuevo mensaje de contacto: ' . $data['asunto']);
    });

    return back()->with('ok', 'Mensaje enviado correctamente.');
}
public function contacto()
{
    $sedes = \App\Models\Sede::all();
    
    // Generar URLs de Google Maps para cada sede
    // Prioriza coordenadas exactas (sede_lat/sede_lng) para mayor precisión en el mapa
    foreach($sedes as $sede) {
        if (!empty($sede->sede_lat) && !empty($sede->sede_lng)) {
            $q = $sede->sede_lat . ',' . $sede->sede_lng;
        } else {
            $q = urlencode($sede->sede_direccion);
        }
        $sede->map_url = "https://maps.google.com/maps?q={$q}&output=embed";
    }
    
    return view('Home.Contacto', compact('sedes'));


}

public function consultarFidelizacion(Request $request)
    {
        $identificacion = null;
        $cliente = null;
        $fidelizacion = null;
        $visitasRequeridas = config('fidelizacion.visitas_requeridas');

        // Solo procesar si es POST y hay identificación
        if ($request->isMethod('post')) {
            $identificacion = $request->input('identificacion');

            if ($identificacion) {
                // Buscar directamente en la tabla de fidelización por cédula o celular
                $fidelizacion = \App\Models\Fidelizacion::where('tur_cedula', $identificacion)
                    ->orWhere('tur_celular', $identificacion)
                    ->first();

                if ($fidelizacion) {
                    // Crear objeto cliente con los datos de fidelización
                    $cliente = (object) [
                        'per_nombre' => $fidelizacion->tur_nombre,
                        'per_apellido' => '', // No hay apellido en la tabla de fidelización
                        'per_documento' => $fidelizacion->tur_cedula,
                        'per_telefono' => $fidelizacion->tur_celular
                    ];
                }
            }
        }

    return view('Home.Fidelizacion', compact('cliente', 'fidelizacion', 'visitasRequeridas', 'identificacion'));
    }

    public function agendar()
    {
        // Obtener barberos activos con sus datos de persona
        $barberos = \App\Models\Personal_Sede::where('persede_estado', 'activo')->with('persona')->get();

        // Obtener todos los servicios activos (incluyendo combos)
        $servicios = Servicio::where('serv_estado', 'activo')->get();

        // Precomputar qué barberos tienen disponibilidad futura o regular (dis_fecha null)
        $today = Carbon::today()->toDateString();
        $documentosConDisponibilidad = Disponibilidad::where('dis_estado', 'disponible')
            ->where(function ($q) use ($today) {
                $q->where('dis_fecha', '>=', $today)
                  ->orWhereNull('dis_fecha');
            })
            ->pluck('per_documento')
            ->unique()
            ->toArray();

        foreach ($barberos as $barbero) {
            $barbero->has_availability = in_array(
                $barbero->persona->per_documento,
                $documentosConDisponibilidad
            );
        }

        return view('Home.Agendar', compact('barberos', 'servicios'));
    }

    
    // Método de debugging eliminado por seguridad. 
    // Usar php artisan tinker en entorno local si necesitas inspeccionar datos.
    
    public function obtenerHorariosDisponibles(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'service_duration' => 'nullable|integer|min:10|max:240',
        ]);

        $barberId = $request->barber_id;
        $date = $request->date;
        $serviceDuration = $request->service_duration ?? 30;

        $dateCarbon = Carbon::parse($date);

        // Si seleccionó "cualquier barbero", obtener todas las disponibilidades
       if ($barberId === 'any') {
    $disponibilidades = Disponibilidad::with('persona')
        ->where('dis_estado', 'disponible')
        ->where(function($q) use ($dateCarbon) {
            $q->where('dis_fecha', $dateCarbon->toDateString())
              ->orWhereNull('dis_fecha');
        })
        ->get();
} else {
    $barbero = Personal_Sede::with('persona')->find($barberId);
    if (!$barbero) {
        return response()->json(['success' => false, 'message' => 'Barbero no encontrado'], 404);
    }

    $perDocumento = $barbero->persona->per_documento;

    $disponibilidades = Disponibilidad::with('persona')
        ->where('per_documento', $perDocumento)
        ->where('dis_estado', 'disponible')
        ->where(function($q) use ($dateCarbon) {
            $q->where('dis_fecha', $dateCarbon->toDateString())
              ->orWhereNull('dis_fecha');
        })
        ->get();
}

if ($disponibilidades->isEmpty()) {
    return response()->json([
        'success' => false,
        'message' => 'No hay disponibilidades para esta fecha'
    ]);  // Sin 404 — el JS debe recibir 200 con success:false
}

        $availableSlots = [];

        // Precargar todos los turnos de las disponibilidades en una sola query
        $disIds = $disponibilidades->pluck('dis_id')->toArray();
        $todosReservados = Turno::where('tur_fecha', $dateCarbon->toDateString())
            ->whereIn('dis_id', $disIds)
            ->get()
            ->groupBy('dis_id');

        // Usar la misma lógica que en el admin
        foreach ($disponibilidades as $disponibilidad) {
            $reservados = ($todosReservados->get($disponibilidad->dis_id) ?? collect())
                ->map(function($t) {
                    return [
                        'hora' => $t->tur_hora,
                        'duracion' => (int) $t->tur_duracion,
                        'estado' => $t->tur_estado
                    ];
                });

            // Generar slots de tiempo
            $startTime = strtotime($disponibilidad->dis_hora_inicio);
            $endTime = strtotime($disponibilidad->dis_hora_fin);
            $step = $serviceDuration; // Usar duración del servicio como paso
            
            $currentSlotTime = $startTime;
            // Usar la misma condición que en el admin: t + step <= e
            while (($currentSlotTime + ($step * 60)) <= $endTime) {
                $timeString = date('H:i:s', $currentSlotTime);
                $displayTime = date('g:i A', $currentSlotTime);
                
                // Verificar si este slot está ocupado
                $isOccupied = false;
                foreach ($reservados as $turno) {
                    if ($turno['estado'] === 'cancelado') continue;
                    
                    $turnoStart = strtotime($turno['hora']);
                    $turnoEnd = strtotime('+' . $turno['duracion'] . ' minutes', $turnoStart);
                    
                    if ($currentSlotTime >= $turnoStart && $currentSlotTime < $turnoEnd) {
                        $isOccupied = true;
                        break;
                    }
                }

                if (!$isOccupied) {
                    // Evitar duplicados
                    $slotExists = collect($availableSlots)->contains('time', $timeString);
                    if (!$slotExists) {
                        $availableSlots[] = [
                            'time' => $timeString,
                            'display_time' => $displayTime,
                            'dis_id' => $disponibilidad->dis_id
                        ];
                    }
                }

                $currentSlotTime = strtotime("+{$step} minutes", $currentSlotTime);
            }
        }

        // Ordenar los horarios por tiempo
        usort($availableSlots, function($a, $b) {
            return strcmp($a['time'], $b['time']);
        });

        return response()->json([
            'success' => true,
            'available_slots' => $availableSlots
        ]);
    }

    /**
     * Verifica si un barbero tiene disponibilidades futuras o regulares.
     * Usado por el frontend para bloquear avance si no hay horarios.
     */
    public function checkBarberAvailability(Request $request)
    {
        $request->validate([
            'barber_id' => 'required'
        ]);

        $barberId = $request->input('barber_id');

        // Si elige "any" asumimos que sí hay disponibilidad colectiva
        if ($barberId === 'any') {
            return response()->json(['available' => true]);
        }

        $barbero = Personal_Sede::with('persona')->find($barberId);
        if (!$barbero) {
            return response()->json(['available' => false, 'message' => 'Barbero no encontrado.'], 200);
        }

        $perDocumento = $barbero->persona->per_documento;

        $today = Carbon::today()->toDateString();

        // Buscar disponibilidades marcadas como disponibles, ya sea por fecha futura o regulares (dis_fecha null)
        $tiene = Disponibilidad::where('per_documento', $perDocumento)
            ->where('dis_estado', 'disponible')
            ->where(function($q) use ($today) {
                $q->where('dis_fecha', '>=', $today)
                  ->orWhereNull('dis_fecha');
            })
            ->exists();

        if ($tiene) {
            return response()->json(['available' => true]);
        }

        return response()->json(['available' => false, 'message' => 'Este barbero no cuenta con disponibilidad.']);
    }

    public function agendarCita(Request $request)
    {
        try {
            Log::info('Datos recibidos para agendar cita:', $request->all());
            
            // Validar datos
            $validated = $request->validate([
                'barber' => 'required',
                'type' => 'required|string|in:servicio,combo',
                'serv_id' => 'nullable|integer|exists:servicios,serv_id',
                'combo_id' => 'nullable',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|date_format:H:i:s',
                'client_name' => 'required|string|max:255',
                'client_cedula' => 'required|string|max:20|regex:/^[0-9]+$/',
                'client_phone' => 'required|string|max:20|regex:/^[0-9]+$/',
                'client_email' => 'nullable|email|max:255',
                'client_birthdate' => 'nullable|date|before_or_equal:today',
                'has_payment' => 'required|boolean',
                'transaction_reference' => 'nullable|string|max:255'
            ]);

            // Limpiar email si viene vacío
            if (empty($validated['client_email'])) {
                $validated['client_email'] = null;
            }

            // Obtener los detalles del barbero y servicio
            if ($validated['barber'] !== 'any') {
                $barbero = Personal_Sede::with('persona')->find($validated['barber']);
                if (!$barbero) {
                    return response()->json(['success' => false, 'message' => 'Barbero no encontrado'], 404);
                }
                $per_documento = $barbero->persona->per_documento;
                $barberoAsignado = $barbero;
            } else {
                // Lógica para asignar automáticamente un barbero disponible
                $barberoAsignado = $this->asignarBarberoAutomatico($validated['date'], $validated['time']);
                if (!$barberoAsignado) {
                    return response()->json(['success' => false, 'message' => 'No hay barberos disponibles para esta fecha y hora'], 404);
                }
                $per_documento = $barberoAsignado->persona->per_documento;
            }

            // Obtener servicio o combo (ambos están en la tabla servicios)
            if ($validated['type'] === 'combo') {
                $servicio = Servicio::where('serv_id', $validated['serv_id'])
                    ->where('serv_categoria', 'combos')
                    ->first();
                if (!$servicio) {
                    return response()->json(['success' => false, 'message' => 'Combo no encontrado'], 404);
                }
                $combo = null;
            } else {
                $servicio = Servicio::where('serv_id', $validated['serv_id'])->first();
                if (!$servicio) {
                    return response()->json(['success' => false, 'message' => 'Servicio no encontrado'], 404);
                }
                $combo = null;
            }

            // Obtener disponibilidad específica
            $disponibilidad = Disponibilidad::where('per_documento', $per_documento)
                ->where('dis_fecha', $validated['date'])
                ->where('dis_estado', 'disponible')
                ->first();

            if (!$disponibilidad) {
                return response()->json(['success' => false, 'message' => 'No hay disponibilidad para esta fecha y hora'], 404);
            }

            // Verificar que el horario esté realmente disponible
            $horaInicioSlot = strtotime($validated['time']);
            $duracion = $servicio ? $servicio->serv_duracion : 30;
            $horaFinSlot = strtotime('+' . $duracion . ' minutes', $horaInicioSlot);

            // Verificar conflictos con otros turnos
            $conflictos = Turno::where('dis_id', $disponibilidad->dis_id)
                ->where('tur_fecha', $validated['date'])
                ->where('tur_estado', '!=', 'cancelado')
                ->get();

            foreach ($conflictos as $turnoExistente) {
                $turnoInicio = strtotime($turnoExistente->tur_hora);
                $turnoFin = strtotime('+' . $turnoExistente->tur_duracion . ' minutes', $turnoInicio);

                // Verificar solapamiento
                if (($horaInicioSlot < $turnoFin) && ($horaFinSlot > $turnoInicio)) {
                    return response()->json(['success' => false, 'message' => 'El horario seleccionado ya no está disponible'], 409);
                }
            }

            $dis_id = $disponibilidad->dis_id;

            // Determinar estado del turno según el pago
            $estadoPago = $validated['has_payment'] ? 'pendiente_pago' : 'sin_anticipo';
            $anticipo = $validated['has_payment'] ? 10000 : null;

            // Crear el turno
            $turno = Turno::create([
                'dis_id' => $dis_id,
                'serv_id' => $servicio ? $servicio->serv_id : null,
                'combo_id' => null, // Combos ahora se gestionan desde la tabla servicios
                'per_documento' => $per_documento,
                'tur_fecha' => $validated['date'],
                'tur_hora' => $validated['time'],
                'tur_duracion' => $duracion,
                'tur_nombre' => $validated['client_name'],
                'tur_cedula' => $validated['client_cedula'],
                'tur_celular' => $validated['client_phone'],
                'tur_correo' => $validated['client_email'],
                'tur_fecha_nacimiento' => $validated['client_birthdate'] ?? null,
                'tur_estado' => 'pendiente',
                'tur_estado_pago' => $estadoPago,
                'tur_anticipo' => $anticipo,
                'tur_referencia_pago' => $validated['transaction_reference'],
                'tur_fecha_pago' => null // Se actualiza cuando el admin confirme
            ]);

            Log::info('Turno creado exitosamente:', $turno->toArray());

            // Enviar emails según el estado de pago
            if ($estadoPago === 'pendiente_pago') {
                // Solo enviar al admin notificando pago pendiente
                $this->enviarEmailAdminPagoPendiente($turno, $barberoAsignado, $servicio);
            } else {
                // Enviar emails normales a ambos (admin y cliente)
                $this->enviarEmailsConfirmacion($turno, $barberoAsignado, $servicio);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cita agendada exitosamente',
                'turno_id' => $turno->tur_id,
                'barbero_asignado' => [
                    'id' => $barberoAsignado->persede_id,
                    'nombre' => $barberoAsignado->persona->per_nombre,
                    'fue_asignado_automaticamente' => $validated['barber'] === 'any'
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al agendar cita:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al agendar la cita. Intente nuevamente.'
            ], 500);
        }
    }

    private function enviarEmailAdminPagoPendiente($turno, $barbero, $servicio)
    {
        // Enviar email al admin sobre pago pendiente
        try {
            $adminEmail = config('mail.admin_address', 'admin@hbarbershop.com');
            
            Mail::to($adminEmail)->send(new TurnoPagoPendienteMail($turno, $servicio, $barbero));
            
            Log::info('Email de pago pendiente enviado al admin', [
                'turno_id' => $turno->tur_id,
                'admin_email' => $adminEmail
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error sending admin payment pending email: ' . $e->getMessage());
        }
    }

    private function enviarEmailsConfirmacion($turno, $barbero, $servicio)
    {
        // Enviar emails normales de confirmación (sin anticipo)
        try {
            // Email al cliente
            if ($turno->tur_correo) {
                Mail::to($turno->tur_correo)->send(new TurnoClienteMail($turno));
                Log::info('Email de confirmación enviado al cliente', [
                    'turno_id' => $turno->tur_id,
                    'client_email' => $turno->tur_correo
                ]);
            }
            
            // Email al admin
            $adminEmail = config('mail.admin_address', 'admin@hbarbershop.com');
            Mail::to($adminEmail)->send(new TurnoAdminMail($turno));
            
            Log::info('Email de notificación enviado al admin', [
                'turno_id' => $turno->tur_id,
                'admin_email' => $adminEmail
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error sending confirmation emails: ' . $e->getMessage());
        }
    }

    /**
     * Asigna automáticamente un barbero disponible para la fecha y hora solicitada
     */
    private function asignarBarberoAutomatico($fecha, $hora)
    {
        try {
            // Obtener todas las disponibilidades para la fecha
            $disponibilidades = Disponibilidad::with('persona')
                ->where('dis_fecha', $fecha)
                ->where('dis_estado', 'disponible')
                ->get();

            if ($disponibilidades->isEmpty()) {
                Log::info('No hay disponibilidades para la fecha', ['fecha' => $fecha]);
                return null;
            }

            // Precargar todos los turnos de las disponibilidades en una sola query
            $disIds = $disponibilidades->pluck('dis_id')->toArray();
            $turnosPorDis = Turno::where('tur_fecha', $fecha)
                ->where('tur_estado', '!=', 'cancelado')
                ->whereIn('dis_id', $disIds)
                ->get()
                ->groupBy('dis_id');

            // Precargar barberos activos por documento
            $documentos = $disponibilidades->pluck('per_documento')->unique()->toArray();
            $barberosPorDoc = Personal_Sede::with('persona')
                ->whereIn('per_documento', $documentos)
                ->where('persede_estado', 'activo')
                ->get()
                ->keyBy('per_documento');

            $horaInicio = strtotime($hora);

            foreach ($disponibilidades as $disponibilidad) {
                // Verificar que la hora esté dentro del rango de disponibilidad
                $inicioDisponibilidad = strtotime($disponibilidad->dis_hora_inicio);
                $finDisponibilidad = strtotime($disponibilidad->dis_hora_fin);

                if ($horaInicio < $inicioDisponibilidad || $horaInicio >= $finDisponibilidad) {
                    continue;
                }

                // Verificar conflictos con turnos precargados
                $turnos = $turnosPorDis->get($disponibilidad->dis_id, collect());

                $tieneConflicto = false;
                foreach ($turnos as $turno) {
                    $turnoInicio = strtotime($turno->tur_hora);
                    $turnoFin = strtotime('+' . $turno->tur_duracion . ' minutes', $turnoInicio);
                    $horaFin = strtotime('+30 minutes', $horaInicio);
                    if (($horaInicio < $turnoFin) && ($horaFin > $turnoInicio)) {
                        $tieneConflicto = true;
                        break;
                    }
                }

                if (!$tieneConflicto) {
                    $barbero = $barberosPorDoc->get($disponibilidad->per_documento);
                    if ($barbero) {
                        Log::info('Barbero asignado automáticamente', [
                            'barbero_id' => $barbero->persede_id,
                            'barbero_nombre' => $barbero->persona->per_nombre,
                            'fecha' => $fecha,
                            'hora' => $hora
                        ]);
                        return $barbero;
                    }
                }
            }

            Log::info('No se pudo asignar barbero automático - todos ocupados', [
                'fecha' => $fecha,
                'hora' => $hora,
                'disponibilidades_revisadas' => $disponibilidades->count()
            ]);
            
            return null;

        } catch (\Exception $e) {
            Log::error('Error al asignar barbero automático', [
                'error' => $e->getMessage(),
                'fecha' => $fecha,
                'hora' => $hora,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Genera QR code para Nequi
     */
    public function generateNequiQR()
    {
        try {
            // Datos para Nequi
            $nequiPhone = '3118104544';
            $amount = 10000;
            $message = 'Anticipo H Barber Shop';
            
            // Formato correcto para Nequi QR - usar formato de transferencia
            $nequiData = json_encode([
                'type' => 'nequi_transfer',
                'phone' => $nequiPhone,
                'amount' => $amount,
                'message' => $message,
                'currency' => 'COP'
            ]);
            
            // Alternativamente, usar formato URL scheme de Nequi
            $nequiUrl = "nequi://qr?phone={$nequiPhone}&amount={$amount}&message=" . urlencode($message);
            
            // Generar QR usando SimpleSoftwareIO
            $qr = QrCode::format('svg')
                ->size(300)
                ->color(109, 40, 217) // Color morado de Nequi
                ->backgroundColor(255, 255, 255)
                ->margin(2)
                ->generate($nequiUrl);
            
            return response($qr, 200)->header('Content-Type', 'image/svg+xml');
            
        } catch (\Exception $e) {
            Log::error('Error generando QR de Nequi: ' . $e->getMessage());
            
            // Generar QR con datos simples como fallback
            try {
                $fallbackData = "NEQUI\nTel: {$nequiPhone}\nMonto: $10,000\nConcepto: Anticipo H Barber Shop";
                $qr = QrCode::format('svg')
                    ->size(300)
                    ->color(109, 40, 217)
                    ->backgroundColor(255, 255, 255)
                    ->margin(2)
                    ->generate($fallbackData);
                
                return response($qr, 200)->header('Content-Type', 'image/svg+xml');
            } catch (\Exception $e2) {
                // Si todo falla, usar el SVG de respaldo
                $fallbackSvg = $this->generateNequiFallbackQR();
                return response($fallbackSvg, 200)->header('Content-Type', 'image/svg+xml');
            }
        }
    }

    /**
     * Genera QR code para Daviplata
     */
    public function generateDaviplataQR()
    {
        try {
            // Número de teléfono de H Barber Shop para Daviplata
            $daviplataPhone = '3118104544';
            $amount = 10000;
            $message = 'Anticipo H Barber Shop';
            
            // URL scheme para abrir Daviplata
            $daviplataUrl = "daviplata://send?phone={$daviplataPhone}&amount={$amount}&message=" . urlencode($message);
            
            // Generar QR usando SimpleSoftwareIO
            $qr = QrCode::format('svg')
                ->size(300)
                ->color(255, 140, 0) // Color naranja de Daviplata
                ->backgroundColor(255, 255, 255)
                ->margin(2)
                ->generate($daviplataUrl);
            
            return response($qr, 200)->header('Content-Type', 'image/svg+xml');
            
        } catch (\Exception $e) {
            Log::error('Error generando QR de Daviplata: ' . $e->getMessage());
            
            // Generar QR con datos simples como fallback
            try {
                $fallbackData = "DAVIPLATA\nTel: {$daviplataPhone}\nMonto: $10,000\nConcepto: Anticipo H Barber Shop";
                $qr = QrCode::format('svg')
                    ->size(300)
                    ->color(255, 140, 0)
                    ->backgroundColor(255, 255, 255)
                    ->margin(2)
                    ->generate($fallbackData);
                
                return response($qr, 200)->header('Content-Type', 'image/svg+xml');
            } catch (\Exception $e2) {
                // Si todo falla, usar el SVG de respaldo
                $fallbackSvg = $this->generateFallbackQR('Daviplata', '#ff8c00');
                return response($fallbackSvg, 200)->header('Content-Type', 'image/svg+xml');
            }
        }
    }

    /**
     * Genera QR code alternativo para Nequi con formato simple
     */
    public function generateNequiQRAlternative()
    {
        try {
            // Datos simples para Nequi
            $nequiPhone = '3118104544';
            $amount = 10000;
            $message = 'Anticipo H Barber Shop';
            
            // Formato de texto plano más compatible
            $nequiData = "TRANSFERENCIA NEQUI\n" .
                        "Destino: {$nequiPhone}\n" .
                        "Valor: \${$amount}\n" .
                        "Concepto: {$message}\n" .
                        "Barberia H Barber Shop";
            
            // Generar QR usando SimpleSoftwareIO con formato simple
            $qr = QrCode::format('svg')
                ->size(300)
                ->color(109, 40, 217) // Color morado de Nequi
                ->backgroundColor(255, 255, 255)
                ->margin(2)
                ->errorCorrection('H') // High error correction
                ->generate($nequiData);
            
            return response($qr, 200)->header('Content-Type', 'image/svg+xml');
            
        } catch (\Exception $e) {
            Log::error('Error generando QR alternativo de Nequi: ' . $e->getMessage());
            
            // Fallback al método normal
            return $this->generateNequiQR();
        }
    }

    /**
     * Obtiene información de pago con QR codes
     */
    public function getPaymentInfo()
    {
        return response()->json([
            'success' => true,
            'payment_info' => [
                'amount' => 10000,
                'concept' => 'Anticipo H Barber Shop',
                'phone' => '3118104544',
                'nequi_qr_url' => route('generate.nequi.qr'),
                'daviplata_qr_url' => route('generate.daviplata.qr')
            ]
        ]);
    }

    /**
     * Genera un QR de respaldo simple cuando la API falla
     */
    private function generateNequiFallbackQR()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
        <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
            <rect width="300" height="300" fill="white" stroke="#6d28d9" stroke-width="2"/>
            <circle cx="150" cy="80" r="25" fill="#6d28d9"/>
            <text x="150" y="87" text-anchor="middle" fill="white" font-size="20" font-weight="bold">N</text>
            <text x="150" y="120" text-anchor="middle" fill="#6d28d9" font-size="18" font-weight="bold">Nequi</text>
            <text x="150" y="145" text-anchor="middle" fill="#333" font-size="16">$10,000 COP</text>
            <text x="150" y="170" text-anchor="middle" fill="#666" font-size="12">Para pagar:</text>
            <text x="150" y="190" text-anchor="middle" fill="#666" font-size="11">1. Abre tu app Nequi</text>
            <text x="150" y="205" text-anchor="middle" fill="#666" font-size="11">2. Busca "Enviar dinero"</text>
            <text x="150" y="220" text-anchor="middle" fill="#666" font-size="11">3. Número: +57 311-810-4544</text>
            <text x="150" y="235" text-anchor="middle" fill="#666" font-size="11">4. Monto: $10,000</text>
            <text x="150" y="250" text-anchor="middle" fill="#666" font-size="11">5. Mensaje: Anticipo H Barber Shop</text>
            <text x="150" y="275" text-anchor="middle" fill="#999" font-size="10">QR no disponible temporalmente</text>
        </svg>';
    }

    private function generateFallbackQR($platform, $color)
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
        <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
            <rect width="200" height="200" fill="white" stroke="' . $color . '" stroke-width="2"/>
            <text x="100" y="80" text-anchor="middle" fill="' . $color . '" font-size="16" font-weight="bold">' . $platform . '</text>
            <text x="100" y="100" text-anchor="middle" fill="#333" font-size="12">$10,000 COP</text>
            <text x="100" y="120" text-anchor="middle" fill="#666" font-size="10">Tel: 311-810-4544</text>
            <text x="100" y="135" text-anchor="middle" fill="#666" font-size="10">Anticipo H Barber Shop</text>
            <text x="100" y="160" text-anchor="middle" fill="#999" font-size="9">Escanea con la app ' . $platform . '</text>
        </svg>';
    }
}    
