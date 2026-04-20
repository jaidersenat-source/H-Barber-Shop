<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Producto;
use App\Models\Servicio;
use App\Services\MembresiaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaDetalleController extends Controller
{
    public function __construct(protected MembresiaService $membresiaService) {}

    /**
     * Agregar servicio extra a una factura.
     * Aplica membresía activa del cliente si corresponde al servicio.
     */
    public function store(Request $request, $fac_id)
    {
        $request->validate([
            'serv_id' => 'required|exists:servicios,serv_id',
        ]);

        $servicio       = Servicio::findOrFail($request->serv_id);
        // Precio base (antes de aplicar el descuento definido en el servicio)
        $precioBase = (float) ($servicio->serv_precio ?? 0);
        // Precio tras el descuento del propio servicio (porcentaje)
        $precioTrasDescuentoServicio = $precioBase * (1 - (($servicio->serv_descuento ?? 0) / 100));

        // Detectar membresía activa del cliente a través de la factura → turno → cedula
        $factura = Factura::with('turno')->findOrFail($fac_id);
        $cedula  = $factura->turno->tur_cedula ?? '';
        $cm      = $this->membresiaService->detectarActiva($cedula);

        // Aplicar beneficio de la membresía sobre el precio tras el descuento del servicio
        $beneficio = $cm
            ? $this->membresiaService->aplicarBeneficio($cm, $precioTrasDescuentoServicio, $servicio->serv_id)
            : null;

        $precioFinal = $beneficio ? $beneficio['precio_final'] : $precioTrasDescuentoServicio;

        // Si el servicio ya existe en esta factura, incrementar cantidad en lugar de crear nueva fila
        $detalleExistente = FacturaDetalle::where('fac_id', $fac_id)
            ->where('serv_id', $servicio->serv_id)
            ->first();

        if ($detalleExistente) {
            $detalleExistente->facdet_cantidad += 1;
            $detalleExistente->facdet_subtotal  = $detalleExistente->facdet_precio_unitario * $detalleExistente->facdet_cantidad;
            $detalleExistente->serv_precio      = $detalleExistente->facdet_subtotal;
            $detalleExistente->save();
        } else {
            FacturaDetalle::create([
                'fac_id'                 => $fac_id,
                'serv_id'                => $servicio->serv_id,
                'serv_precio'            => $precioFinal,
                'serv_nombre'            => $servicio->serv_nombre,
                'facdet_descripcion'     => $servicio->serv_nombre,
                'facdet_cantidad'        => 1,
                'facdet_precio_unitario' => $precioFinal,
                'facdet_subtotal'        => $precioFinal,
                // Guardar precio original como el precio base del servicio (antes del descuento de servicio)
                'precio_original'        => $precioBase,
                // Guardar monto de descuento por membresía (si aplica)
                'descuento_membresia'    => $beneficio ? $beneficio['descuento_membresia'] : 0,
                'tipo_descuento'         => $beneficio ? $beneficio['tipo_descuento'] : null,
                'cliente_membresia_id'   => ($cm && $beneficio && $beneficio['aplica']) ? $cm->id : null,
            ]);
        }

        // Incrementar uso si el beneficio se aplicó al extra
        if ($cm && $beneficio && $beneficio['aplica']) {
            $this->membresiaService->incrementarUso($cm);
        }

        $this->recalcularTotal($fac_id);

        return redirect()->route('facturas.detalle', $fac_id)
            ->with('ok', 'Servicio agregado a la factura.');
    }

    /**
     * Agregar producto a una factura (con control de stock).
     */
    public function storeProducto(Request $request, $fac_id)
    {
        $request->validate([
            'pro_id'   => 'required|exists:productos,pro_id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->pro_id);

        // Validar stock disponible
        if ($producto->pro_stock < $request->cantidad) {
            return redirect()->route('facturas.detalle', $fac_id)
                ->withErrors(['pro_id' => "Stock insuficiente para «{$producto->pro_nombre}». Disponible: {$producto->pro_stock}."])
                ->withInput();
        }

        // Precio unitario base (aplica descuento propio del producto si tiene)
        $precioUnitarioBase = (float) $producto->pro_precio * (1 - (($producto->pro_descuento ?? 0) / 100));

        // Permitir aplicar un descuento por ítem (por ejemplo 7%) pasado en el request
        $descuentoPorcentaje = $request->input('descuento_porcentaje'); // opcional, valor en % (p.ej. 7)
        $descuentoMonto = 0;
        $precioUnitarioFinal = $precioUnitarioBase;

        if (!is_null($descuentoPorcentaje) && is_numeric($descuentoPorcentaje) && $descuentoPorcentaje > 0) {
            $descuentoPorcentaje = max(0, min(100, (float)$descuentoPorcentaje));
            $descuentoMonto = $precioUnitarioBase * ($descuentoPorcentaje / 100);
            $precioUnitarioFinal = max(0, $precioUnitarioBase - $descuentoMonto);
        }

        $subtotal = $precioUnitarioFinal * $request->cantidad;

        DB::transaction(function () use ($fac_id, $producto, $request, $precioUnitarioFinal, $precioUnitarioBase, $descuentoMonto, $subtotal) {
            // Crear detalle de factura (guardar auditoría de precio original y descuento aplicado)
            FacturaDetalle::create([
                'fac_id'                 => $fac_id,
                'pro_id'                 => $producto->pro_id,
                'facdet_descripcion'     => $producto->pro_nombre,
                'facdet_cantidad'        => $request->cantidad,
                'facdet_precio_unitario' => $precioUnitarioFinal,
                'facdet_subtotal'        => $subtotal,
                'precio_original'        => $precioUnitarioBase,
                'descuento_membresia'    => $descuentoMonto,
                'tipo_descuento'         => $descuentoMonto > 0 ? 'porcentaje_producto' : null,
            ]);

            // Descontar stock
            $producto->decrement('pro_stock', $request->cantidad);
        });

        $this->recalcularTotal($fac_id);

        return redirect()->route('facturas.detalle', $fac_id)
            ->with('ok', "Producto «{$producto->pro_nombre}» (x{$request->cantidad}) agregado a la factura.");
    }

    /**
     * Eliminar un detalle de factura (restaura stock si es producto).
     */
    public function destroy($facdet_id)
    {
        $detalle = FacturaDetalle::findOrFail($facdet_id);
        $fac_id  = $detalle->fac_id;

        DB::transaction(function () use ($detalle) {
            // Si es producto, restaurar stock
            if ($detalle->pro_id) {
                Producto::where('pro_id', $detalle->pro_id)
                    ->increment('pro_stock', $detalle->facdet_cantidad);
            }

            $detalle->delete();
        });

        $this->recalcularTotal($fac_id);

        return redirect()->route('facturas.detalle', $fac_id)
            ->with('ok', 'Detalle eliminado de la factura.');
    }

    /**
     * Recalcula el total de la factura incluyendo servicios y productos.
     */
    private function recalcularTotal($fac_id)
    {
        $factura = Factura::with(['turno.servicio', 'detalles'])->findOrFail($fac_id);

        // 1. Precio del servicio principal con su propio descuento de servicio
        $servPrincipal = $factura->turno->servicio ?? null;
        if ($servPrincipal) {
            $precioPrincipal = (float) ($servPrincipal->serv_precio ?? 0);
            $descPrincipal   = (float) ($servPrincipal->serv_descuento ?? 0);
            $totalPrincipal  = $precioPrincipal * (1 - $descPrincipal / 100);
        } else {
            $totalPrincipal = 0;
        }

        // 2. Restar el descuento de membresía ya aplicado al principal al crear la factura
        //    (guardado en factura.membresia_descuento para no perderlo al recalcular)
        $descuentoMembresía = (float) ($factura->membresia_descuento ?? 0);
        $totalPrincipal     = max(0, $totalPrincipal - $descuentoMembresía);

        // 3. Servicios extra (solo los que NO son el servicio principal)
        //    serv_precio ya contiene el precio final con membresía si fue aplicada
        $totalExtras = $factura->detalles
            ->whereNotNull('serv_id')
            ->where('serv_id', '!=', $factura->turno->serv_id)
            ->sum('serv_precio');

        // 4. Productos
        $totalProductos = $factura->detalles
            ->whereNotNull('pro_id')
            ->sum('facdet_subtotal');

        // 5. Total con descuento = Principal (con descuentos) + Extras (con descuentos) + Productos (con descuentos por ítem)
        $totalConDescuento = $totalPrincipal + $totalExtras + $totalProductos;

        // 6. Total original = suma de precios sin descuentos (para referencia en reportes)
        $totalPrincipalOriginal = (float) ($servPrincipal ? ($servPrincipal->serv_precio ?? 0) : 0);
        $totalExtrasOriginal    = $factura->detalles->whereNotNull('serv_id')
            ->where('serv_id', '!=', $factura->turno->serv_id ?? 0)
            ->sum('precio_original');
        $totalProductosOriginal = $factura->detalles->whereNotNull('pro_id')
            ->sum(fn($d) => ($d->precio_original ?? $d->facdet_precio_unitario) * ($d->facdet_cantidad ?? 1));
        $totalOriginal = $totalPrincipalOriginal + $totalExtrasOriginal + $totalProductosOriginal;

        $factura->fac_total                = $totalOriginal;
        $factura->fac_total_con_descuento  = $totalConDescuento;
        $factura->save();
    }
}