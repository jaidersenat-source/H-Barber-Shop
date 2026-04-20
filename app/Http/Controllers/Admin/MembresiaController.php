<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membresia;
use App\Models\ClienteMembresia;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class MembresiaController extends Controller
{
    public function index(Request $request)
    {
        $membresias = Membresia::orderBy('orden')->orderBy('nombre')->get();

        return view('admin.membresias.index', compact('membresias'));
    }

    public function create()
    {
        $servicios = Servicio::where('serv_estado', 'activo')->orderBy('serv_nombre')->get();
        return view('admin.membresias.create', compact('servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'              => 'required|string|max:150',
            'descripcion'         => 'nullable|string',
            'precio'              => 'required|numeric|min:0',
            'duracion_meses'      => 'required|in:1,3,6,12',
            'ben_tipo'            => 'required|in:gratis,porcentaje',
            'ben_usos_limite'     => 'nullable|integer|min:0',
            'ben_descuento_pct'   => 'nullable|numeric|min:1|max:100',
            'servicios_aplicables'=> 'nullable|array',
            'activo'              => 'nullable|boolean',
            'orden'               => 'nullable|integer|min:0',
            'imagen'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'precio', 'duracion_meses']);
        $data['orden']  = (int) $request->input('orden', 0);
        $data['activo'] = $request->boolean('activo', true);

        // Construir el JSON estructurado que espera MembresiaService
        $data['beneficios'] = [
            'tipo'                  => $request->ben_tipo,
            'usos_limite'           => (int) ($request->ben_usos_limite ?? 0),
            'descuento_pct'         => (float) ($request->ben_descuento_pct ?? 0),
            'servicios_aplicables'  => array_map('intval', $request->input('servicios_aplicables', [])),
        ];

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('membresias', 'public');
        }

        Membresia::create($data);

        Cache::forget('public.membresias_activas');
        return redirect()->route('membresias.index')->with('ok', 'Membresía creada correctamente.');
    }

    public function edit($id)
    {
        $membresia = Membresia::findOrFail($id);
        $servicios = Servicio::where('serv_estado', 'activo')->orderBy('serv_nombre')->get();
        return view('admin.membresias.edit', compact('membresia', 'servicios'));
    }

    public function update(Request $request, $id)
    {
        $membresia = Membresia::findOrFail($id);

        $request->validate([
            'nombre'              => 'required|string|max:150',
            'descripcion'         => 'nullable|string',
            'precio'              => 'required|numeric|min:0',
            'duracion_meses'      => 'required|in:1,3,6,12',
            'ben_tipo'            => 'required|in:gratis,porcentaje',
            'ben_usos_limite'     => 'nullable|integer|min:0',
            'ben_descuento_pct'   => 'nullable|numeric|min:1|max:100',
            'servicios_aplicables'=> 'nullable|array',
            'activo'              => 'nullable|boolean',
            'orden'               => 'nullable|integer|min:0',
            'imagen'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'precio', 'duracion_meses']);
        $data['orden']  = (int) $request->input('orden', 0);
        $data['activo'] = $request->boolean('activo', false);

        // Construir el JSON estructurado que espera MembresiaService
        $data['beneficios'] = [
            'tipo'                  => $request->ben_tipo,
            'usos_limite'           => (int) ($request->ben_usos_limite ?? 0),
            'descuento_pct'         => (float) ($request->ben_descuento_pct ?? 0),
            'servicios_aplicables'  => array_map('intval', $request->input('servicios_aplicables', [])),
        ];

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($membresia->imagen) {
                Storage::disk('public')->delete($membresia->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('membresias', 'public');
        }

        $membresia->update($data);

        Cache::forget('public.membresias_activas');
        return redirect()->route('membresias.index')->with('ok', 'Membresía actualizada correctamente.');
    }

    public function destroy($id)
    {
        $membresia = Membresia::findOrFail($id);

        // Verificar que no tenga clientes activos
        $clientesActivos = $membresia->clientesActivos()->count();
        if ($clientesActivos > 0) {
            return redirect()->route('membresias.index')
                ->with('error', "No se puede eliminar: esta membresía tiene $clientesActivos cliente(s) con suscripción activa.");
        }

        if ($membresia->imagen) {
            Storage::disk('public')->delete($membresia->imagen);
        }

        $membresia->delete();

        Cache::forget('public.membresias_activas');
        return redirect()->route('membresias.index')->with('ok', 'Membresía eliminada correctamente.');
    }

    public function toggleActivo($id)
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->update(['activo' => !$membresia->activo]);

        Cache::forget('public.membresias_activas');
        $estado = $membresia->activo ? 'activada' : 'desactivada';
        return redirect()->route('membresias.index')->with('ok', "Membresía $estado correctamente.");
    }

    // --- Gestión de clientes con membresías ---

    public function clientes(Request $request)
    {
        $clientes = ClienteMembresia::with('membresia')
            ->when($request->filled('estado'), fn($q) => $q->where('estado', $request->estado))
            ->when($request->filled('membresia_id'), fn($q) => $q->where('membresia_id', $request->membresia_id))
            ->orderByDesc('created_at')
            ->paginate(20);

        $membresias = Membresia::orderBy('nombre')->get();

        return view('admin.membresias.clientes', compact('clientes', 'membresias'));
    }

    public function asignarCliente(Request $request)
    {
        $request->validate([
            'cliente_cedula' => 'required|string|max:20',
            'membresia_id'   => 'required|exists:membresias,id',
            'fecha_inicio'   => 'required|date',
        ]);

        $membresia    = Membresia::findOrFail($request->membresia_id);
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin    = date('Y-m-d', strtotime("+{$membresia->duracion_meses} months", strtotime($fecha_inicio)));

        ClienteMembresia::create([
            'cliente_cedula' => $request->cliente_cedula,
            'membresia_id'   => $request->membresia_id,
            'fecha_inicio'   => $fecha_inicio,
            'fecha_fin'      => $fecha_fin,
            'estado'         => 'activa',
        ]);

        return redirect()->route('membresias.clientes')->with('ok', 'Membresía asignada al cliente correctamente.');
    }

    public function cancelarCliente($id)
    {
        $cm = ClienteMembresia::findOrFail($id);
        $cm->update(['estado' => 'cancelada']);

        return redirect()->route('membresias.clientes')->with('ok', 'Membresía cancelada para el cliente.');
    }
}