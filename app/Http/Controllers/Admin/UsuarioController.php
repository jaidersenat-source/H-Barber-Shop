<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        // Listar barberos
        $usuarios = Usuario::where('rol', 'barbero')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function activate(Request $request, $id)
    {
        try {
            $user = Usuario::findOrFail($id);
            $user->estado = 'activo';
            $user->save();
            return redirect()->route('admin.usuarios.index')->with('success', 'Usuario activado correctamente.');
        } catch (\Exception $e) {
            // Mensaje accesible para error
            return redirect()->route('admin.usuarios')->with('error', 'No se pudo activar el usuario. Intente nuevamente o contacte soporte.');
        }
    }
}
