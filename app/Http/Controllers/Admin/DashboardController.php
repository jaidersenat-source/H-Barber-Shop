<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Turno;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Usuario logueado
        $admin = Auth::user();

        // Total de clientes (por cédula única en turnos realizados)
        $clientesTotales = Turno::where('tur_estado', 'Realizado')->distinct('tur_cedula')->count('tur_cedula');

        // Turnos por estado
        $turnosPendientes = Turno::where('tur_estado', 'Pendiente')->count();
        $turnosRealizados = Turno::where('tur_estado', 'Realizado')->count();

        // Ingresos del mes
        $ingresosMes = Factura::whereMonth('fac_fecha', date('m'))
            ->whereYear('fac_fecha', date('Y'))
            ->sum('fac_total');

        // Servicios más vendidos (si usas factura_detalle)
        $serviciosTop = DB::table('factura_detalle')
            ->join('servicios', 'servicios.serv_id', '=', 'factura_detalle.serv_id')
            ->select('servicios.serv_nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('servicios.serv_nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Clientes más frecuentes (solo turnos realizados)
        $clientesFrecuentes = DB::table('turno')
            ->select('tur_cedula', 'tur_nombre', 'tur_celular', DB::raw('COUNT(*) as visitas'))
            ->where('tur_estado', 'Realizado')
            ->groupBy('tur_cedula', 'tur_nombre', 'tur_celular')
            ->orderByDesc('visitas')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'admin',
            'clientesTotales',
            'turnosPendientes',
            'turnosRealizados',
            'ingresosMes',
            'serviciosTop',
            'clientesFrecuentes'
        ));
    }
}
