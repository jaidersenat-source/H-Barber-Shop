<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fidelizacion;
use App\Models\Turno;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class FidelizacionController extends Controller
{
    /**
     * Mostrar formulario de configuración global de fidelización
     */
    public function config()
    {
        $visitas = config('fidelizacion.visitas_requeridas');
        $habilitado = config('fidelizacion.habilitado');
        return view('admin.fidelizacion.config', compact('visitas', 'habilitado'));
    }

    /**
     * Guardar configuración global de fidelización
     */
    public function updateConfig(Request $request)
    {
        $request->validate([
            'visitas_requeridas' => 'required|integer|min:1|max:99',
            'habilitado' => 'required|boolean',
        ]);

        // Guardar en archivo config/fidelizacion.php
        $path = config_path('fidelizacion.php');
        $contenido = "<?php\nreturn [\n    'visitas_requeridas' => {$request->visitas_requeridas},\n    'habilitado' => ".(($request->habilitado === true) ? 'true' : 'false').",\n];\n";
        // Usar Storage para mayor seguridad
        Storage::disk('local')->put(str_replace(base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR, '', $path), $contenido);

        // Limpiar la caché de configuración automáticamente
        try {
            Artisan::call('config:clear');
        } catch (\Exception $e) {
            // Si falla, solo loguea
           
        }

        return redirect()->route('fidelizacion.config')->with('ok', 'Configuración actualizada correctamente.');
    }
    /**
     * Listar fidelización
     */
    public function index()
    {
        $items = \App\Models\Fidelizacion::orderBy('fecha_actualizacion', 'desc')->paginate(20);
        return view('admin.fidelizacion.index', compact('items'));
    }

    /**
     * Mostrar detalles de una fidelización
     */
    public function show($id)
    {
        $item = \App\Models\Fidelizacion::findOrFail($id);
        return view('admin.fidelizacion.show', compact('item'));
    }

    /**
     * Método interno para sumar puntos cuando un turno se completa.
     * Lo llamaremos desde TurnoController@complete
     */
    public static function agregarPunto(\App\Models\Turno $turno)
    {
        // Solo sumar si el turno está realizado
        if ($turno->tur_estado !== 'Realizado') {
            return null;
        }
        // Buscar registro existente para el mismo cliente (por cédula)
        $f = \App\Models\Fidelizacion::where('tur_cedula', $turno->tur_cedula)->first();

        // Si la fidelización está deshabilitada, no sumar puntos
        if (config('fidelizacion.habilitado') === false) {
            return null;
        }

        $visitasRequeridas = config('fidelizacion.visitas_requeridas', 10);
        $fidelizado = false;

        if ($f === null) {
            // Crear uno nuevo
            $f = \App\Models\Fidelizacion::create([
                'tur_id' => $turno->tur_id,
                'tur_cedula' => $turno->tur_cedula,
                'tur_celular' => $turno->tur_celular,
                'tur_nombre' => $turno->tur_nombre,
                'visitas_acumuladas' => 1,
                'cortes_gratis' => 0,
                'fecha_actualizacion' => now()
            ]);
        } else {
            // Sumar visita
            $f->visitas_acumuladas += 1;
            // Cada X visitas → 1 corte gratis
            if ($f->visitas_acumuladas % $visitasRequeridas === 0) {
                $f->cortes_gratis += 1;
                $fidelizado = true;
            }
            $f->fecha_actualizacion = now();
            $f->save();
        }

        // Si el cliente alcanzó la meta, disparar evento
        if ($fidelizado) {
            event(new \App\Events\ClienteFidelizado($turno, $f));
        }
        return $f;
    }
}
