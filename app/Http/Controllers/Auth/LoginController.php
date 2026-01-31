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

        // Validar credenciales (mensaje genérico)
        $loginValido = $user && Hash::check($request->password, $user->password);
        if (!$loginValido) {
            return back()->withErrors([
                'login' => 'Las credenciales proporcionadas son incorrectas.'
            ]);
        }

        // Bloquear usuarios inactivos
        if ($user->isActive() === false) {
            return back()->withErrors([
                'login' => 'Las credenciales proporcionadas son incorrectas.'
            ]);
        }

        // Iniciar sesión
        Auth::login($user);

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
        Auth::logout();
        return back()->withErrors(['usuario' => 'Rol no permitido.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

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
        if (Auth::check() === true && Auth::user()->rol === 'admin') {
            $rules['rol'] = 'required|in:admin,barbero';
        }

        $request->validate($rules);

        $rol = 'barbero';
       if (Auth::check() === true && Auth::user()->rol === 'admin') {
            $rol = $request->rol;
        }

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

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente.');
    }
}
