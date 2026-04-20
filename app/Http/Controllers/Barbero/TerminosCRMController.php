<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerminosCRMController extends Controller
{
    /** Versión actual de los Términos de Uso Interno del CRM */
    const TERMS_VERSION = '2.0';

    /** Mostrar pantalla de Términos de Uso Interno del CRM */
    public function show()
    {
        $user = Auth::guard('usuario')->user();

        // Si ya aceptó, redirigir al dashboard
        if (!empty($user->crm_terms_accepted_at)) {
            return redirect()->route('barbero.dashboard');
        }

        return view('barbero.terminos-crm');
    }

    /** Registrar la aceptación del colaborador */
    public function aceptar(Request $request)
    {
        $request->validate([
            'accept_terms' => ['required', 'accepted'],
        ], [
            'accept_terms.required' => 'Debes marcar la casilla para continuar.',
            'accept_terms.accepted' => 'Debes aceptar los Términos de Uso Interno para acceder al sistema.',
        ]);

        /** @var Usuario $user */
        $user = Auth::guard('usuario')->user();

        $user->crm_terms_accepted_at  = now();
        $user->crm_terms_accepted_ip  = $request->ip();
        $user->crm_terms_version      = self::TERMS_VERSION;
        $user->save();

        return redirect()->route('barbero.dashboard')
            ->with('success', '¡Bienvenido! Tu aceptación ha sido registrada correctamente.');
    }
}
