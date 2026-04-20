<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Turno;
use App\Models\Sede;
use App\Models\FacturaDetalle;
use App\Services\MembresiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class FacturaController extends Controller
{
    public function __construct(protected MembresiaService $membresiaService) {}

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

        // Bloquear doble facturación
        if (Factura::where('tur_id', $tur_id)->exists()) {
            return redirect()->route('factura.index')
                ->with('error', 'Este turno ya tiene una factura generada.');
        }

        // Resolver sede automáticamente desde el barbero del turno
        $personalSede = \App\Models\Personal_Sede::where('per_documento', $turno->per_documento)
            ->where('persede_estado', 'Activo')
            ->with('sede')
            ->first();
        $sedeAuto = $personalSede?->sede;

        return view('admin.facturas.create', compact('turno', 'sedeAuto'));
    }

    // Guardar factura
    public function store(Request $request)
    {
        // Bloquear doble facturación
        if (Factura::where('tur_id', $request->tur_id)->exists()) {
            return redirect()->route('factura.index')
                ->with('error', 'Este turno ya tiene una factura generada.');
        }

        $turno = Turno::findOrFail($request->tur_id);

        // Resolver sede desde el barbero si no viene en el request
        $sedeId = $request->sede_id;
        if (!$sedeId) {
            $personalSede = \App\Models\Personal_Sede::where('per_documento', $turno->per_documento)
                ->where('persede_estado', 'Activo')
                ->first();
            $sedeId = $personalSede?->sede_id;
        }

        if ($request->has('accion_rapida')) {
            // Precio original del servicio principal (sin ningún descuento)
            $precioOriginal = (float) ($turno->servicio->serv_precio ?? 0);

            // Detectar membresía activa del cliente y aplicar beneficio
            $cm        = $this->membresiaService->detectarActiva($turno->tur_cedula ?? '');
            $beneficio = $cm
                ? $this->membresiaService->aplicarBeneficio($cm, $precioOriginal, $turno->servicio?->serv_id)
                : null;

            // Total con descuento (lo que realmente se cobra)
            $totalConDescuento = $beneficio ? $beneficio['precio_final'] : $precioOriginal;

            $factura = Factura::create([
                'fac_fecha'                => now(),
                'tur_id'                   => $turno->tur_id,
                'sede_id'                  => $sedeId,
                'fac_total'                => $precioOriginal,          // precio SIN descuento
                'fac_total_con_descuento'  => $totalConDescuento,        // precio CON descuento
                'fac_abono'                => $turno->tur_anticipo ?? 0,
                'membresia_descuento'      => $beneficio ? $beneficio['descuento_membresia'] : 0,
            ]);

            if ($cm && $beneficio && $beneficio['aplica']) {
                $this->membresiaService->incrementarUso($cm);
            }

            \App\Http\Controllers\Admin\FidelizacionController::agregarPunto($turno);

            $factura->load(['turno.servicio', 'detalles.servicios', 'detalles.producto', 'sede']);
            $pdf = PDF::loadView('admin.facturas.pdf', compact('factura'));

            Mail::to($turno->tur_correo)
                ->cc('hbrbrshop@gmail.com')
                ->send(new \App\Mail\FacturaMail($factura, $pdf->output()));

            return redirect()->route('factura.index')
                ->with('success', 'Factura creada y enviada correctamente.');

        } elseif ($request->has('agregar_servicios')) {
            $servPrincipal   = $turno->servicio;
            $precioPrincipal = (float) ($servPrincipal->serv_precio ?? 0); // precio SIN descuento
            $descPrincipal   = (float) ($servPrincipal->serv_descuento ?? 0);
            $totalInicial    = $precioPrincipal * (1 - $descPrincipal / 100); // precio tras descuento del servicio

            $cm        = $this->membresiaService->detectarActiva($turno->tur_cedula ?? '');
            $beneficio = $cm
                ? $this->membresiaService->aplicarBeneficio($cm, $totalInicial, $servPrincipal?->serv_id)
                : null;

            // Total con todos los descuentos aplicados (lo que realmente se cobra)
            $totalConDescuento = $beneficio ? $beneficio['precio_final'] : $totalInicial;

            $factura = Factura::create([
                'fac_fecha'                => now(),
                'tur_id'                   => $turno->tur_id,
                'sede_id'                  => $sedeId,
                'fac_total'                => $precioPrincipal,          // precio SIN descuento
                'fac_total_con_descuento'  => $totalConDescuento,        // precio CON descuento
                'fac_abono'                => $request->fac_abono ?? 0,
                'membresia_descuento'      => $beneficio ? $beneficio['descuento_membresia'] : 0,
            ]);

            if ($cm && $beneficio && $beneficio['aplica']) {
                $this->membresiaService->incrementarUso($cm);
            }

            \App\Http\Controllers\Admin\FidelizacionController::agregarPunto($turno);

            return redirect()->route('facturas.detalle', $factura->fac_id)
                ->with('ok', 'Factura creada. Ahora agregue los servicios extra.');
        }

        // Fallback (no debería llegar aquí)
        return redirect()->back()->with('error', 'Acción no reconocida.');
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

    /**
     * Descargar PDF de la factura y enviar por correo.
     * Carga todas las relaciones necesarias, incluyendo productos de los detalles.
     */
    public function descargarPdf($fac_id)
    {
        $factura = Factura::with(['turno.servicio', 'detalles.servicios', 'detalles.producto', 'sede'])
            ->findOrFail($fac_id);

        $pdf = Pdf::loadView('admin.facturas.pdf', compact('factura'));
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
     * Generar y descargar PDF de la factura (método alternativo).
     * Carga todas las relaciones necesarias, incluyendo productos de los detalles.
     */
    public function generarPDF($fac_id)
    {
        $factura = Factura::with(['turno.servicio', 'detalles.servicios', 'detalles.producto', 'sede'])
            ->findOrFail($fac_id);
        $pdf = Pdf::loadView('admin.facturas.pdf', compact('factura'));
        return $pdf->download("factura-{$factura->fac_id}.pdf");
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
        // Si es petición AJAX, devolver JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Contraseña incorrecta. No se eliminó la factura.'
            ], 401);
        }
        return back()->withErrors(['password' => 'Contraseña incorrecta. No se eliminó la factura.'])
                    ->with('error', 'Contraseña incorrecta. No se eliminó la factura.');
    }
    
    $factura = Factura::findOrFail($fac_id);
    $factura->delete();
    
    // Si es petición AJAX, devolver JSON
    if ($request->expectsJson() || $request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Factura eliminada correctamente.'
        ]);
    }
    
    return redirect()->route('factura.index')->with('success', 'Factura eliminada correctamente.');
}
}