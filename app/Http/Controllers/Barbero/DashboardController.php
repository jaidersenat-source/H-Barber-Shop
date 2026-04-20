<?php

namespace App\Http\Controllers\Barbero;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Turno;
use App\Models\Factura;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $persona = $usuario->persona;
        $cedula = $persona->per_documento;
        $inicioSemana = now()->startOfWeek();
        $finSemana = now()->endOfWeek();

        // Turnos realizados esta semana
        $turnos = Turno::where('per_documento', $cedula)
            ->whereBetween('tur_fecha', [$inicioSemana, $finSemana])
            ->where('tur_estado', 'Realizado')
            ->pluck('tur_id');

        // Facturas asociadas a esos turnos
        $facturas = Factura::with('detalles')
            ->whereIn('tur_id', $turnos)
            ->get();

        $totalServicios = 0;
        $totalCortes = 0;
        $totalGanado = 0;
        $servicios = [];

        foreach ($facturas as $factura) {
            foreach ($factura->detalles as $detalle) {
                $totalServicios++;
                $totalGanado += $detalle->serv_precio * 0.5;
                if (strpos(strtolower($detalle->serv_nombre), 'corte') !== false) {
                    $totalCortes++;
                }
                $servicios[$detalle->serv_nombre] = ($servicios[$detalle->serv_nombre] ?? 0) + 1;
            }
        }

        $totalNegocio = $totalGanado; // 50% para el negocio

        return view('barbero.dashboard', compact('totalServicios', 'totalCortes', 'totalGanado', 'totalNegocio', 'servicios'));
    }
}
