<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;

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
            'current_password' => 'nullable|string',
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
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
