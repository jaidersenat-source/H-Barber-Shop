<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForzarCambioPassword
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('usuario')->user();

        // Si el usuario debe cambiar su contraseña y NO está ya en esa ruta, redirigir
        if ($user && $user->debe_cambiar_password) {
            if (!$request->routeIs('barbero.cambiar-password') && !$request->routeIs('barbero.cambiar-password.update')) {
                return redirect()->route('barbero.cambiar-password')
                    ->with('warning', 'Debes cambiar tu contraseña antes de continuar.');
            }
        }

        return $next($request);
    }
}
