<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $servicios = Servicio::orderBy('serv_categoria')->orderBy('serv_nombre')->get();
        $servicioNombres = $servicios->pluck('serv_nombre', 'serv_id');

        return view('admin.servicios.index', compact('servicios', 'servicioNombres'));
    }

    public function create()
    {
        $serviciosDisponibles = Servicio::where('serv_categoria', '!=', 'combos')
            ->where('serv_estado', 'activo')
            ->orderBy('serv_nombre')
            ->get();

        return view('admin.servicios.create', compact('serviciosDisponibles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'serv_nombre' => 'required|string|max:255',
            'serv_categoria' => 'required|string',
            'serv_precio' => 'required|numeric|min:0',
            'serv_duracion' => 'required|numeric|min:1',
            'serv_descuento' => 'nullable|numeric|min:0|max:100',
        ];

        if ($request->input('serv_categoria') === 'combos') {
            $rules['serv_servicios_incluidos'] = 'required|array|min:1';
            $rules['serv_servicios_incluidos.*'] = 'exists:servicios,serv_id';
        }

        $request->validate($rules);

        $data = $request->only([
            'serv_nombre', 'serv_descripcion', 'serv_categoria',
            'serv_precio', 'serv_duracion', 'serv_estado', 'serv_descuento',
        ]);

        if ($request->input('serv_categoria') === 'combos') {
            $data['serv_servicios_incluidos'] = array_map('intval', $request->input('serv_servicios_incluidos', []));
        } else {
            $data['serv_servicios_incluidos'] = null;
        }

        $servicio = Servicio::create($data);

        if ($servicio->serv_descuento > 0) {
            event(new \App\Events\PromocionCreada('servicio', $servicio));
        }

        Cache::forget('public.servicios_activos');
        $tipo = $servicio->esCombo() ? 'Combo' : 'Servicio';
        return redirect()->route('servicios.index')->with('ok', "$tipo creado correctamente.");
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);

        $serviciosDisponibles = Servicio::where('serv_categoria', '!=', 'combos')
            ->where('serv_estado', 'activo')
            ->where('serv_id', '!=', $id)
            ->orderBy('serv_nombre')
            ->get();

        return view('admin.servicios.edit', compact('servicio', 'serviciosDisponibles'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'serv_nombre' => 'required|string|max:255',
            'serv_categoria' => 'required|string',
            'serv_precio' => 'required|numeric|min:0',
            'serv_duracion' => 'required|numeric|min:1',
            'serv_descuento' => 'nullable|numeric|min:0|max:100',
        ];

        if ($request->input('serv_categoria') === 'combos') {
            $rules['serv_servicios_incluidos'] = 'required|array|min:1';
            $rules['serv_servicios_incluidos.*'] = 'exists:servicios,serv_id';
        }

        $request->validate($rules);

        $data = $request->only([
            'serv_nombre', 'serv_descripcion', 'serv_categoria',
            'serv_precio', 'serv_duracion', 'serv_estado', 'serv_descuento',
        ]);

        if (empty($data['serv_descuento'])) {
            $data['serv_descuento'] = 0;
        }

        if ($request->input('serv_categoria') === 'combos') {
            $data['serv_servicios_incluidos'] = array_map('intval', $request->input('serv_servicios_incluidos', []));
        } else {
            $data['serv_servicios_incluidos'] = null;
        }

        $servicio = Servicio::findOrFail($id);
        $servicio->update($data);

        if ($servicio->serv_descuento > 0) {
            event(new \App\Events\PromocionCreada('servicio', $servicio));
        }

        Cache::forget('public.servicios_activos');
        $tipo = $servicio->esCombo() ? 'Combo' : 'Servicio';
        return redirect()->route('servicios.index')->with('ok', "$tipo actualizado correctamente.");
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);

        // Verificar que un servicio normal no esté incluido en combos activos
        if (!$servicio->esCombo()) {
            $combosQueLoIncluyen = Servicio::where('serv_categoria', 'combos')
                ->whereNotNull('serv_servicios_incluidos')
                ->get()
                ->filter(fn ($combo) => in_array($id, $combo->serv_servicios_incluidos ?? []));

            if ($combosQueLoIncluyen->isNotEmpty()) {
                $nombres = $combosQueLoIncluyen->pluck('serv_nombre')->implode(', ');
                return redirect()->route('servicios.index')
                    ->with('error', "No se puede eliminar: este servicio está incluido en los combos: $nombres.");
            }
        }

        Cache::forget('public.servicios_activos');
        $tipo = $servicio->esCombo() ? 'Combo' : 'Servicio';
        $servicio->delete();

        return redirect()->route('servicios.index')->with('ok', "$tipo eliminado correctamente.");
    }
}
