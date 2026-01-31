<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disponibilidad;
use App\Models\Turno;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\TurnoRegistrado;

class TurnoController extends Controller
{
    // ============================
    // LISTAR TURNOS
    // ============================
    public function index(Request $request)
    {
        $query = Turno::with('disponibilidad.persona');

                // Mostrar solo turnos pendientes y los realizados que no tienen factura
                $query->where(function($q) {
                        $q->where('tur_estado', 'Pendiente')
                            ->orWhere(function($sub) {
                                    $sub->where('tur_estado', 'Realizado')
                                             ->whereDoesntHave('factura');
                            });
                });

        if ($request->filled('estado')=== true) {
            $query->where('tur_estado', $request->estado);
        }

        if ($request->filled('fecha') === true) {
            $query->where('tur_fecha', $request->fecha);
        }

        $turnos = $query->orderBy('tur_fecha')
                        ->orderBy('tur_hora')
                        ->paginate(20);

        return view('admin.turnos.index', compact('turnos'));
    }

    // ============================
    // CANCELAR TURNO
    // ============================
    public function cancel($id)
    {
        $turno = Turno::findOrFail($id);
        $turno->tur_estado = 'Cancelado';
        $turno->save();

        return back()->with('ok', 'Turno cancelado correctamente');
    }

    // ============================
    // COMPLETAR TURNO
    // ============================
    public function complete($id)
    {
        $turno = Turno::findOrFail($id);
        $turno->tur_estado = 'Realizado';
        $turno->save();

        // Agregar punto de fidelización
        \App\Http\Controllers\Admin\FidelizacionController::agregarPunto($turno);

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
            ]);
        }

        $disponibilidades = Disponibilidad::with('persona')
            ->whereDate('dis_fecha', $date->toDateString())
            ->where('dis_estado', 'disponible')
            ->get();

        if ($disponibilidades->isEmpty() === true) {
            return response()->json([
                'error' => 'No hay disponibilidad para el día seleccionado. Por favor, elija otra fecha.',
                'aria' => true
            ]);
        }

        $result = [];
        $step = 20;
        if ($request->filled('servicio_id') === true) {
            $serv = Servicio::find($request->servicio_id);
            if ($serv !== null) {
                $step = (int) $serv->serv_duracion;
            }
        }

        foreach ($disponibilidades as $d) {
            $reservados = Turno::where('dis_id', $d->dis_id)
                ->where('tur_fecha', $date->toDateString())
                ->get()
                ->map(function($t){
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
            'dis_id' => $dis->dis_id,
            'per_documento' => $dis->per_documento, // ← Asignar barbero
            'tur_fecha' => $date->toDateString(),
            'tur_hora' => $request->tur_hora,
            'tur_duracion' => $duration ?? null,
            'tur_nombre' => $request->tur_nombre,
            'tur_cedula' => $request->tur_cedula,
            'tur_celular' => $request->tur_celular,
            'tur_correo' => $request->tur_correo,
            'tur_fecha_nacimiento' => $request->tur_fecha_nacimiento ?? null,
            'tur_estado' => 'Pendiente',
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

   

  
}
