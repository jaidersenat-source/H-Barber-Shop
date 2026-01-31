<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('pro_nombre')->get();
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pro_nombre' => 'required',
            'pro_precio' => 'required|numeric|min:0',
            'pro_descuento' => 'nullable|numeric|min:0|max:100',
            'pro_stock'  => 'required|numeric|min:0'
        ]);

        $data = $request->all();
        if (empty($data['pro_descuento']) === true) {
            $data['pro_descuento'] = 0;
        }
        // Imagen opcional
        if ($request->hasFile('pro_imagen') === true) {
            $data['pro_imagen'] = $request->file('pro_imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);
        if ($producto->pro_descuento > 0) {
            event(new \App\Events\PromocionCreada('producto', $producto));
        }
        return redirect()->route('productos.index')->with('ok', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pro_nombre' => 'required',
            'pro_precio' => 'required|numeric|min:0',
            'pro_descuento' => 'nullable|numeric|min:0|max:100',
            'pro_stock'  => 'required|numeric|min:0'
        ]);

        $producto = Producto::findOrFail($id);

        $data = $request->all();
        if (empty($data['pro_descuento'])) {
            $data['pro_descuento'] = 0;
        }
        // Imagen opcional
        if ($request->hasFile('pro_imagen') === true) {
            $data['pro_imagen'] = $request->file('pro_imagen')->store('productos', 'public');
        }

        $producto->update($data);
        if ($producto->pro_descuento > 0) {
            event(new \App\Events\PromocionCreada('producto', $producto));
        }
        return redirect()->route('productos.index')->with('ok', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('ok', 'Producto eliminado.');
    }
}
