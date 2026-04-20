<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Turno;
use App\Models\Servicio;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $persona = $usuario->persona;
        // Turnos de la semana actual SOLO del barbero autenticado
        $turnos = Turno::where('per_documento', $persona->per_documento)
            ->whereBetween('tur_fecha', [now()->startOfWeek(), now()->endOfWeek()])
            ->whereDoesntHave('factura')
            ->orderBy('tur_fecha')
            ->orderBy('tur_hora')
            ->get();
        return view('barbero.turnos.turnos', compact('turnos'));
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Realizado,Cancelado,Reprogramado'
        ]);
        $turno = Turno::findOrFail($id);

        // Verificar que el turno pertenece al barbero autenticado
        $persona = Auth::user()->persona;
        if ($turno->per_documento !== $persona->per_documento) {
            abort(403, 'No tienes permiso para modificar este turno.');
        }

        $turno->tur_estado = $request->estado;
        $turno->save();
        return back()->with('success', 'Estado del turno actualizado.');
    }

    public function create()
    {
        $servicios = Servicio::where('serv_estado', 'Activo')->get();
        return view('barbero.turnos.create', compact('servicios'));
    }

    public function store(Request $request)
    {
        $usuario = Auth::user();
        $persona = $usuario->persona;
        $validated = $request->validate([
            'dis_id' => 'required|exists:disponibilidad,dis_id',
            'tur_fecha' => 'required|date',
            'tur_hora' => 'required',
            'tur_nombre' => 'required',
            'tur_cedula' => 'nullable|string|max:30',
            'tur_celular' => 'required|digits:10',
            'tur_fecha_nacimiento' => 'nullable|date|before_or_equal:today',
        ], [
            'tur_celular.digits' => 'El número de celular debe tener exactamente 10 dígitos.',
            'tur_fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser mayor a hoy.'
        ]);

        $turno = Turno::create([
            'dis_id' => $request->dis_id,
            'per_documento' => $persona->per_documento, // barbero
            'tur_fecha' => $request->tur_fecha,
            'tur_hora' => $request->tur_hora,
            'tur_nombre' => $request->tur_nombre,
            'tur_cedula' => $request->tur_cedula,
            'tur_celular' => $request->tur_celular,
            'tur_fecha_nacimiento' => $request->tur_fecha_nacimiento,
            'tur_estado' => 'Pendiente',
        ]);

        return response()->json(['success' => true, 'message' => 'Turno registrado correctamente']);
    }

    public function available(Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $usuario = Auth::user();
        $persona = $usuario->persona;
        $date = \Carbon\Carbon::parse($request->date);

        if ($date->lt(\Carbon\Carbon::today()) === true) {
            return response()->json([
                'error' => 'No se pueden mostrar horarios de fechas pasadas.',
                'aria' => true
            ]);
        }

        $disponibilidades = \App\Models\Disponibilidad::where('per_documento', $persona->per_documento)
            ->where(function($q) use ($date) {
                $q->whereNull('dis_fecha')->orWhere('dis_fecha', $date->toDateString());
            })
            ->where('dis_estado', 'disponible')
            ->get();

        if ($disponibilidades->isEmpty()) {
            return response()->json([
                'error' => 'No hay disponibilidad para el día seleccionado. Por favor, elija otra fecha.',
                'aria' => true
            ]);
        }

        $result = [];
        $step = 20;
        if ($request->filled('servicio_id')) {
            $serv = \App\Models\Servicio::find($request->servicio_id);
            if ($serv !== null) {
                $step = (int) $serv->serv_duracion;
            }
        }

        // Precargar todos los turnos de las disponibilidades en una sola query
        $disIds = $disponibilidades->pluck('dis_id')->toArray();
        $todosReservados = \App\Models\Turno::where('tur_fecha', $date->toDateString())
            ->whereIn('dis_id', $disIds)
            ->get()
            ->groupBy('dis_id');

        foreach ($disponibilidades as $d) {
            $reservados = ($todosReservados->get($d->dis_id) ?? collect())
                ->map(function($t){
                    return [
                        'hora' => $t->tur_hora,
                        'duracion' => (int) $t->tur_duracion,
                        'estado' => $t->tur_estado
                    ];
                });

            $result[] = [
                'dis_id' => $d->dis_id,
                'barbero' => $persona->per_nombre . ' ' . $persona->per_apellido,
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
}
