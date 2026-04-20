<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaGasto;
use Illuminate\Http\Request;

class CategoriaGastoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda   = $request->input('busqueda');
        $categorias = CategoriaGasto::withCount('gastos')
            ->when($busqueda, fn($q) => $q->where('nombre', 'like', "%{$busqueda}%"))
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('admin.gastos.categorias.index', compact('categorias', 'busqueda'));
    }

    public function create()
    {
        return view('admin.gastos.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:categorias_gastos,nombre',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',
        ]);

        CategoriaGasto::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo'      => true,
        ]);

        return redirect()->route('categorias-gastos.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(CategoriaGasto $categoriasGasto)
    {
        return view('admin.gastos.categorias.edit', ['categoria' => $categoriasGasto]);
    }

    public function update(Request $request, CategoriaGasto $categoriasGasto)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100|unique:categorias_gastos,nombre,' . $categoriasGasto->id,
            'descripcion' => 'nullable|string|max:500',
            'activo'      => 'boolean',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique'   => 'Ya existe una categoría con ese nombre.',
        ]);

        $categoriasGasto->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo'      => $request->boolean('activo'),
        ]);

        return redirect()->route('categorias-gastos.index')
            ->with('success', 'Categoría actualizada.');
    }

    public function destroy(CategoriaGasto $categoriasGasto)
    {
        if ($categoriasGasto->gastos()->exists()) {
            return redirect()->route('categorias-gastos.index')
                ->with('error', 'No puedes eliminar una categoría con gastos asociados.');
        }

        $categoriasGasto->delete();

        return redirect()->route('categorias-gastos.index')
            ->with('success', 'Categoría eliminada.');
    }
}