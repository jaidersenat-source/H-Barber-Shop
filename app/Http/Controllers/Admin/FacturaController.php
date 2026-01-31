<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Turno;
use App\Models\Sede;
use App\Models\FacturaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class FacturaController extends Controller
{
    // Listado de facturas con búsqueda y filtro
    public function index(Request $request)
    {
        $query = Factura::with('turno', 'sede');

        // Si no hay filtro de fecha ni búsqueda, mostrar solo facturas del mes actual
        if (!$request->filled('fecha') && !$request->filled('buscar')) {
            $inicioMes = now()->copy()->startOfMonth()->toDateString();
            $finMes = now()->copy()->endOfMonth()->toDateString();
            $query->whereBetween('fac_fecha', [$inicioMes, $finMes]);
        }
        // Filtrar por fecha exacta
        if ($request->filled('fecha') === true) {
            $query->whereDate('fac_fecha', $request->fecha);
        }
        // Búsqueda por cliente, sede o ID
        if ($request->filled('buscar') === true) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('fac_id', 'like', "%$buscar%")
                  ->orWhereHas('sede', function($sq) use ($buscar) {
                      $sq->where('sede_nombre', 'like', "%$buscar%")
                  ;})
                  ->orWhereHas('turno', function($tq) use ($buscar) {
                      $tq->where('tur_nombre', 'like', "%$buscar%")
                        ->orWhere('tur_id', 'like', "%$buscar%")
                  ;});
            });
        }
        $facturas = $query->orderBy('fac_fecha', 'desc')->paginate(20);
        return view('admin.facturas.index', compact('facturas'));
    }

    // Formulario para crear factura
    public function create($tur_id)
    {
        $turno = Turno::findOrFail($tur_id);
        $sedes = Sede::all();
        return view('admin.facturas.create', compact('turno', 'sedes'));
    }

    // Guardar factura
    public function store(Request $request)
    {
        $request->validate([
            'tur_id' => 'required|exists:turno,tur_id',
            'sede_id' => 'required|exists:sede,sede_id',
            'fac_abono' => 'nullable|numeric|min:0',
        ]);

        $factura = Factura::create([
            'fac_fecha' => now(),
            'tur_id' => $request->tur_id,
            'sede_id' => $request->sede_id,
            'fac_total' => 0,
            'fac_abono' => $request->fac_abono ?? 0,
        ]);

        // Redirigir a la vista de detalles personalizada
        return redirect()->route('facturas.detalle', $factura->fac_id)
            ->with('ok', 'Factura creada. Ahora agregue los servicios extra.');
    }

    // Mostrar detalle de factura
    public function show($fac_id)
    {
        $factura = Factura::with(['detalles.servicios', 'turno', 'sede'])->findOrFail($fac_id);
        return view('admin.facturas.show', compact('factura'));
    }

    public function detalle($fac_id)
    {
        $factura = Factura::with(['detalles.servicios', 'turno', 'sede'])->findOrFail($fac_id);
        return view('admin.facturas.detalles.detalle', compact('factura'));
    }

    public function descargarPdf($fac_id)
    {
        $factura = Factura::with(['detalles.servicios', 'turno', 'sede'])->findOrFail($fac_id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.facturas.pdf', compact('factura'));
        $pdfContent = $pdf->output();

        // Enviar correo al cliente y admin
        try {
            $clienteEmail = $factura->turno->tur_correo;
            $admin = \App\Models\Usuario::where('rol', 'admin')->first();
            Mail::to($clienteEmail)
                ->bcc($admin && $admin->persona ? $admin->persona->per_correo : null)
                ->send(new \App\Mail\FacturaMail($factura, $pdfContent));
        } catch (\Exception $e) {
            
        }

        return response()->streamDownload(function() use ($pdfContent) {
            echo $pdfContent;
        }, 'factura_'.$fac_id.'.pdf');
    }

    /**
     * Eliminar factura (requiere confirmación de contraseña)
     */
    public function destroy(Request $request, $fac_id)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
        // Verificar contraseña del usuario autenticado
        if (Hash::check($request->password, $request->user()->password) === false) {
            return back()->withErrors(['password' => 'Contraseña incorrecta. No se eliminó la factura.']);
        }
        $factura = Factura::findOrFail($fac_id);
        $factura->delete();
        return redirect()->route('factura.index')->with('ok', 'Factura eliminada correctamente.');
    }
}
