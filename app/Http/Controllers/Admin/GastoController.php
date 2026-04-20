<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gasto;
use App\Models\CategoriaGasto;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class GastoController extends Controller
{
    // ─── Lista con filtros (igual que tu ReporteGeneralController) ────────────
    public function index(Request $request)
    {
        $desde         = $request->input('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta         = $request->input('hasta', now()->format('Y-m-d'));
        $categoriaId   = $request->input('categoria_id');
        $sedeId        = $request->input('sede_id');
        $busqueda      = $request->input('busqueda');

        $query = Gasto::with(['categoria', 'sede', 'creadoPor'])
            ->whereBetween('fecha', [$desde, $hasta])
            ->when($categoriaId, fn($q) => $q->where('categoria_id', $categoriaId))
            ->when($sedeId,      fn($q) => $q->where('sede_id', $sedeId))
            ->when($busqueda,    fn($q) => $q->where('descripcion', 'like', "%{$busqueda}%"))
            ->orderBy('fecha', 'desc');

        $gastos       = $query->paginate(15)->withQueryString();
        $totalGastos  = $query->toBase()->sum('monto');
        $categorias   = CategoriaGasto::activas()->orderBy('nombre')->get();
        $sedes        = Sede::orderBy('sede_nombre')->get();

        return view('admin.gastos.index', compact(
            'gastos', 'totalGastos', 'categorias', 'sedes',
            'desde', 'hasta', 'categoriaId', 'sedeId', 'busqueda'
        ));
    }

    // ─── Formulario crear ─────────────────────────────────────────────────────
    public function create()
    {
        $categorias = CategoriaGasto::activas()->orderBy('nombre')->get();
        $sedes      = Sede::orderBy('sede_nombre')->get();
        return view('admin.gastos.create', compact('categorias', 'sedes'));
    }

    // ─── Guardar nuevo gasto ──────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias_gastos,id',
            'sede_id'      => 'nullable|exists:sede,sede_id',
            'descripcion'  => 'required|string|max:255',
            'monto'        => 'required|numeric|min:0.01',
            'fecha'        => 'required|date',
            'comprobante'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'categoria_id.required' => 'Selecciona una categoría.',
            'descripcion.required'  => 'La descripción es obligatoria.',
            'monto.required'        => 'El monto es obligatorio.',
            'monto.numeric'         => 'El monto debe ser un número.',
            'fecha.required'        => 'La fecha es obligatoria.',
            'comprobante.mimes'     => 'Solo se permiten PDF, JPG o PNG.',
            'comprobante.max'       => 'El archivo no puede superar 5MB.',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['sede_id']    = $request->sede_id ?: null;

        if ($request->hasFile('comprobante')) {
            $validated['comprobante'] = $request->file('comprobante')
                ->store('comprobantes/gastos', 'public');
        }

        Gasto::create($validated);

        return redirect()->route('admin.gastos.index')
            ->with('success', 'Gasto registrado correctamente.');
    }

    // ─── Formulario editar ────────────────────────────────────────────────────
    public function edit(Gasto $gasto)
    {
        $categorias = CategoriaGasto::activas()->orderBy('nombre')->get();
        $sedes      = Sede::orderBy('sede_nombre')->get();
        return view('admin.gastos.edit', compact('gasto', 'categorias', 'sedes'));
    }

    // ─── Actualizar gasto ─────────────────────────────────────────────────────
    public function update(Request $request, Gasto $gasto)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias_gastos,id',
            'sede_id'      => 'nullable|exists:sedes,id',
            'descripcion'  => 'required|string|max:255',
            'monto'        => 'required|numeric|min:0.01',
            'fecha'        => 'required|date',
            'comprobante'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'categoria_id.required' => 'Selecciona una categoría.',
            'descripcion.required'  => 'La descripción es obligatoria.',
            'monto.required'        => 'El monto es obligatorio.',
            'fecha.required'        => 'La fecha es obligatoria.',
            'comprobante.mimes'     => 'Solo se permiten PDF, JPG o PNG.',
            'comprobante.max'       => 'El archivo no puede superar 5MB.',
        ]);

        $validated['sede_id'] = $request->sede_id ?: null;

        if ($request->hasFile('comprobante')) {
            // Eliminar comprobante anterior
            if ($gasto->comprobante) {
                Storage::disk('public')->delete($gasto->comprobante);
            }
            $validated['comprobante'] = $request->file('comprobante')
                ->store('comprobantes/gastos', 'public');
        }

        $gasto->update($validated);

        return redirect()->route('admin.gastos.index')
            ->with('success', 'Gasto actualizado correctamente.');
    }

    // ─── Eliminar gasto ───────────────────────────────────────────────────────
    public function destroy(Gasto $gasto)
    {
        if ($gasto->comprobante) {
            Storage::disk('public')->delete($gasto->comprobante);
        }
        $gasto->delete();

        return redirect()->route('admin.gastos.index')
            ->with('success', 'Gasto eliminado.');
    }

    // ─── Exportar Excel (igual que tu ReporteGeneralController) ──────────────
    public function exportarExcel(Request $request)
    {
        $data    = $this->getDatosExport($request);
        $content = View::make('admin.gastos.excel', $data)->render();

        return response($content, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="gastos_' . now()->format('Y-m-d') . '.xls"',
            'Cache-Control'       => 'max-age=0',
            'Pragma'              => 'public',
        ]);
    }

    // ─── Reporte financiero (ingresos + gastos + ganancia neta) ──────────────
    public function reporteFinanciero(Request $request)
    {
        $data    = $this->getDatosReporteFinanciero($request);
        $content = View::make('admin.gastos.reporte_financiero_excel', $data)->render();

        return response($content, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reporte_financiero_' . now()->format('Y-m-d') . '.xls"',
            'Cache-Control'       => 'max-age=0',
            'Pragma'              => 'public',
        ]);
    }

    // ─── Datos reutilizables para exportaciones ───────────────────────────────
    private function getDatosExport(Request $request): array
    {
        $desde       = $request->input('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta       = $request->input('hasta', now()->format('Y-m-d'));
        $categoriaId = $request->input('categoria_id');
        $sedeId      = $request->input('sede_id');

        $gastos = Gasto::with(['categoria', 'sede'])
            ->whereBetween('fecha', [$desde, $hasta])
            ->when($categoriaId, fn($q) => $q->where('categoria_id', $categoriaId))
            ->when($sedeId,      fn($q) => $q->where('sede_id', $sedeId))
            ->orderBy('fecha', 'desc')
            ->get();

        return compact('gastos', 'desde', 'hasta');
    }

    private function getDatosReporteFinanciero(Request $request): array
    {
        $desde = $request->input('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->input('hasta', now()->format('Y-m-d'));

        // Ingresos desde Factura (igual que tu ReporteGeneralController)
        $totalIngresos = \App\Models\Factura::whereBetween('fac_fecha', [$desde, $hasta])
            ->sum('fac_total');

        // Gastos totales
        $totalGastos = Gasto::whereBetween('fecha', [$desde, $hasta])->sum('monto');

        // Ganancia neta
        $gananciaNeta = $totalIngresos - $totalGastos;

        // Desglose por categoría
        $gastosPorCategoria = Gasto::with('categoria')
            ->selectRaw('categoria_id, SUM(monto) as total, COUNT(*) as cantidad')
            ->whereBetween('fecha', [$desde, $hasta])
            ->groupBy('categoria_id')
            ->get();

        // Detalle de gastos
        $gastos = Gasto::with(['categoria', 'sede'])
            ->whereBetween('fecha', [$desde, $hasta])
            ->orderBy('fecha')
            ->get();

        return compact(
            'desde', 'hasta',
            'totalIngresos', 'totalGastos', 'gananciaNeta',
            'gastosPorCategoria', 'gastos'
        );
    }
}