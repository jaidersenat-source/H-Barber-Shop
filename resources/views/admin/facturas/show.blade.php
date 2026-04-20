@php
if (!function_exists('convertir_a_texto')) {
    function convertir_a_texto($valor) {
        $valor = round($valor);
        if ($valor >= 1000000) {
            return number_format($valor / 1000000, 1) . ' millones';
        } elseif ($valor >= 1000) {
            return number_format($valor / 1000, 0) . ' mil';
        } else {
            return $valor;
        }
    }
}
@endphp
@extends('admin.layout')

@section('content')

@vite(['resources/css/Admin/factura/show.css'])

<main class="facturas-container" id="modulo-factura-show" aria-labelledby="titulo-factura">

    <div class="factura-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;gap:1.5rem;">
        <h1 id="titulo-factura" style="margin:0;font-size:1.5rem;">
            Detalle de Factura número {{ $factura->fac_id }}
        </h1>
        <a href="{{ route('factura.index') }}" class="btn-volver-factura" aria-label="Volver al listado de facturas">
            &larr; Volver al listado
        </a>
    </div>

    {{-- ============================================================
         DATOS GENERALES
         ============================================================ --}}
    <section aria-labelledby="titulo-datos-generales">
        <h2 id="titulo-datos-generales" class="sr-only">Datos generales de la factura</h2>
        <dl class="factura-detalle">
            <div>
                <dt><strong>Cliente</strong></dt>
                <dd>{{ $factura->turno->tur_nombre ?? '' }}</dd>
            </div>
            <div>
                <dt><strong>Cédula</strong></dt>
                <dd>{{ $factura->turno->tur_cedula ?? '' }}</dd>
            </div>
            <div>
                <dt><strong>Barbero</strong></dt>
                <dd>
                    {{ $factura->turno->disponibilidad->persona->per_nombre ?? '' }}
                    {{ $factura->turno->disponibilidad->persona->per_apellido ?? '' }}
                </dd>
            </div>
            <div>
                <dt><strong>Fecha</strong></dt>
                <dd>{{ \Carbon\Carbon::parse($factura->fac_fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}</dd>
            </div>
            <div>
                <dt><strong>Sede</strong></dt>
                <dd>{{ $factura->sede->sede_nombre ?? '' }}</dd>
            </div>
        </dl>
    </section>

    <hr aria-hidden="true">

    {{-- ============================================================
         SECCIÓN DE SERVICIOS
         ============================================================ --}}
    @php
        $detallesServicios = $factura->detalles->filter(fn($d) => !is_null($d->serv_id) && $d->serv_id != $factura->turno->serv_id);
        $detallesProductos = $factura->detalles->filter(fn($d) => !is_null($d->pro_id));

        $precioServPrincipal = $factura->turno->servicio->serv_precio ?? 0;
        $descServPrincipal   = $factura->turno->servicio->serv_descuento ?? 0;
        $finalServPrincipal  = $precioServPrincipal * (1 - $descServPrincipal / 100);
    @endphp

    <section aria-labelledby="titulo-servicios">
        <h2 id="titulo-servicios">Servicios facturados</h2>

        {{-- Lista accesible (JAWS) --}}
        <ul aria-label="Servicios facturados detallados" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
            <li>
                <span>Servicio principal: {{ $factura->turno->servicio->serv_nombre ?? '' }}.</span>
                <span>Valor original: {{ convertir_a_texto($precioServPrincipal) }} pesos.</span>
                <span>Descuento: {{ $descServPrincipal }} por ciento.</span>
                <span>Valor final: {{ convertir_a_texto($finalServPrincipal) }} pesos.</span>
            </li>
            @foreach($detallesServicios as $detalle)
            @php
                $precioOrigDetalle = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                $descDetalle       = $detalle->servicios->serv_descuento ?? 0;
            @endphp
            <li>
                <span>Servicio extra: {{ $detalle->servicios->serv_nombre ?? '' }}.</span>
                <span>Valor original: {{ convertir_a_texto($precioOrigDetalle) }} pesos.</span>
                <span>Descuento: {{ $descDetalle }} por ciento.</span>
                <span>Valor final: {{ convertir_a_texto($detalle->serv_precio) }} pesos.</span>
            </li>
            @endforeach
        </ul>

        {{-- Tabla visual (aria-hidden) --}}
        <div class="facturas-table-wrapper" aria-hidden="true">
            <table class="facturas-table" role="presentation">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Valor original</th>
                        <th>Descuento (%)</th>
                        <th>Valor final</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Servicio">{{ $factura->turno->servicio->serv_nombre ?? '' }}</td>
                        <td data-label="Valor original">${{ number_format($precioServPrincipal, 2) }}</td>
                        <td data-label="Descuento (%)">{{ $descServPrincipal }}%</td>
                        <td data-label="Valor final">${{ number_format($finalServPrincipal, 2) }}</td>
                    </tr>
                    @foreach($detallesServicios as $detalle)
                    @php
                        $precioOrigDetalle = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                        $descDetalle       = $detalle->servicios->serv_descuento ?? 0;
                    @endphp
                    <tr>
                        <td data-label="Servicio">{{ $detalle->servicios->serv_nombre ?? '' }}</td>
                        <td data-label="Valor original">${{ number_format($precioOrigDetalle, 2) }}</td>
                        <td data-label="Descuento (%)">{{ $descDetalle }}%</td>
                        <td data-label="Valor final">${{ number_format($detalle->serv_precio, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <hr aria-hidden="true">

    {{-- ============================================================
         SECCIÓN DE PRODUCTOS
         ============================================================ --}}
    <section aria-labelledby="titulo-productos">
        <h2 id="titulo-productos">Productos adquiridos</h2>

        @if($detallesProductos->count() > 0)

            {{-- Lista accesible (JAWS) --}}
            <ul aria-label="Productos adquiridos detallados" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
                @foreach($detallesProductos as $detProd)
                <li>
                    <span>Producto: {{ $detProd->facdet_descripcion }}.</span>
                    <span>Cantidad: {{ $detProd->facdet_cantidad }}.</span>
                    <span>Precio unitario: {{ convertir_a_texto($detProd->facdet_precio_unitario) }} pesos.</span>
                    <span>Subtotal: {{ convertir_a_texto($detProd->facdet_subtotal) }} pesos.</span>
                </li>
                @endforeach
            </ul>

            {{-- Tabla visual (aria-hidden) --}}
            <div class="facturas-table-wrapper" aria-hidden="true">
                <table class="facturas-table" role="presentation">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detallesProductos as $detProd)
                        <tr>
                            <td data-label="Producto">{{ $detProd->facdet_descripcion }}</td>
                            <td data-label="Cantidad">{{ $detProd->facdet_cantidad }}</td>
                            <td data-label="Precio unitario">${{ number_format($detProd->facdet_precio_unitario, 2) }}</td>
                            <td data-label="Subtotal">${{ number_format($detProd->facdet_subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <p style="color:#666;font-style:italic;">No se adquirieron productos en esta factura.</p>
        @endif
    </section>

    <hr aria-hidden="true">

    {{-- ============================================================
         RESUMEN
         ============================================================ --}}
    <section aria-labelledby="titulo-resumen">
        <h2 id="titulo-resumen">Resumen de la factura</h2>

        @php
            $subtotal              = $precioServPrincipal;
            $totalDescuento        = $precioServPrincipal * ($descServPrincipal / 100);
            $porcentajeTotal       = $descServPrincipal;
            $serviciosConDescuento = $descServPrincipal > 0 ? 1 : 0;

            foreach ($detallesServicios as $detalle) {
                $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                $descuento      = $detalle->servicios->serv_descuento ?? 0;
                $subtotal      += $precioOriginal;
                $totalDescuento += ($precioOriginal - $detalle->serv_precio);
                if ($descuento > 0) {
                    $porcentajeTotal += $descuento;
                    $serviciosConDescuento++;
                }
            }

            $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
            $subtotalServicios  = $subtotal - $totalDescuento;
            $totalProductos     = $detallesProductos->sum('facdet_subtotal');
            $totalFinal         = $subtotalServicios + $totalProductos;
            $abono              = $factura->fac_abono > 0 ? $factura->fac_abono : ($factura->turno->tur_anticipo ?? 0);
            $saldo              = $totalFinal - $abono;
        @endphp

        <dl class="factura-resumen">
            <div>
                <dt><strong>Subtotal servicios</strong></dt>
                <dd>
                    <span aria-hidden="true">${{ number_format($subtotalServicios, 2) }}</span>
                    <span class="sr-only">{{ convertir_a_texto($subtotalServicios) }} pesos</span>
                </dd>
            </div>

            <div>
                <dt><strong>Descuento promedio aplicado</strong></dt>
                <dd>{{ number_format($porcentajePromedio, 2) }} por ciento</dd>
            </div>

            @if($totalProductos > 0)
            <div>
                <dt><strong>Subtotal productos</strong></dt>
                <dd>
                    <span aria-hidden="true">${{ number_format($totalProductos, 2) }}</span>
                    <span class="sr-only">{{ convertir_a_texto($totalProductos) }} pesos</span>
                </dd>
            </div>
            @endif

            <div>
                <dt><strong>Total factura</strong></dt>
                <dd>
                    <span aria-hidden="true">${{ number_format($totalFinal, 2) }}</span>
                    <span class="sr-only">{{ convertir_a_texto($totalFinal) }} pesos</span>
                </dd>
            </div>

            <div>
                <dt><strong>Abono</strong></dt>
                <dd>
                    <span aria-hidden="true">${{ number_format($abono, 2) }}</span>
                    <span class="sr-only">{{ convertir_a_texto($abono) }} pesos</span>
                </dd>
            </div>

            <div>
                <dt><strong>Saldo pendiente</strong></dt>
                <dd>
                    <span aria-hidden="true">${{ number_format($saldo, 2) }}</span>
                    <span class="sr-only">{{ convertir_a_texto($saldo) }} pesos</span>
                </dd>
            </div>
        </dl>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                window.location.href = "{{ route('factura.index') }}";
            }
        });
    });
    </script>

</main>

@endsection