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
        $pdf = Pdf::loadView('admin.reportes.general', $data);
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



    // Reutilizar lógica de obtención de datos
    private function getReporteData(Request $request)
    {
        $desde = $request->input('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->input('hasta', now()->format('Y-m-d'));

        $ventasTotales = Factura::whereBetween('fac_fecha', [$desde, $hasta])->sum('fac_total');
        $cantidadCortes = FacturaDetalle::whereHas('servicios', function($q) {
            $q->where('serv_nombre', 'like', '%corte%');
        })->whereHas('factura', function($q) use ($desde, $hasta) {
            $q->whereBetween('fac_fecha', [$desde, $hasta]);
        })->count();
        $serviciosMasVendidos = FacturaDetalle::select('serv_id', DB::raw('COUNT(*) as cantidad'))
            ->whereHas('factura', function($q) use ($desde, $hasta) {
                $q->whereBetween('fac_fecha', [$desde, $hasta]);
            })
            ->groupBy('serv_id')
            ->orderByDesc('cantidad')
            ->with('servicios')
            ->take(5)
            ->get();
        $barberos = Turno::select('dis_id',
                DB::raw('COUNT(*) as cantidad_servicios'),
                DB::raw('SUM(factura.fac_total) as total_ventas'))
            ->join('factura', 'turno.tur_id', '=', 'factura.tur_id')
            ->whereBetween('factura.fac_fecha', [$desde, $hasta])
            ->groupBy('dis_id')
            ->with(['disponibilidad.persona'])
            ->orderByDesc('cantidad_servicios')
            ->get();
        $diasMasSolicitados = Turno::select(DB::raw('DATE(tur_fecha) as dia'), DB::raw('COUNT(*) as cantidad'))
            ->whereHas('factura', function($q) use ($desde, $hasta) {
                $q->whereBetween('fac_fecha', [$desde, $hasta]);
            })
            ->groupBy(DB::raw('DATE(tur_fecha)'))
            ->orderByDesc('cantidad')
            ->take(7)
            ->get();
        return compact('desde', 'hasta', 'ventasTotales', 'cantidadCortes', 'serviciosMasVendidos', 'barberos', 'diasMasSolicitados');
    }
}
