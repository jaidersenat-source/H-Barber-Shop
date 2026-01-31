<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Mostrar formulario para solicitar enlace
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Enviar enlace de restablecimiento
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);


        // Buscar usuario por el correo de persona
        $usuario = \App\Models\Usuario::whereHas('persona', function($q) use ($request) {
            $q->where('per_correo', $request->email);
        })->first();

        if (!$usuario) {
            return back()->withErrors(['email' => 'No se encontró ningún usuario con ese correo.']);
        }

        // Generar token manualmente y enviar el correo
        $token = Password::createToken($usuario);

        // Enviar notificación de restablecimiento
        $usuario->sendPasswordResetNotification($token);

        return back()->with(['status' => 'Se ha enviado el enlace de restablecimiento a su correo.']);
    }
}
