<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fidelizacion;
use App\Models\Turno;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        'habilitado' => 'required|in:0,1',
    ]);

    // Convertir a boolean
    $habilitadoNuevo = $request->habilitado == 1;
    $habilitadoActual = config('fidelizacion.habilitado', false);
    
    // Si se está activando por primera vez (o reactivando), guardar fecha
    $fechaInicio = config('fidelizacion.fecha_inicio');
    if ($habilitadoNuevo && !$habilitadoActual) {
        // Se está activando ahora
        $fechaInicio = now()->toDateString(); // Guarda fecha de hoy
    }
    
    // Guardar usando var_export para evitar inyección de código
    $configArray = [
        'visitas_requeridas' => (int) $request->visitas_requeridas,
        'habilitado' => $habilitadoNuevo,
        'fecha_inicio' => $fechaInicio,
    ];

    $path = config_path('fidelizacion.php');
    $contenido = "<?php\nreturn " . var_export($configArray, true) . ";\n";

    file_put_contents($path, $contenido);

    // Limpiar caché
    try {
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    } catch (\Exception $e) {
        Log::error('Error limpiando config: ' . $e->getMessage());
    }

    return redirect()->route('fidelizacion.config')
        ->with('ok', 'Configuración actualizada correctamente.');
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
    // Solo procesar si el turno está realizado
    if ($turno->tur_estado !== 'Realizado') {
        return null;
    }

    // Verificar si tiene cédula
    if (!$turno->tur_cedula) {
        return null;
    }

    // Si la fidelización está deshabilitada, no continuar
    if (config('fidelizacion.habilitado') === false) {
        return null;
    }

    // Obtener fecha de inicio del programa
    $fechaInicio = config('fidelizacion.fecha_inicio');
    
    // Contar SOLO las facturas desde que se activó la fidelización
    $query = \App\Models\Factura::join('turno', 'turno.tur_id', '=', 'factura.tur_id')
        ->where('turno.tur_cedula', $turno->tur_cedula)
        ->where('turno.tur_estado', 'Realizado');
    
    // Si hay fecha de inicio, filtrar desde esa fecha
    if ($fechaInicio) {
        $query->where('factura.fac_fecha', '>=', $fechaInicio);
    }
    
    $totalFacturas = $query->count();

    $visitasRequeridas = config('fidelizacion.visitas_requeridas', 10);
    $cortesGratis = floor($totalFacturas / $visitasRequeridas);

    // Buscar o crear registro de fidelización
    $f = \App\Models\Fidelizacion::firstOrCreate(
        ['tur_cedula' => $turno->tur_cedula],
        [
            'tur_id' => $turno->tur_id,
            'tur_celular' => $turno->tur_celular,
            'tur_nombre' => $turno->tur_nombre,
            'visitas_acumuladas' => 0,
            'cortes_gratis' => 0,
            'fecha_actualizacion' => now()
        ]
    );

    // Verificar si alcanzó un nuevo corte gratis
    $fidelizado = $cortesGratis > $f->cortes_gratis;

    // Actualizar con los valores desde la fecha de activación
    $f->update([
        'visitas_acumuladas' => $totalFacturas,
        'cortes_gratis' => $cortesGratis,
        'fecha_actualizacion' => now(),
    ]);

    // Disparar evento si alcanzó una nueva meta
    if ($fidelizado) {
        event(new \App\Events\ClienteFidelizado($turno, $f));
    }

    return $f;
}
}
