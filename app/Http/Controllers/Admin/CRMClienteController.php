<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class CRMClienteController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $clientes = DB::table('turno')
            ->select(
                'tur_nombre',
                'tur_cedula',
                'tur_celular',
                DB::raw('COUNT(*) as visitas'),
                DB::raw('MAX(tur_fecha) as ultima_visita'),
                DB::raw('(SELECT SUM(factura.fac_total) FROM factura JOIN turno t2 ON t2.tur_id = factura.tur_id WHERE t2.tur_cedula = turno.tur_cedula) as gasto_total'),
                DB::raw('(SELECT servicios.serv_nombre FROM factura_detalle JOIN servicios ON servicios.serv_id = factura_detalle.serv_id JOIN factura ON factura.fac_id = factura_detalle.fac_id JOIN turno t3 ON t3.tur_id = factura.tur_id WHERE t3.tur_cedula = turno.tur_cedula GROUP BY servicios.serv_nombre ORDER BY COUNT(*) DESC LIMIT 1) as servicio_favorito')
            )
            ->where('tur_estado', 'Realizado')
            ->groupBy('tur_nombre', 'tur_cedula', 'tur_celular');

        // Filtros avanzados
        if ($request->filled('frecuencia') === true) {
            $clientes->having('visitas', '>=', $request->frecuencia);
        }
        if ($request->filled('gasto_min') === true) {
            $clientes->having('gasto_total', '>=', $request->gasto_min);
        }
        if ($request->filled('gasto_max') === true) {
            $clientes->having('gasto_total', '<=', $request->gasto_max);
        }
        if ($request->filled('servicio_favorito') === true) {
            $clientes->having('servicio_favorito', 'like', "%" . $request->servicio_favorito . "%");
        }
        if ($request->filled('inactivo_desde') === true) {
            $clientes->having('ultima_visita', '<=', $request->inactivo_desde);
        }

        // Filtros básicos de búsqueda
        if ($request->filled('nombre') === true) {
            $clientes->where('tur_nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('celular') === true) {
            $clientes->where('tur_celular', 'like', '%' . $request->celular . '%');
        }

        $clientes = $clientes->orderByDesc('visitas')->get();

        return view('admin.crm.clientes', compact('clientes'));
    }

    public function show($cedula, $celular = null)
    {
        $desde = request('desde');
        $hasta = request('hasta');
        $servicio = request('servicio');

        // Historial del cliente
        $turnos = Turno::where('tur_cedula', $cedula)
            ->where('tur_estado', 'Realizado')
            ->when($desde, function($q) use ($desde) {
                $q->where('tur_fecha', '>=', $desde);
            })
            ->when($hasta, function($q) use ($hasta) {
                $q->where('tur_fecha', '<=', $hasta);
            })
            ->orderByDesc('tur_fecha')
            ->get();

        // Total gastado y facturas filtradas
        $facturas = Factura::join('turno', 'turno.tur_id', '=', 'factura.tur_id')
            ->where('turno.tur_cedula', $cedula)
            ->where('turno.tur_estado', 'Realizado')
            ->when($desde, function($q) use ($desde) {
                $q->where('factura.fac_fecha', '>=', $desde);
            })
            ->when($hasta, function($q) use ($hasta) {
                $q->where('factura.fac_fecha', '<=', $hasta);
            })
            ->select('factura.*')
            ->get();

        // Si se filtra por servicio, solo mostrar turnos/facturas que lo incluyan
        if ($servicio === true) {
            $turnos = $turnos->filter(function($t) use ($servicio) {
                return stripos($t->servicio_nombre ?? '', $servicio) !== false;
            });
            $facturas = $facturas->filter(function($f) use ($servicio) {
                return $f->detalles->contains(function($d) use ($servicio) {
                    return stripos($d->servicios->serv_nombre ?? '', $servicio) !== false;
                });
            });
        }

            $cliente = Turno::where('tur_cedula', $cedula)->first();
            $totalGasto = $facturas->sum('fac_total');
        $visitas = $turnos->count();
        $promedioGasto = $visitas > 0 ? round($totalGasto / $visitas) : 0;

        return view('admin.crm.detalle_cliente', compact(
                'turnos',
                'facturas',
                'totalGasto',
                'promedioGasto',
                'cliente'
            ));
    }

    public function exportPdf()
    {
        $clientes = Turno::select(
                'tur_nombre',
                'tur_cedula',
                'tur_celular',
                DB::raw('COUNT(*) as visitas'),
                DB::raw('MAX(tur_fecha) as ultima_visita')
            )
            ->where('tur_estado', 'Realizado')
            ->groupBy('tur_nombre', 'tur_cedula', 'tur_celular')
            ->orderByDesc('visitas')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.crm.clientes_pdf', compact('clientes'));
        return $pdf->download('clientes_crm.pdf');
    }
}
