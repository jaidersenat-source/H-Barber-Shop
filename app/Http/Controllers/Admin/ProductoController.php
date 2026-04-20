<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->input('tipo', 'todos');
        
        $query = Producto::orderBy('pro_nombre');
        
        if ($tipo === 'producto') {
            $query->where('pro_categoria', '!=', 'kit');
        } elseif ($tipo === 'kit') {
            $query->where('pro_categoria', 'kit');
        }
        
        $productos = $query->get();
        
        return view('admin.productos.index', compact('productos', 'tipo'));
    }

    public function create()
    {
        $productosDisponibles = Producto::disponiblesParaKit();
        return view('admin.productos.create', compact('productosDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pro_nombre' => 'required',
            'pro_precio' => 'required|numeric|min:0',
            'pro_descuento' => 'nullable|numeric|min:0|max:100',
            'pro_stock'  => 'required|numeric|min:0',
            'pro_categoria' => 'required|string|max:255',
            'pro_productos_kit' => 'nullable|array',
            'pro_productos_kit.*' => 'exists:productos,pro_id',
        ]);

        $data = $request->only([
            'pro_nombre', 'pro_descripcion', 'pro_precio', 'pro_descuento',
            'pro_stock', 'pro_categoria', 'pro_productos_kit'
        ]);
        
        if (empty($data['pro_descuento'])) {
            $data['pro_descuento'] = 0;
        }
        
        // Procesar productos del kit
        if ($data['pro_categoria'] === 'kit' && !empty($data['pro_productos_kit'])) {
            $data['pro_productos_kit'] = array_map('intval', $data['pro_productos_kit']);
        } else {
            $data['pro_productos_kit'] = null;
        }
        
        // Imagen opcional
        if ($request->hasFile('pro_imagen')) {
            $data['pro_imagen'] = $request->file('pro_imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);
        
        if ($producto->pro_descuento > 0) {
            event(new \App\Events\PromocionCreada('producto', $producto));
        }
        
        Cache::forget('public.productos_activos');
        $mensaje = $producto->esKit() ? 'Kit creado correctamente.' : 'Producto creado correctamente.';
        return redirect()->route('productos.index')->with('ok', $mensaje);
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $productosDisponibles = Producto::disponiblesParaKit()
            ->reject(fn($p) => $p->pro_id === $producto->pro_id);
        
        return view('admin.productos.edit', compact('producto', 'productosDisponibles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pro_nombre' => 'required',
            'pro_precio' => 'required|numeric|min:0',
            'pro_descuento' => 'nullable|numeric|min:0|max:100',
            'pro_stock'  => 'required|numeric|min:0',
            'pro_categoria' => 'required|string|max:255',
            'pro_productos_kit' => 'nullable|array',
            'pro_productos_kit.*' => 'exists:productos,pro_id',
        ]);

        $producto = Producto::findOrFail($id);

        $data = $request->only([
            'pro_nombre', 'pro_descripcion', 'pro_precio', 'pro_descuento',
            'pro_stock', 'pro_categoria', 'pro_productos_kit'
        ]);
        
        if (empty($data['pro_descuento'])) {
            $data['pro_descuento'] = 0;
        }
        
        // Procesar productos del kit
        if ($data['pro_categoria'] === 'kit' && !empty($data['pro_productos_kit'])) {
            $data['pro_productos_kit'] = array_map('intval', $data['pro_productos_kit']);
        } else {
            $data['pro_productos_kit'] = null;
        }
        
        // Imagen opcional
        if ($request->hasFile('pro_imagen')) {
            $data['pro_imagen'] = $request->file('pro_imagen')->store('productos', 'public');
        }

        $producto->update($data);
        
        if ($producto->pro_descuento > 0) {
            event(new \App\Events\PromocionCreada('producto', $producto));
        }
        
        Cache::forget('public.productos_activos');
        $mensaje = $producto->esKit() ? 'Kit actualizado.' : 'Producto actualizado.';
        return redirect()->route('productos.index')->with('ok', $mensaje);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $esKit = $producto->esKit();
        $producto->delete();

        Cache::forget('public.productos_activos');
        $mensaje = $esKit ? 'Kit eliminado.' : 'Producto eliminado.';
        return redirect()->route('productos.index')->with('ok', $mensaje);
    }
}
