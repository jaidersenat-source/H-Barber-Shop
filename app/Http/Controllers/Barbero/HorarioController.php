<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Disponibilidad;

class HorarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $persona = $usuario->persona;
        // Mostrar TODAS las disponibilidades (semanal y específicas)
        $disponibilidades = $persona->disponibilidades()
            ->orderByRaw('COALESCE(dis_fecha, "9999-12-31")')
            ->orderBy('dia')
            ->orderBy('dis_hora_inicio')
            ->get();
        return view('barbero.horario.horarios', compact('disponibilidades'));
    }
}
