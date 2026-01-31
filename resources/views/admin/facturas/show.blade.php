@extends('admin.layout')
    
@section('content')
@vite(['resources/css/Admin/factura/show.css'])
<div class="facturas-container" id="modulo-factura-show">
    <div class="factura-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;gap:1.5rem;">
        <h2 style="margin:0;">Detalle de Factura #{{ $factura->fac_id }}</h2>
        <a href="{{ route('factura.index') }}" class="btn-volver-factura" aria-label="Volver al listado de facturas">&larr; Volver al listado</a>
    </div>
    <div class="factura-detalle">
        <p><strong>Cliente:</strong> {{ $factura->turno->tur_nombre ?? '' }}</p>
        <p><strong>Cédula:</strong> {{ $factura->turno->tur_cedula ?? '' }}</p>
        <p><strong>Barbero:</strong> {{ $factura->turno->disponibilidad->persona->per_nombre ?? '' }} {{ $factura->turno->disponibilidad->persona->per_apellido ?? '' }}</p>
        <p><strong>Fecha:</strong>
            <span aria-describedby="fecha-factura-show-{{ $factura->fac_id }}">{{ $factura->fac_fecha }}</span>
            <span id="fecha-factura-show-{{ $factura->fac_id }}" class="sr-only">
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
                </tr>
            </thead>
            <tbody>
                @foreach($factura->detalles as $detalle)
                <tr>
                    <td data-label="Servicio">{{ $detalle->servicios->serv_nombre ?? '' }}</td>
                    <td data-label="Valor original">${{ number_format($detalle->servicios->serv_precio ?? $detalle->serv_precio,2) }}</td>
                    <td data-label="Descuento (%)">{{ $detalle->servicios->serv_descuento ?? 0 }}%</td>
                    <td data-label="Valor final">${{ number_format($detalle->serv_precio,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
        <p><strong>Saldo:</strong> ${{ number_format($factura->fac_total - $factura->fac_abono,2) }}</p>
    </div>
<script>
// Navegación accesible para el detalle de factura (show)
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('modulo-factura-show');
    if (!container) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(container.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;

    // Focus inicial en el primer elemento interactivo visible
    setTimeout(() => { focusables[0].focus(); }, 100);

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
        } else if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
            e.preventDefault();
            focusables[(idx + 1) % focusables.length].focus();
        } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
            e.preventDefault();
            focusables[(idx - 1 + focusables.length) % focusables.length].focus();
        } else if (e.key === 'Escape') {
            // Redirigir a la lista de facturas o enfocar menú
            const menu = document.querySelector('.sidebar a, nav a');
            if (menu) {
                menu.focus();
            } else {
                window.location.href = '/admin/facturas';
            }
        }
    });
});
</script>
<script>
// Volver al index de facturas al presionar Escape
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.location.href = "{{ route('factura.index') }}";
        }
    });
});
</script>
</div>
@endsection
