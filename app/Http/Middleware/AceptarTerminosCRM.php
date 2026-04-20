<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware: AceptarTerminosCRM
 *
 * Obliga a los barberos/colaboradores a aceptar los Términos de Uso Interno
 * del CRM (Sección V del documento legal v2.0) en su primer acceso al panel.
 *
 * La aceptación queda registrada con fecha, hora, IP y versión del documento,
 * conforme a la Ley 527 de 1999 (comercio electrónico y firmas digitales) y
 * la Ley 1581 de 2012 (protección de datos).
 */
class AceptarTerminosCRM
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('usuario')->user();

        if (!$user) {
            return $next($request);
        }

        // Solo aplicar a barberos (no admin)
        if ($user->rol !== 'barbero') {
            return $next($request);
        }

        // Si ya aceptó los términos, continuar
        if (!empty($user->crm_terms_accepted_at)) {
            return $next($request);
        }

        // Excluir las rutas de aceptación de términos y logout para evitar bucle
        if ($request->routeIs('barbero.crm.terminos') || $request->routeIs('barbero.crm.terminos.aceptar')) {
            return $next($request);
        }

        return redirect()->route('barbero.crm.terminos')
            ->with('warning', 'Debes leer y aceptar los Términos de Uso Interno del CRM antes de continuar.');
    }
}
