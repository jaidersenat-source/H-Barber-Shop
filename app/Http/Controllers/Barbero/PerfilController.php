<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $persona = Persona::where('per_documento', $user->per_documento)->first();
        return view('barbero.perfil.configuracion', compact('persona'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $persona = Persona::where('per_documento', $user->per_documento)->first();

        $request->validate([
            'username' => 'required|string|max:255',
            'documento' => 'required|string|max:20',
            'email' => 'required|email',
            'current_password' => 'required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->usuario = $request->username;
        $user->per_documento = $request->documento;
        $user->save();

        if ($persona) {
            $persona->per_correo = $request->email;
            $persona->save();
        }

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.'])->withInput();
            }
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Guardar foto de perfil (subida) para el barbero autenticado.
     */
    public function guardarFoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ]);

        // Eliminar archivo anterior si existe
        if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        // Guardar la nueva imagen en storage/app/public/fotos_perfil
        $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');

        $user->foto_perfil = $path;
        $user->save();

        return back()->with('success', 'Foto de perfil actualizada correctamente.');
    }
}
