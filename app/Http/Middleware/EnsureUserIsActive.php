<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->estado !== 'activo') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['usuario' => 'Tu cuenta está inactiva. Espera a que un administrador la active.']);
        }

        return $next($request);
    }
}
