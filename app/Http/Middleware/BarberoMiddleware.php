<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BarberoMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('usuario')->user();
        if (!$user || $user->rol !== 'barbero') {
            return redirect()->route('login')->withErrors('Acceso no autorizado.');
        }
        return $next($request);
    }
}
