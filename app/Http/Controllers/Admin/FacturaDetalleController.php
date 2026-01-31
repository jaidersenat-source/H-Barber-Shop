<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\FacturaDetalle;
use App\Models\Servicio;
use Illuminate\Http\Request;

class FacturaDetalleController extends Controller
{
    // Agregar servicio a una factura
    public function store(Request $request, $fac_id)
    {
        $request->validate([
            'serv_id' => 'required|exists:servicios,serv_id',
        ]);

        $servicio = \App\Models\Servicio::findOrFail($request->serv_id);
        $precioFinal = $servicio->serv_precio * (1 - ($servicio->serv_descuento ?? 0)/100);

        FacturaDetalle::create([
            'fac_id' => $fac_id,
            'serv_id' => $servicio->serv_id,
            'serv_precio' => $precioFinal,
            'serv_nombre' => $servicio->serv_nombre,
        ]);

        // Actualizar total de la factura
        $factura = Factura::findOrFail($fac_id);
        $factura->fac_total = $factura->detalles()->sum('serv_precio');
        $factura->save();

        return redirect()->route('facturas.detalle', $fac_id)
            ->with('ok', 'Servicio agregado a la factura.');
    }

    // Eliminar un detalle de factura
    public function destroy($facdet_id)
    {
        $detalle = FacturaDetalle::findOrFail($facdet_id);
        $fac_id = $detalle->fac_id;
        $detalle->delete();

        // Actualizar total de la factura
        $factura = Factura::findOrFail($fac_id);
        $factura->fac_total = $factura->detalles()->sum('serv_precio');
        $factura->save();

        return redirect()->route('facturas.detalle', $fac_id)
            ->with('ok', 'Detalle eliminado.');
    }
}
