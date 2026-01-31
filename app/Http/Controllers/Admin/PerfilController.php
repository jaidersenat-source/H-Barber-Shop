<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;
use App\Models\Usuario;



class PerfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        // Puedes pasar la relación persona si la necesitas en la vista:
        $persona = $user->persona ?? null;
        return view('admin.perfil.configuracion', compact('user', 'persona'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,usuario,' . $user->usuario_id . ',usuario_id',
            'documento' => 'required|string|max:30|unique:usuarios,per_documento,' . $user->usuario_id . ',usuario_id',
            'email' => 'required|email',
        ]);
        
        $user->usuario = $request->username;
        $user->per_documento = $request->documento;
        $user->save();

        // Actualizar correo en la tabla persona (si existe relación)
        if ($user->persona !== null) {
            $user->persona->per_correo = $request->email;
            $user->persona->save();
        }

        // Cambiar contraseña si se solicita
        if ($request->filled('current_password') === true && $request->filled('password') === true) {
            if (Hash::check($request->current_password, $user->password) === false) {
                return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }
            $request->validate([
                'password' => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/', // Al menos una mayúscula y un número
                ],
            ], [
                'password.regex' => 'La contraseña debe tener al menos una mayúscula y un número.'
            ]);
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
