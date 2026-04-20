<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Factura;
use App\Models\Turno;
use App\Models\FacturaDetalle;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Personal_Sede;
use App\Models\Sede;
use App\Models\Disponibilidad;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ReporteGeneralController extends Controller
{
    // Formulario y resultados del reporte general
    public function index(Request $request)
    {
        $data = $this->getReporteData($request);
        return view('admin.reportes.general', $data);
    }

    // Exportar a PDF
    public function exportarPdf(Request $request)
    {
        $data = $this->getReporteData($request);
           $pdf = Pdf::loadView('admin.reportes.general_pdf', $data);
        return $pdf->download('reporte_general.pdf');
    }

    // Exportar a Excel (HTML compatible)
    public function exportarExcel(Request $request)
    {
        $data = $this->getReporteData($request);
        $content = View::make('admin.reportes.general_excel', $data)->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reporte_general.xls"',
            'Cache-Control' => 'max-age=0',
            'Pragma' => 'public',
        ]);
    }

    // ══ REPORTE DE PRODUCTOS Y SERVICIOS MÁS VENDIDOS ══

    /**
     * Vista con productos y servicios más vendidos en un rango de fechas.
     */
    public function reporteProductos(Request $request)
    {
        $desde = $request->input('desde', now()->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());

        $productosMasVendidos = $this->getProductosMasVendidos($desde, $hasta);
        $serviciosMasVendidosReporte = $this->getServiciosMasVendidos($desde, $hasta);

        $totalFacturas = Factura::whereBetween('fac_fecha', [$desde, $hasta])->count();
        $ingresoTotal  = Factura::whereBetween('fac_fecha', [$desde, $hasta])->sum('fac_total_con_descuento');

        return view('admin.reportes.index', compact(
            'productosMasVendidos',
            'serviciosMasVendidosReporte',
            'totalFacturas',
            'ingresoTotal',
            'desde',
            'hasta'
        ));
    }

    /**
     * Exportar reporte de productos más vendidos a PDF.
     */
    public function exportarProductosPdf(Request $request)
    {
        $desde = $request->input('desde', now()->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());

        $productosMasVendidos = $this->getProductosMasVendidos($desde, $hasta);

        $pdf = Pdf::loadView('admin.reportes.pdf_productos', compact(
            'productosMasVendidos', 'desde', 'hasta'
        ));

        return $pdf->download("reporte-productos-{$desde}-a-{$hasta}.pdf");
    }

    /**
     * Exportar reporte de productos más vendidos a Excel.
     */
    public function exportarProductosExcel(Request $request)
    {
        $desde = $request->input('desde', now()->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());

        $productosMasVendidos = $this->getProductosMasVendidos($desde, $hasta);
        $content = View::make('admin.reportes.excel_productos', compact(
            'productosMasVendidos', 'desde', 'hasta'
        ))->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reporte-productos-' . $desde . '-a-' . $hasta . '.xls"',
            'Cache-Control' => 'max-age=0',
            'Pragma' => 'public',
        ]);
    }

    // ══ HELPERS PRIVADOS ══

    /**
     * Obtener productos más vendidos en un rango de fechas.
     */
    private function getProductosMasVendidos(string $desde, string $hasta)
    {
        return FacturaDetalle::select(
                'pro_id',
                DB::raw('MAX(facdet_descripcion) as nombre'),
                DB::raw('SUM(facdet_cantidad) as total_vendido'),
                DB::raw('SUM(facdet_subtotal) as ingreso_total')
            )
            ->whereNotNull('pro_id')
            ->whereHas('factura', function ($q) use ($desde, $hasta) {
                $q->whereBetween('fac_fecha', [$desde, $hasta]);
            })
            ->groupBy('pro_id')
            ->orderByDesc('total_vendido')
            ->limit(20)
            ->get();
    }

    /**
     * Obtener servicios más vendidos en un rango de fechas (para el reporte de productos).
     */
    private function getServiciosMasVendidos(string $desde, string $hasta)
    {
        // 1) Contar servicios principales (uno por factura, desde turno.serv_id)
        $principales = DB::table('factura')
            ->join('turno', 'factura.tur_id', '=', 'turno.tur_id')
            ->whereBetween('factura.fac_fecha', [$desde, $hasta])
            ->whereNotNull('turno.serv_id')
            ->select('turno.serv_id', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('turno.serv_id')
            ->get()
            ->keyBy('serv_id');

        // 2) Contar servicios en factura_detalle (extras y/o cuando se guardó como detalle)
        $detalles = DB::table('factura_detalle')
            ->join('factura', 'factura_detalle.fac_id', '=', 'factura.fac_id')
            ->whereBetween('factura.fac_fecha', [$desde, $hasta])
            ->whereNotNull('factura_detalle.serv_id')
            ->select('factura_detalle.serv_id', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('factura_detalle.serv_id')
            ->get()
            ->keyBy('serv_id');

        // 3) Sumar ambos conteos por serv_id
        $totales = [];
        foreach ($principales as $sid => $row) {
            $totales[$sid] = ($totales[$sid] ?? 0) + (int)$row->cantidad;
        }
        foreach ($detalles as $sid => $row) {
            $totales[$sid] = ($totales[$sid] ?? 0) + (int)$row->cantidad;
        }

        // 4) Transformar a colección con nombre del servicio
        $result = collect();
        foreach ($totales as $serv_id => $cantidad) {
            $nombre = DB::table('servicios')->where('serv_id', $serv_id)->value('serv_nombre') ?? null;
            $result->push((object)[
                'serv_id' => $serv_id,
                'nombre' => $nombre,
                'cantidad' => $cantidad,
            ]);
        }

        return $result->sortByDesc('cantidad')->values()->take(20);
    }

    // ══ LÓGICA REPORTE GENERAL ══

    private function getReporteData(Request $request)
{
    $desde = $request->input('desde', now()->startOfMonth()->format('Y-m-d'));
    $hasta = $request->input('hasta', now()->format('Y-m-d'));

    // Ventas = total cobrado con descuentos aplicados
    $ventasTotales = Factura::whereBetween('fac_fecha', [$desde, $hasta])->sum('fac_total_con_descuento');
    $gastosQuery   = \App\Models\Gasto::whereBetween('fecha', [$desde, $hasta])->with(['categoria', 'sede']);
    $gastosTotales = $gastosQuery->sum('monto');
    $gastosDetalle = $gastosQuery->orderBy('fecha', 'desc')->get();
    $gananciaNeta  = $ventasTotales - $gastosTotales;

    // Cantidad de servicios realizados (todos, no solo los que tengan 'corte' en el nombre)
    $cantidadCortes = FacturaDetalle::whereNotNull('serv_id')
        ->whereHas('factura', function ($q) use ($desde, $hasta) {
            $q->whereBetween('fac_fecha', [$desde, $hasta]);
        })->count();

    // Sumar también el servicio principal del turno (no guardado en factura_detalle)
    $cantidadCortes += Factura::whereBetween('fac_fecha', [$desde, $hasta])->count();

    // Usar el helper que agrupa por `serv_id` y devuelve nombre + totales
    $rawServicios = $this->getServiciosMasVendidos($desde, $hasta);

    // Normalizar la estructura para la vista (mantener `cantidad` y `serv_nombre`/`servicios` fallback)
    // Agrupar por nombre de servicio para unir entradas con distinto `serv_id` pero mismo nombre
    $normalized = $rawServicios->map(function ($s) {
        return (object) [
            'serv_id' => $s->serv_id,
            'cantidad' => $s->cantidad ?? $s->total_vendido ?? 0,
            'serv_nombre' => $s->nombre ?? ($s->serv_nombre ?? null),
        ];
    });

    $serviciosMasVendidos = $normalized
        ->groupBy('serv_nombre')
        ->map(function ($group, $name) {
            return (object) [
                'serv_nombre' => $name,
                'cantidad' => $group->sum('cantidad'),
            ];
        })
        ->values()
        ->take(5);

    // ← AÑADIR ESTO
    $productosMasVendidos = $this->getProductosMasVendidos($desde, $hasta);

    $barberos = Turno::select(
            'dis_id',
            DB::raw('COUNT(*) as cantidad_servicios'),
            DB::raw('SUM(factura.fac_total_con_descuento) as total_ventas')
        )
        ->join('factura', 'turno.tur_id', '=', 'factura.tur_id')
        ->whereBetween('factura.fac_fecha', [$desde, $hasta])
        ->groupBy('dis_id')
        ->with(['disponibilidad.persona'])
        ->orderByDesc('cantidad_servicios')
        ->get();

    $diasMasSolicitados = Turno::select(
            DB::raw('DATE(tur_fecha) as dia'),
            DB::raw('COUNT(*) as cantidad')
        )
        ->whereHas('factura', function ($q) use ($desde, $hasta) {
            $q->whereBetween('fac_fecha', [$desde, $hasta]);
        })
        ->groupBy(DB::raw('DATE(tur_fecha)'))
        ->orderByDesc('cantidad')
        ->take(7)
        ->get();

    return compact(
        'desde', 'hasta', 'ventasTotales', 'gastosTotales', 'gananciaNeta',
        'cantidadCortes', 'serviciosMasVendidos', 'barberos', 'diasMasSolicitados',
        'gastosDetalle',
        'productosMasVendidos'  // ← AÑADIR ESTO
    );
}
}