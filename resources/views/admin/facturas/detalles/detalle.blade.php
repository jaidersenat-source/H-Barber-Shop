@extends('admin.layout')

@vite(['resources/css/Admin/factura/detalle.css'])
@section('content')
<div class="facturas-container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <h2 style="margin:0;">Detalle de Factura #{{ $factura->fac_id }}</h2>
        <a href="{{ route('factura.index') }}" class="btn btn-secondary" aria-label="Volver al listado de facturas">Volver al listado</a>
    </div>
    <div class="factura-detalle">
        <p><strong>Cliente:</strong> {{ $factura->turno->tur_nombre ?? '' }}</p>
        <p><strong>Cédula:</strong> {{ $factura->turno->tur_cedula ?? '' }}</p>
        <p><strong>Fecha:</strong>
            <span aria-describedby="fecha-factura-detalle-{{ $factura->fac_id }}">{{ $factura->fac_fecha }}</span>
            <span id="fecha-factura-detalle-{{ $factura->fac_id }}" class="sr-only">
                {{ \Carbon\Carbon::parse($factura->fac_fecha)->isoFormat('D [de] MMMM [de] YYYY') }}
            </span>
        </p>
        <p><strong>Sede:</strong> {{ $factura->sede->sede_nombre ?? '' }}</p>
    </div>
    <hr>
    <h4>Servicios facturados</h4>
    <div class="facturas-table-wrapper">
        <table class="facturas-table" role="table" aria-label="Servicios facturados">
            <thead>
                <tr>
                    <th scope="col">Servicio</th>
                    <th scope="col">Valor original</th>
                    <th scope="col">Descuento (%)</th>
                    <th scope="col">Valor final</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura->detalles as $detalle)
                <tr>
                    <td data-label="Servicio">{{ $detalle->servicios->serv_nombre ?? '' }}</td>
                    <td data-label="Valor original">${{ number_format($detalle->servicios->serv_precio ?? $detalle->serv_precio,2) }}</td>
                    <td data-label="Descuento (%)">{{ $detalle->servicios->serv_descuento ?? 0 }}%</td>
                    <td data-label="Valor final">${{ number_format($detalle->serv_precio,2) }}</td>
                    <td class="acciones" data-label="Acciones">
                        <form action="{{ route('facturadetalle.destroy', $detalle->facdet_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" aria-label="Eliminar servicio {{ $detalle->servicios->serv_nombre ?? '' }}">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <hr>
    <h4>Agregar servicio extra</h4>
    <form action="{{ route('facturadetalle.store', $factura->fac_id) }}" method="POST" class="facturas-form" aria-label="Agregar servicio extra">
        @csrf
        <div class="form-group">
            <label for="serv_id">Servicio</label>
            <select name="serv_id" id="serv_id" class="form-control" required onchange="actualizarPrecio()">
                <option value="">Seleccione...</option>
                @foreach(App\Models\Servicio::where('serv_estado','activo')->get() as $servicios)
                    <option value="{{ $servicios->serv_id }}" data-precio="{{ $servicios->serv_precio }}">{{ $servicios->serv_nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="serv_precio">Valor</label>
            <input type="number" step="0.01" name="serv_precio" id="serv_precio" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success" aria-label="Agregar servicio">Agregar</button>
    </form>
    <script>
    function actualizarPrecio() {
        var select = document.getElementById('serv_id');
        var precio = select.options[select.selectedIndex].getAttribute('data-precio');
        document.getElementById('serv_precio').value = precio ? precio : '';
    }
    </script>
    <hr>
    <h4>Resumen</h4>
    @php
        $subtotal = 0;
        $totalDescuento = 0;
        $porcentajeTotal = 0;
        $serviciosConDescuento = 0;
        foreach($factura->detalles as $detalle) {
            $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
            $descuento = $detalle->servicios->serv_descuento ?? 0;
            $subtotal += $precioOriginal;
            $totalDescuento += ($precioOriginal - $detalle->serv_precio);
            if($descuento > 0) {
                $porcentajeTotal += $descuento;
                $serviciosConDescuento++;
            }
        }
        $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
        $totalFinal = $subtotal - $totalDescuento;
    @endphp
    <div class="factura-resumen">
        <p><strong>Subtotal:</strong> ${{ number_format($subtotal,2) }}</p>
        <p><strong>Descuento promedio aplicado:</strong> {{ number_format($porcentajePromedio,2) }}%</p>
        <p><strong>Valor final con descuento:</strong> ${{ number_format($totalFinal,2) }}</p>
        <p><strong>Abono:</strong> ${{ number_format($factura->fac_abono,2) }}</p>
        <p style="font-size:18px;font-weight:bold;color:#1a7f37;">Total a pagar: ${{ number_format($factura->fac_total - $factura->fac_abono,2) }}</p>
        <div style="margin-top:10px;">
            <a href="{{ route('facturas.pdf', $factura->fac_id) }}" class="btn btn-success" target="_blank" aria-label="Descargar PDF de la factura">Guardar y descargar</a>
        </div>
    </div>
</div>
@endsection
<script>
// Navegación accesible para el detalle de factura
document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.facturas-container');
    if (!container) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(container.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;

    // Focus inicial en el primer campo interactivo
    focusables[0].focus();

    container.addEventListener('keydown', function (e) {
        const idx = focusables.indexOf(document.activeElement);
        if (e.key === 'Tab') {
            // Focus trap
            if (e.shiftKey && document.activeElement === focusables[0]) {
                e.preventDefault();
                focusables[focusables.length - 1].focus();
            } else if (!e.shiftKey && document.activeElement === focusables[focusables.length - 1]) {
                e.preventDefault();
                focusables[0].focus();
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            focusables[(idx + 1) % focusables.length].focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            focusables[(idx - 1 + focusables.length) % focusables.length].focus();
        } else if (e.key === 'Escape') {
            // Redirigir a la lista de facturas
            window.location.href = '/admin/facturas';
        }
    });
});
</script>
