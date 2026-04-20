<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Turno;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Usuario logueado
        $admin = Auth::user();

        // Fechas del mes actual
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $mesKey = $inicioMes->format('Y-m');

        // Total de clientes DEL MES (por cédula única en turnos realizados)
        $clientesTotales = Cache::remember("dashboard.clientes.{$mesKey}", 300, function () use ($inicioMes, $finMes) {
            return Turno::where('tur_estado', 'Realizado')
                ->whereBetween('tur_fecha', [$inicioMes, $finMes])
                ->distinct('tur_cedula')
                ->count('tur_cedula');
        });

        // Turnos pendientes (TODOS, sin filtro mensual)
        $turnosPendientes = Cache::remember('dashboard.pendientes', 60, function () {
            return Turno::where('tur_estado', 'Pendiente')->count();
        });
        
        // Turnos realizados DEL MES
        $turnosRealizados = Cache::remember("dashboard.realizados.{$mesKey}", 300, function () use ($inicioMes, $finMes) {
            return Turno::where('tur_estado', 'Realizado')
                ->whereBetween('tur_fecha', [$inicioMes, $finMes])
                ->count();
        });

        // Ingresos del mes - CORREGIDO: filtra por facturas del mes actual
        $ingresosMes = Cache::remember("dashboard.ingresos.{$mesKey}", 300, function () use ($inicioMes, $finMes) {
            return Factura::whereBetween('fac_fecha', [$inicioMes, $finMes])
                ->sum('fac_total_con_descuento');
        });

        // Servicios más vendidos DEL MES: combinar servicio principal (turno.serv_id) + factura_detalle
        $serviciosTop = Cache::remember("dashboard.servicios_top.{$mesKey}", 300, function () use ($inicioMes, $finMes) {
            // 1) servicios principales: uno por factura → turno.serv_id
            $principales = DB::table('factura')
                ->join('turno', 'factura.tur_id', '=', 'turno.tur_id')
                ->whereBetween('factura.fac_fecha', [$inicioMes, $finMes])
                ->whereNotNull('turno.serv_id')
                ->select('turno.serv_id', DB::raw('COUNT(*) as cantidad'))
                ->groupBy('turno.serv_id')
                ->get()
                ->keyBy('serv_id');

            // 2) servicios en factura_detalle
            $detalles = DB::table('factura_detalle')
                ->join('factura', 'factura.fac_id', '=', 'factura_detalle.fac_id')
                ->whereBetween('factura.fac_fecha', [$inicioMes, $finMes])
                ->whereNotNull('factura_detalle.serv_id')
                ->select('factura_detalle.serv_id', DB::raw('COUNT(*) as cantidad'))
                ->groupBy('factura_detalle.serv_id')
                ->get()
                ->keyBy('serv_id');

            // 3) sumar ambos
            $totales = [];
            foreach ($principales as $sid => $row) {
                $totales[$sid] = ($totales[$sid] ?? 0) + (int)$row->cantidad;
            }
            foreach ($detalles as $sid => $row) {
                $totales[$sid] = ($totales[$sid] ?? 0) + (int)$row->cantidad;
            }

            // 4) transformar a colección con nombre
            $result = collect();
            foreach ($totales as $serv_id => $cantidad) {
                $nombre = DB::table('servicios')->where('serv_id', $serv_id)->value('serv_nombre');
                $result->push((object)[
                    'serv_id' => $serv_id,
                    'serv_nombre' => $nombre,
                    'total' => $cantidad,
                ]);
            }

            return $result->sortByDesc('total')->values()->take(5);
        });

        // Clientes más frecuentes DEL MES (solo turnos realizados)
        $clientesFrecuentes = Cache::remember("dashboard.clientes_frecuentes.{$mesKey}", 300, function () use ($inicioMes, $finMes) {
            return DB::table('turno')
                ->select('tur_cedula', 'tur_nombre', 'tur_celular', DB::raw('COUNT(*) as visitas'))
                ->where('tur_estado', 'Realizado')
                ->whereBetween('tur_fecha', [$inicioMes, $finMes])
                ->groupBy('tur_cedula', 'tur_nombre', 'tur_celular')
                ->orderByDesc('visitas')
                ->limit(5)
                ->get();
        });

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