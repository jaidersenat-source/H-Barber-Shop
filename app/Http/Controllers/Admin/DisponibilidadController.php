<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disponibilidad;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DisponibilidadController extends Controller
{
    // 🟦 LISTAR TODA LA DISPONIBILIDAD
    public function index()
    {
        $barberos = \App\Models\Persona::with(['disponibilidades' => function($q) {
            $q->where(function($query) {
                $query->whereNull('dis_fecha')
                      ->orWhere('dis_fecha', '>=', now()->toDateString());
            })
            ->orderBy('dia')->orderBy('dis_hora_inicio');
        }])
        ->whereHas('usuario', function($q) {
            $q->where('rol', 'barbero');
        })
        ->get();
        return view('admin.disponibilidad.index', compact('barberos'));
    }

    // FORMULARIO SEMANAL


    // GUARDAR DISPONIBILIDAD SEMANAL
    public function storeWeekly(Request $request)
    {
        $request->validate([
            'per_documento' => 'required|exists:persona,per_documento',
            'dias' => 'required|array|min:1',
            'dis_hora_inicio' => 'required',
            'dis_hora_fin' => 'required|after:dis_hora_inicio',
            'dis_fecha' => 'nullable|date',
            'apply_to_week' => 'nullable|in:1',
        ]);

        $per = $request->per_documento;
        $horaInicio = $request->dis_hora_inicio;
        $horaFin = $request->dis_hora_fin;
        $dias = $request->dias;
     $disFecha = ($request->filled('dis_fecha') === true) ? Carbon::parse($request->dis_fecha)->toDateString(): null;


        $applyToWeek = $request->has('apply_to_week') && $request->apply_to_week == '1';

        DB::beginTransaction();

        try {
            // Si el usuario quiere aplicar sólo a la semana de la fecha, debemos calcular
            // las fechas concretas de cada día seleccionado dentro de la misma semana.
            $datesForDays = [];
            if ($applyToWeek === true && $disFecha !== null) {
                $base = Carbon::parse($disFecha);
                // Aseguramos que el lunes sea el inicio de semana ISO
                $monday = $base->copy()->startOfWeek(Carbon::MONDAY);
                // mapa número->nombre en español (coincide con enum de la tabla)
                $diasMap = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
                foreach ($dias as $dia) {
                    // buscamos la clave numérica para este nombre
                    $num = array_search($dia, $diasMap, true);
                    if ($num === false) {
                        DB::rollBack();
                        return back()->withErrors(['error' => "Día inválido: $dia"]);
                    }
                    // El lunes es 1, así que sumamos ($num - 1) días al lunes
                    $dateForDay = $monday->copy()->addDays($num - 1)->toDateString();
                    $datesForDays[$dia] = $dateForDay;
                }
            }

            foreach ($dias as $dia) {

                $fechaGuardar = ($applyToWeek === true) ? ($datesForDays[$dia] ?? null) : null;


                // Validar cruce de horarios: si ya existe una disponibilidad con la misma
                // persona y día (o la misma fecha concreta si aplicó a semana puntual)
                $cruceQuery = Disponibilidad::where('per_documento', $per)
                    ->where('dia', $dia);

                if ($fechaGuardar !== null) {

                    $cruceQuery->where('dis_fecha', $fechaGuardar);
                } else {
                    // para disponibilidad semanal recurrente, consideramos dis_fecha NULL
                    $cruceQuery->whereNull('dis_fecha');
                }

                $cruce = $cruceQuery->where(function ($q) use ($horaInicio,$horaFin) {
                        $q->whereBetween('dis_hora_inicio', [$horaInicio, $horaFin])
                          ->orWhereBetween('dis_hora_fin', [$horaInicio, $horaFin])
                          ->orWhere(function($q2) use ($horaInicio,$horaFin) {
                              $q2->where('dis_hora_inicio', '<', $horaInicio)
                                 ->where('dis_hora_fin', '>', $horaFin);
                          });
                    })->first();

                if ($cruce === true) {
                    DB::rollBack();
                    return back()->withErrors(['error' => "Cruce detectado el día $dia."]);
                }

                // Crear horario
                Disponibilidad::create([
                    'per_documento' => $per,
                    'dia' => $dia,
                    'dis_fecha' => $fechaGuardar,
                    'dis_hora_inicio' => $horaInicio,
                    'dis_hora_fin' => $horaFin,
                    'dis_estado' => 'disponible',
                ]);
            }

            DB::commit();
            return redirect()->route('disponibilidad.index')->with('ok','Disponibilidad creada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error: '.$e->getMessage()]);
        }
    }

    /**
     * Obtener disponibilidad para una fecha concreta.
     * Retorna registros donde dis_fecha == fecha OR (dis_fecha IS NULL AND dia == weekday)
     */
    public function byDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = Carbon::parse($request->date)->toDateString();
        $iso = Carbon::parse($date)->dayOfWeekIso; // 1 = Monday .. 7 = Sunday
        $diasMap = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $weekdayName = $diasMap[$iso];

        $horarios = Disponibilidad::with('persona')
            ->where(function($q) use ($date, $weekdayName) {
                $q->where('dis_fecha', $date)
                  ->orWhere(function($q2) use ($weekdayName) {
                      $q2->whereNull('dis_fecha')
                         ->where('dia', $weekdayName);
                  });
            })
            ->orderBy('per_documento')
            ->orderBy('dis_hora_inicio')
            ->get();

        // Si la petición es AJAX o espera JSON, devolvemos JSON
        if ($request->wantsJson() === true || $request->ajax() === true) {

            return response()->json($horarios);
        }

        // De lo contrario, devolvemos una vista simple (puedes ajustarla según UI)
        return view('admin.disponibilidad.by_date', compact('horarios','date','weekdayName'));
    }


    // FORM PARA CREAR POR FECHA (OPCIONAL, LO DEJO POR SI LO USAS)
    public function create()
    {
        $personas = Persona::whereHas('usuario', function($q) {
            $q->where('rol', 'barbero');
        })->get();
        $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
        return view('admin.disponibilidad.create', compact('personas', 'dias'));
    }

    // GUARDAR DISPONIBILIDAD POR FECHA (OPCIONAL)
    public function store(Request $request)
    {
        return redirect()->route('disponibilidad.index')
            ->with('ok','Este método ya no se usa porque ahora todo es semanal');
    }


    // EDITAR HORARIO SEMANAL
    public function edit($id)
    {
        $horario = Disponibilidad::findOrFail($id);
        $personas = Persona::all();
        $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

        return view('admin.disponibilidad.edit', compact('horario', 'personas', 'dias'));
    }


    // ACTUALIZAR HORARIO
    public function update(Request $request, $id)
    {
        $request->validate([
            'per_documento' => 'required|exists:persona,per_documento',
            'dia' => 'required',
            'dis_hora_inicio' => 'required',
            'dis_hora_fin' => 'required|after:dis_hora_inicio',
        ]);

        $horario = Disponibilidad::findOrFail($id);
        $horario->update($request->all());

        return redirect()->route('disponibilidad.index')->with('ok','Disponibilidad actualizada');
    }


    // ELIMINAR
    public function destroy($id)
    {
        $horario = Disponibilidad::findOrFail($id);
        $horario->delete();

        return redirect()->route('disponibilidad.index')->with('ok','Horario eliminado');
    }
}
