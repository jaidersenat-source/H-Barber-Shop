<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    // LISTAR SEDES
    public function index()
    {
        $sedes = Sede::all();
        return view('admin.sedes.index', compact('sedes'));
    }

    // FORM DE CREAR
    public function create()
    {
        return view('admin.sedes.create');
    }

    // GUARDAR NUEVA SEDE
    public function store(Request $request)
    {
        $request->validate([
            'sede_nombre' => 'required',
            'sede_direccion' => 'required',
            'sede_logo' => 'nullable',
            'sede_slogan' => 'nullable',
            'sede_descripcion' => 'nullable',
        ]);

        Sede::create($request->all());

        return redirect()->route('sedes.index')->with('ok', 'Sede registrada correctamente');
    }

    // FORM PARA EDITAR
    public function edit($id)
    {
        $sede = Sede::findOrFail($id);
        return view('admin.sedes.edit', compact('sede'));
    }

    // ACTUALIZAR SEDE
    public function update(Request $request, $id)
    {
        $request->validate([
            'sede_nombre' => 'required',
            'sede_direccion' => 'required',
        ]);

        try {
            $sede = Sede::findOrFail($id);
            $sede->update($request->all());
            return redirect()->route('sedes.index')->with('ok', 'Sede actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('sedes.index')->with('error', 'No se pudo actualizar la sede. Intente nuevamente o contacte soporte.');
        }
    }

    // ELIMINAR SEDE
    public function destroy($id)
    {
        try {
            $sede = Sede::findOrFail($id);
            $sede->delete();
            return redirect()->route('sedes.index')->with('ok', 'Sede eliminada');
        } catch (\Exception $e) {
            return redirect()->route('sedes.index')->with('error', 'No se pudo eliminar la sede. Intente nuevamente o contacte soporte.');
        }
    }
}
