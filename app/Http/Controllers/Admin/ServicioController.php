<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::orderBy('serv_nombre')->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serv_nombre' => 'required',
            'serv_precio' => 'required|numeric|min:0',
            'serv_duracion' => 'required|numeric|min:1',
            'serv_descuento' => 'nullable|numeric|min:0|max:100',
        ]);

        $servicio = Servicio::create($request->all());
        if ($servicio->serv_descuento > 0) {
            event(new \App\Events\PromocionCreada('servicio', $servicio));
        }
        return redirect()->route('servicios.index')->with('ok', 'Servicio creado correctamente.');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'serv_nombre' => 'required',
            'serv_precio' => 'required|numeric|min:0',
            'serv_duracion' => 'required|numeric|min:1',
            'serv_descuento' => 'nullable|numeric|min:0|max:100',
        ]);


        $data = $request->all();
        if (empty($data['serv_descuento']) === true) {
            $data['serv_descuento'] = 0;
        }
        $servicio = Servicio::findOrFail($id);
        $servicio->update($data);
        if ($servicio->serv_descuento > 0) {
            event(new \App\Events\PromocionCreada('servicio', $servicio));
        }
        return redirect()->route('servicios.index')->with('ok', 'Servicio actualizado.');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('servicios.index')->with('ok', 'Servicio eliminado.');
    }
}
