<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);


        // Buscar usuario por su nombre de usuario
        $user = Usuario::where('usuario', $request->usuario)->first();

        // Si el usuario no existe
        if (!$user) {
            return back()->withErrors([
                'usuario' => 'El usuario no existe.'
            ]);
        }

        // Validar contraseña
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.'
            ]);
        }

        // Bloquear usuarios inactivos
        if ($user->isActive() === false) {
            return back()->withErrors([
                'usuario' => 'Esta cuenta se encuentra inactiva.'
            ]);
        }

        // Iniciar sesión usando el guard 'usuario' que está configurado para el modelo Usuario
        Auth::guard('usuario')->login($user);

        // Regenerar sesión
        $request->session()->regenerate();

        // Redirigir según el rol
        if ($user->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->rol === 'barbero') {
            return redirect()->route('barbero.dashboard');
        }

        // En caso de rol desconocido
        Auth::guard('usuario')->logout();
        return back()->withErrors(['usuario' => 'Rol no permitido.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('usuario')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); 
    }

    // === REGISTRO DE USUARIOS (SOLO PARA ADMINS) ===
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'usuario' => 'required|unique:usuarios,usuario',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!$#%&?@_"])[A-Za-z\d!$#%&?@_\"]{8,}$/',
            ],
            'per_documento' => 'required|exists:persona,per_documento',
        ];

        // Si un admin está creando el usuario desde el panel, puede elegir rol
        if (Auth::guard('usuario')->check() === true && Auth::guard('usuario')->user()->rol === 'admin') {
            $rules['rol'] = 'required|in:admin,barbero';
        }

        $messages = [
            'per_documento.required' => 'El documento es requerido.',
            'per_documento.exists' => 'El documento ingresado no existe en el sistema.',
            'usuario.required' => 'El nombre de usuario es requerido.',
            'usuario.unique' => 'Este nombre de usuario ya está registrado.',
            'password.required' => 'La contraseña es requerida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña no cumple con los requisitos de seguridad.',
            'rol.required' => 'Debe seleccionar un rol.',
            'rol.in' => 'El rol seleccionado no es válido.',
        ];

        $request->validate($rules, $messages);

        $rol = 'barbero';
       if (Auth::guard('usuario')->check() === true && Auth::guard('usuario')->user()->rol === 'admin') {
            $rol = $request->rol;
        }

        try {
            $new = Usuario::create([
                'usuario' => $request->usuario,
                'password' => Hash::make($request->password),
                'per_documento' => $request->per_documento,
                'rol' => $rol,
                'ultimo_acceso' => now(),
                'estado' => 'inactivo',
            ]);

            // Si se registra un barbero, notificar a los administradores
            if ($new->rol === 'barbero') {
                $admins = Usuario::where('rol', 'admin')->get();
                if ($admins->isNotEmpty() === true) {
                    \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\BarberoRegistered($new));
                }
            }

            return redirect()->route('login')->with('success', 'Usuario registrado correctamente. Espera que el admin active tu cuenta.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { // Duplicado
                return redirect()->back()->withInput()->withErrors(['per_documento' => 'Ya existe un usuario con esa cédula.']);
            }
            throw $e;
        }
    }
}