<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disponibilidad;
use App\Models\Turno;
use App\Models\Servicio;
use App\Models\Personal_Sede;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\TurnoRegistrado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Mail\TurnoPagoConfirmadoMail;

class TurnoController extends Controller
{
    // ============================
    // LISTAR TURNOS
    // ============================
    public function index(Request $request)
    {
        $query = Turno::with('disponibilidad.persona');

        // Si NO hay búsqueda activa, mostrar solo turnos pendientes y realizados sin factura
        $hayBusqueda = $request->filled('cedula') || $request->filled('nombre') || $request->filled('buscar');
        if (!$hayBusqueda) {
            $query->where(function($q) {
                $q->where('tur_estado', 'Pendiente')
                    ->orWhere(function($sub) {
                        $sub->where('tur_estado', 'Realizado')
                             ->whereDoesntHave('factura');
                    });
            });
        }

        if ($request->filled('estado') === true) {
            $query->where('tur_estado', $request->estado);
        }

        if ($request->filled('estado_pago') === true) {
            $query->where('tur_estado_pago', $request->estado_pago);
        }

        if ($request->filled('fecha') === true) {
            $query->where('tur_fecha', $request->fecha);
        }

        // Búsqueda por cédula o nombre (muestra todos los estados)
        if ($request->filled('buscar')) {
            $b = $request->buscar;
            $query->where(function($q) use ($b) {
                $q->where('tur_cedula', 'like', "%$b%")
                  ->orWhere('tur_nombre', 'like', "%$b%");
            });
        }

        $turnos = $query->orderBy('tur_fecha')
                        ->orderBy('tur_hora')
                        ->paginate(20)
                        ->withQueryString();

        return view('admin.turnos.index', compact('turnos'));
    }

    // ============================
    // CANCELAR TURNO
    // ============================
    public function cancel($id)
    {
        $turno = Turno::findOrFail($id);

        if ($turno->tur_estado === 'Cancelado') {
            return back()->with('error', 'Este turno ya fue cancelado anteriormente.');
        }
        if ($turno->tur_estado === 'Realizado') {
            return back()->with('error', 'No se puede cancelar un turno que ya fue realizado.');
        }

        $turno->tur_estado = 'Cancelado';
        $turno->save();

        Cache::forget('dashboard.pendientes');
        return back()->with('ok', 'Turno cancelado correctamente');
    }

    // ============================
    // COMPLETAR TURNO
    // ============================
    public function complete($id)
    {
        $turno = Turno::findOrFail($id);

        if ($turno->tur_estado === 'Realizado') {
            return back()->with('error', 'Este turno ya fue marcado como realizado.');
        }
        if ($turno->tur_estado === 'Cancelado') {
            return back()->with('error', 'No se puede completar un turno cancelado.');
        }

        $turno->tur_estado = 'Realizado';
        $turno->save();

        Cache::forget('dashboard.pendientes');

        // No llamar agregarPunto aquí: solo se suma al crear la factura del turno

        return back()->with('ok', 'Turno marcado como realizado');
    }

    // ============================
    // FORMULARIO CREAR TURNO
    // ============================
    public function create()
    {
        $servicios = Servicio::where('serv_estado', 'activo')->get();
        return view('admin.turnos.create', compact('servicios'));
    }

    // ============================
    // DISPONIBILIDAD POR FECHA (AJAX)
    // ============================
    public function availableByDate(Request $request)
    {
        $request->validate(['date' => 'required|date']);

        $date = Carbon::parse($request->date);

        // Solo mostrar disponibilidades de la fecha seleccionada y futuras
        if ($date->lt(Carbon::today()) === true) {
            return response()->json([
                'error' => 'No se pueden mostrar horarios de fechas pasadas.',
                'aria' => true
            ], 422);
        }

        $disponibilidades = Disponibilidad::with('persona')
            ->whereDate('dis_fecha', $date->toDateString())
            ->where('dis_estado', 'disponible')
            ->get();

        if ($disponibilidades->isEmpty() === true) {
            return response()->json([
                'error' => 'No hay disponibilidad para el día seleccionado. Por favor, elija otra fecha.',
                'aria' => true
            ], 404);
        }

        $result = [];
        $step = 20;
        if ($request->filled('servicio_id') === true) {
            $serv = Servicio::find($request->servicio_id);
            if ($serv !== null) {
                $step = (int) $serv->serv_duracion;
            }
        }

        $disIds = $disponibilidades->pluck('dis_id');
        $turnosPorDis = Turno::whereIn('dis_id', $disIds)
            ->where('tur_fecha', $date->toDateString())
            ->get()
            ->groupBy('dis_id');

        foreach ($disponibilidades as $d) {
            $reservados = ($turnosPorDis[$d->dis_id] ?? collect())->map(function($t){
                    return [
                        'hora' => $t->tur_hora,
                        'duracion' => (int) $t->tur_duracion,
                        'estado' => $t->tur_estado
                    ];
                });

            $result[] = [
                'dis_id' => $d->dis_id,
                'barbero' => ($d->persona !== null)? $d->persona->per_nombre . ' ' . $d->persona->per_apellido: $d->persona->per_documento,
                'hora_inicio' => $d->dis_hora_inicio,
                'hora_fin' => $d->dis_hora_fin,
                'reservados' => $reservados,
                'step' => $step,
            ];
        }

        return response()->json([
            'date' => $date->toDateString(),
            'items' => $result
        ]);
    }

    // ============================
    // GUARDAR TURNO
    // ============================
    public function store(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson();
        try {
            $validated = $request->validate([
                'dis_id' => 'required|exists:disponibilidad,dis_id',
                'tur_fecha' => 'required|date',
                'tur_hora' => 'required',
                'tur_nombre' => 'required',
                'tur_cedula' => 'nullable|string|max:30',
                'tur_celular' => 'required|digits:10',
                'tur_correo' => 'nullable|email',
                'tur_fecha_nacimiento' => 'nullable|date|before_or_equal:today',
            ], [
                'tur_celular.digits' => 'El número de celular debe tener exactamente 10 dígitos.',
                'tur_fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser mayor a hoy.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax === true) {
                $msg = collect($e->validator->errors()->all())->implode(' ');
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            throw $e;
        }

        $dis = Disponibilidad::findOrFail($request->dis_id);
        $date = Carbon::parse($request->tur_fecha);

        // Validar que la fecha no sea pasada
        if ($date->lt(Carbon::today()) === true) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'No se pueden registrar turnos en fechas pasadas.'], 422);
            }
            return back()->withErrors(['tur_fecha' => 'No se pueden registrar turnos en fechas pasadas.'])->withInput();
        }

        // Validar día
        $dayName = $this->diaDelSemanaTexto($date);
        if ($dayName !== $dis->dia) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'El barbero no trabaja ese día.'], 422);
            }
            return back()->withErrors(['tur_fecha' => 'El barbero no trabaja ese día.'])->withInput();
        }

        // Duración
        $duration = 0;
        if ($request->filled('servicio_id') === true) {
         $serv = Servicio::find($request->servicio_id);
            if ($serv !== null) $duration = (int) $serv->serv_duracion;
        }
      if (($duration === null || $duration === 0) && $request->filled('tur_duracion') === true) {
          $duration = (int) $request->tur_duracion;
        }

        // Validar franja
        $startMin = $this->toMinutes($request->tur_hora);
        $endMin = $startMin + ($duration ?? 0);
  

        $franjaStart = $this->toMinutes($dis->dis_hora_inicio);
        $franjaEnd = $this->toMinutes($dis->dis_hora_fin);

      if ($duration !== null && $duration > 0 && $endMin > $franjaEnd) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'El servicio no cabe dentro de la disponibilidad'], 422);
            }
            return back()->withErrors(['tur_hora' => 'El servicio no cabe dentro de la disponibilidad'])->withInput();
        }

        // Validar solapamiento
        $existing = Turno::where('dis_id', $dis->dis_id)
            ->where('tur_fecha', $date->toDateString())
            ->get();

        foreach ($existing as $e) {
            $eStart = $this->toMinutes($e->tur_hora);
            $eEnd = $eStart + ((int)$e->tur_duracion);

            if ($duration !== null && $duration > 0 && ($startMin < $eEnd && $endMin > $eStart)) {
                if ($isAjax) {
                    return response()->json(['success' => false, 'message' => 'Horario ocupado por otro turno'], 422);
                }
                return back()->withErrors(['tur_hora' => 'Horario ocupado por otro turno'])->withInput();
            }

            if (($duration === null || $duration === 0) && $startMin === $eStart) {
                if ($isAjax) {
                    return response()->json(['success' => false, 'message' => 'Ese horario ya está reservado'], 422);
                }
                return back()->withErrors(['tur_hora' => 'Ese horario ya está reservado'])->withInput();
            }
        }


        // Guardar turno
        $turno = Turno::create([
            'dis_id'              => $dis->dis_id,
            'serv_id'             => $request->filled('servicio_id') ? (int) $request->servicio_id : null,
            'per_documento'       => $dis->per_documento,
            'tur_fecha'           => $date->toDateString(),
            'tur_hora'            => $request->tur_hora,
            'tur_duracion'        => $duration ?? null,
            'tur_nombre'          => $request->tur_nombre,
            'tur_cedula'          => $request->tur_cedula,
            'tur_celular'         => $request->tur_celular,
            'tur_correo'          => $request->tur_correo,
            'tur_fecha_nacimiento' => $request->tur_fecha_nacimiento ?? null,
            'tur_estado'          => 'Pendiente',
        ]);

        event(new TurnoRegistrado($turno));

        if ($isAjax) {
            return response()->json(['success' => true, 'message' => 'Turno registrado correctamente', 'turno_id' => $turno->tur_id]);
        }
        return redirect()->route('turnos.index')->with('ok', 'Turno creado correctamente.');
    }

    // ============================
    // Helpers
    // ============================
    private function diaDelSemanaTexto(Carbon $date)
    {
        return [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ][$date->format('l')];
    }

    private function toMinutes(string $time)
    {
        [$h, $m] = explode(':', $time);
        return ((int)$h) * 60 + ((int)$m);
    }

    /**
     * Reprogramar turno: actualizar fecha y hora
     */
    public function reprogramar(Request $request, $id)
    {
        $request->validate([
            'tur_fecha' => 'required|date|after_or_equal:today',
            'tur_hora' => 'required',
        ]);
        $turno = \App\Models\Turno::findOrFail($id);
        if ($turno->tur_estado !== 'Pendiente') {
            return back()->with('error', 'Solo se pueden reprogramar turnos pendientes.');
        }
        $turno->tur_fecha = $request->tur_fecha;
        $turno->tur_hora = $request->tur_hora;
        $turno->save();
        // Opcional: notificar usuario/barbero aquí
        return back()->with('ok', 'Turno reprogramado correctamente.');
    }

        // ============================
    // BUSCAR TURNO POR CÉDULA (AJAX)
    // ============================
    public function buscarPorCedula($cedula)
    {
        // Sanitizar: solo permitir dígitos
        $cedula = preg_replace('/[^0-9]/', '', $cedula);
        if (empty($cedula) || strlen($cedula) > 20) {
            return response()->json(['success' => false, 'data' => null], 422);
        }

        $turno = \App\Models\Turno::where('tur_cedula', $cedula)->latest('tur_id')->first();
        if ($turno) {
            return response()->json([
                'success' => true,
                'data' => [
                    'tur_nombre' => $turno->tur_nombre,
                    'tur_cedula' => $turno->tur_cedula,
                    'tur_celular' => $turno->tur_celular,
                    'tur_correo' => $turno->tur_correo,
                    'tur_fecha_nacimiento' => $turno->tur_fecha_nacimiento,
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'data' => null]);
        }
    }

    // ============================
    // CONFIRMAR PAGO
    // ============================
    public function confirmPayment($id)
    {
        try {
            $turno = Turno::with(['servicio', 'disponibilidad.persona'])->findOrFail($id);
            
            if ($turno->tur_estado_pago !== 'pendiente_pago') {
                return back()->with('error', 'Este turno no tiene un pago pendiente de confirmación');
            }
            
            $turno->tur_estado_pago = 'confirmado';
            $turno->tur_fecha_pago = now();
            $turno->save();
            
            // Enviar email de confirmación al cliente
            $this->enviarEmailConfirmacionPago($turno);
            
            return back()->with('ok', 'Pago confirmado exitosamente. Se ha notificado al cliente por email.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al confirmar el pago. Intente nuevamente.');
        }
    }

    // ============================
    // RECHAZAR PAGO
    // ============================
    public function rejectPayment($id)
    {
        try {
            $turno = Turno::findOrFail($id);
            
            if ($turno->tur_estado_pago !== 'pendiente_pago') {
                return back()->with('error', 'Este turno no tiene un pago pendiente de confirmación');
            }
            
            $turno->tur_estado_pago = 'sin_anticipo';
            $turno->tur_anticipo = null;
            $turno->tur_referencia_pago = null;
            $turno->tur_fecha_pago = null;
            $turno->save();
            
            // Aquí puedes agregar la lógica para enviar email al cliente notificando el rechazo
            // $this->enviarEmailRechazo($turno);
            
            return back()->with('ok', 'Pago rechazado. El turno continúa sin anticipo.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al rechazar el pago. Intente nuevamente.');
        }
    }

    // ============================
    // ENVIAR EMAIL CONFIRMACIÓN PAGO
    // ============================
    private function enviarEmailConfirmacionPago($turno)
    {
        try {
            // Solo enviar si el cliente tiene email
            if (!$turno->tur_correo) {
                Log::info('No se pudo enviar email de confirmación de pago - Cliente sin email', [
                    'turno_id' => $turno->tur_id
                ]);
                return;
            }
            
            // Obtener datos relacionados
            $servicio = $turno->servicio ?? Servicio::find($turno->serv_id);
            $barbero = $turno->disponibilidad->persona ?? null;
            
            // Enviar email al cliente
            Mail::to($turno->tur_correo)->send(new TurnoPagoConfirmadoMail($turno, $servicio, $barbero));
            
            Log::info('Email de confirmación de pago enviado exitosamente', [
                'turno_id' => $turno->tur_id,
                'client_email' => $turno->tur_correo,
                'anticipo' => $turno->tur_anticipo
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al enviar email de confirmación de pago', [
                'turno_id' => $turno->tur_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    // ============================
    // GESTIÓN DE QR CODES
    // ============================
    
    /**
     * Mostrar página de gestión de QR
     */
    public function qrManagement()
    {
        return view('Admin.perfil.qr-management');
    }

    /**
     * Subir QR code
     */
    public function uploadQR(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:nequi,daviplata,bancolombia',
            'qr_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            Log::info('Iniciando upload de QR', [
                'tipo' => $request->tipo,
                'archivo' => $request->file('qr_image')->getClientOriginalName()
            ]);

            // Crear directorio si no existe
            $qrPath = public_path('img/qr');
            if (!file_exists($qrPath)) {
                mkdir($qrPath, 0755, true);
                Log::info('Directorio QR creado', ['path' => $qrPath]);
            }

            // Verificar que el directorio es escribible
            if (!is_writable($qrPath)) {
                throw new \Exception('El directorio QR no es escribible: ' . $qrPath);
            }

            // Eliminar QR anterior si existe
            $fileName = $request->tipo . '-qr.png';
            $fullPath = $qrPath . DIRECTORY_SEPARATOR . $fileName;
            
            if (file_exists($fullPath)) {
                unlink($fullPath);
                Log::info('QR anterior eliminado', ['path' => $fullPath]);
            }

            // Subir nuevo archivo
            $image = $request->file('qr_image');
            $uploadResult = $image->move($qrPath, $fileName);
            
            // Verificar que el archivo se subió correctamente
            if (!file_exists($fullPath)) {
                throw new \Exception('El archivo no se subió correctamente: ' . $fullPath);
            }

            Log::info('QR subido exitosamente', [
                'path' => $fullPath,
                'size' => filesize($fullPath)
            ]);

            return redirect()->back()->with('success', 
                'QR de ' . ucfirst($request->tipo) . ' actualizado exitosamente. 
                Los clientes ahora verán tu QR real cuando seleccionen pago por anticipo.'
            );

        } catch (\Exception $e) {
            Log::error('Error al subir QR', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors('Error al subir el QR: ' . $e->getMessage());
        }
    }

}
