<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show()
    {
        return view('barbero.cambiar-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!$#%&?@_"])[A-Za-z\d!$#%&?@_\"]{8,}$/',
            ],
        ], [
            'password.required'  => 'La nueva contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex'     => 'La contraseña debe incluir mayúscula, minúscula, número y carácter especial (!$#%&?@_").',
        ]);

        /** @var Usuario $user */
        $user = Usuario::findOrFail(Auth::guard('usuario')->id());

        // Evitar reusar la contraseña que tenían (el documento)
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'La nueva contraseña no puede ser igual a la contraseña temporal.']);
        }

        $user->password              = Hash::make($request->password);
        $user->debe_cambiar_password = false;
        $user->save();

        return redirect()->route('barbero.dashboard')
            ->with('success', '¡Contraseña actualizada correctamente! Bienvenido.');
    }
}
