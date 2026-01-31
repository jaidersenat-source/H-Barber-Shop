<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BarberoMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() === false || Auth::user()->rol !== 'barbero') {
            return redirect()->route('login')->withErrors('Acceso no autorizado.');
        }

        return $next($request);
    }
}
