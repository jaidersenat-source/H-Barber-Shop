@extends('admin.layout')

@vite(['resources/css/Admin/factura/detalle.css'])
@section('content')

@php
    $servPrincipal   = $factura->turno->servicio;
    $precioPrincipal = (float)($servPrincipal->serv_precio ?? 0);
    $descPrincipal   = (float)($servPrincipal->serv_descuento ?? 0);

    // Descuentos de membresía
    $membresiaDescuentoPrincipal = (float)($factura->membresia_descuento ?? 0);
    $membresiaDescuentoExtras    = $factura->detalles->whereNotNull('serv_id')->sum('descuento_membresia');
    $totalDescuentoMembresia     = $membresiaDescuentoPrincipal + $membresiaDescuentoExtras;

    // Precio final del servicio principal (descuento de servicio + membresía)
    $finalPrincipal = max(0, $precioPrincipal * (1 - $descPrincipal / 100) - $membresiaDescuentoPrincipal);

    // Subtotal de servicios (para el resumen)
    $subtotalServicios = $finalPrincipal + $factura->detalles
        ->whereNotNull('serv_id')
        ->where('serv_id', '!=', $factura->turno->serv_id)
        ->sum('serv_precio');

    // Productos
    $productosDetalles = $factura->detalles->whereNotNull('pro_id');
    $totalProductos    = $productosDetalles->sum('facdet_subtotal');

    // Usar fac_total como fuente de verdad (calculado en el servidor)
    $totalFinal = $factura->fac_total;
    $abono      = $factura->fac_abono > 0 ? $factura->fac_abono : ($factura->turno->tur_anticipo ?? 0);
    $saldo      = $totalFinal - $abono;
@endphp

<main class="facturas-container" aria-labelledby="titulo-detalle">

    {{-- ══ ENCABEZADO ══ --}}
    <div class="factura-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <h1 id="titulo-detalle" style="margin:0;">Factura número {{ $factura->fac_id }}</h1>
        <a href="{{ route('factura.index') }}"
           class="btn btn-secondary"
           aria-label="Volver al listado de facturas sin guardar cambios">
            Volver al listado
        </a>
    </div>

    {{-- Mensajes de sesión --}}
    @if(session('ok'))
        <div role="alert" aria-live="polite" aria-atomic="true"
             style="background:#d1fae5;border-left:4px solid #10b981;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-weight:600;color:#065f46;">
            {{ session('ok') }}
        </div>
    @endif

    @if($errors->any())
        <div role="alert" aria-live="assertive" aria-atomic="true"
             style="background:#fee2e2;border-left:4px solid #ef4444;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;font-weight:600;color:#991b1b;">
            @foreach($errors->all() as $error)
                <p style="margin:0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- ══ DATOS GENERALES ══ --}}
    <section aria-labelledby="titulo-datos">
        <h2 id="titulo-datos" class="sr-only">Datos generales de la factura</h2>
        <dl class="factura-detalle">
            <div><dt><strong>Cliente</strong></dt>   <dd>{{ $factura->turno->tur_nombre ?? '—' }}</dd></div>
            <div><dt><strong>Cédula</strong></dt>    <dd>{{ $factura->turno->tur_cedula ?? '—' }}</dd></div>
            <div>
                <dt><strong>Fecha</strong></dt>
                <dd>
                    <span aria-hidden="true">{{ \Carbon\Carbon::parse($factura->fac_fecha)->format('d/m/Y H:i') }}</span>
                    <span class="sr-only">{{ \Carbon\Carbon::parse($factura->fac_fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}</span>
                </dd>
            </div>
            <div><dt><strong>Sede</strong></dt>      <dd>{{ $factura->sede->sede_nombre ?? '—' }}</dd></div>
        </dl>
    </section>

    <hr aria-hidden="true">

    {{-- ══ SERVICIO PRINCIPAL ══ --}}
    <section aria-labelledby="titulo-principal">
        <h2 id="titulo-principal">Servicio principal</h2>

        <ul aria-label="Servicio principal de la factura" class="sr-only">
            <li>
                <span>Servicio: {{ $factura->turno->servicio->serv_nombre ?? '—' }}.</span>
                <span>Valor original: {{ number_format($precioPrincipal, 0, ',', '.') }} pesos colombianos.</span>
                <span>Descuento de servicio: {{ $descPrincipal }}%.</span>
                @if($membresiaDescuentoPrincipal > 0)
                <span>Descuento por membresía: {{ number_format($membresiaDescuentoPrincipal, 0, ',', '.') }} pesos colombianos.</span>
                @endif
                <span>Valor final: {{ number_format($finalPrincipal, 0, ',', '.') }} pesos colombianos.</span>
            </li>
        </ul>

        <div class="facturas-table-wrapper" aria-hidden="true">
            <table class="facturas-table" role="presentation">
                <thead>
                    <tr>
                        <th>Servicio</th><th>Valor original</th><th>Descuento</th><th>Valor final</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Servicio">{{ $factura->turno->servicio->serv_nombre ?? '—' }}</td>
                        <td data-label="Valor original">${{ number_format($precioPrincipal, 0, ',', '.') }}</td>
                        <td data-label="Descuento">
                            @if($membresiaDescuentoPrincipal > 0)
                                <span style="color:#065f46;font-weight:600;">Membresía<br>-${{ number_format($membresiaDescuentoPrincipal, 0, ',', '.') }}</span>
                            @else
                                {{ $descPrincipal }}%
                            @endif
                        </td>
                        <td data-label="Valor final">${{ number_format($finalPrincipal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if($membresiaDescuentoPrincipal > 0)
        <p role="status" aria-live="polite"
           style="margin-top:0.5rem;color:#065f46;background:#d1fae5;border-left:4px solid #10b981;padding:0.5rem 0.75rem;border-radius:0 4px 4px 0;font-size:0.95rem;">
            <strong>★ Membresía aplicada:</strong>
            descuento de ${{ number_format($membresiaDescuentoPrincipal, 0, ',', '.') }} sobre este servicio.
        </p>
        @endif
    </section>

    <hr aria-hidden="true">

    {{-- ══ SERVICIOS EXTRA ══ --}}
    <section aria-labelledby="titulo-extras">
        <h2 id="titulo-extras">Servicios extra agregados</h2>

        <ul aria-label="Servicios extra de la factura" aria-live="polite" class="sr-only">
            @forelse($factura->detalles->where('serv_id', '!=', $factura->turno->serv_id)->whereNotNull('serv_id') as $detalle)
                @php
                    $precioOrigExtra  = $detalle->precio_original ?? ($detalle->servicios->serv_precio ?? $detalle->serv_precio);
                    $descExtra        = $detalle->servicios->serv_descuento ?? 0;
                    $nombreExtra      = $detalle->servicios->serv_nombre ?? '—';
                    $descMemExtra     = (float)($detalle->descuento_membresia ?? 0);
                @endphp
                <li style="background:#f3f4f6;border-left:4px solid #DC2626;border-radius:6px;padding:1rem 1.25rem;margin-bottom:0.75rem;line-height:1.9;">
                    <span style="display:block;">Servicio extra: {{ $nombreExtra }}.</span>
                    <span style="display:block;">Valor original: {{ number_format($precioOrigExtra, 0, ',', '.') }} pesos colombianos.</span>
                    @if($descMemExtra > 0)
                    <span style="display:block;">Descuento membresía: {{ number_format($descMemExtra, 0, ',', '.') }} pesos colombianos.</span>
                    @else
                    <span style="display:block;">Descuento: {{ $descExtra }} por ciento.</span>
                    @endif
                    <span style="display:block;">Valor final: {{ number_format($detalle->serv_precio, 0, ',', '.') }} pesos colombianos.</span>

                    <form action="{{ route('facturadetalle.destroy', $detalle->facdet_id) }}"
                          method="POST" style="margin-top:0.5rem;"
                          aria-label="Eliminar {{ $nombreExtra }} de la factura">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                aria-label="Eliminar servicio {{ $nombreExtra }}"
                                onclick="return confirm('¿Eliminar {{ $nombreExtra }} de la factura?')">
                            Eliminar
                        </button>
                    </form>
                </li>
            @empty
                <li style="color:#666;font-style:italic;padding:0.5rem 0;">
                    No se han agregado servicios extra aún.
                </li>
            @endforelse
        </ul>

        @if($factura->detalles->where('serv_id', '!=', $factura->turno->serv_id)->whereNotNull('serv_id')->count() > 0)
        <div class="facturas-table-wrapper" aria-hidden="true">
            <table class="facturas-table" role="presentation">
                <thead>
                    <tr>
                        <th>Servicio</th><th>Valor original</th><th>Descuento (%)</th><th>Valor final</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles->where('serv_id', '!=', $factura->turno->serv_id)->whereNotNull('serv_id') as $detalle)
                    @php
                        $precioOrigExtra = $detalle->precio_original ?? ($detalle->servicios->serv_precio ?? $detalle->serv_precio);
                        $descMemExtra    = (float)($detalle->descuento_membresia ?? 0);
                    @endphp
                    <tr>
                        <td data-label="Servicio">
                            {{ $detalle->servicios->serv_nombre ?? '—' }}
                            @if($descMemExtra > 0)
                                <br><small style="color:#065f46;font-weight:600;">★ Membresía</small>
                            @endif
                        </td>
                        <td data-label="Valor original">${{ number_format($precioOrigExtra, 0, ',', '.') }}</td>
                        <td data-label="Descuento">
                            @if($descMemExtra > 0)
                                <span style="color:#065f46;font-weight:600;">-${{ number_format($descMemExtra, 0, ',', '.') }}</span>
                            @else
                                {{ $detalle->servicios->serv_descuento ?? 0 }}%
                            @endif
                        </td>
                        <td data-label="Valor final">${{ number_format($detalle->serv_precio, 0, ',', '.') }}</td>
                        <td class="acciones" data-label="Acciones">
                            <form action="{{ route('facturadetalle.destroy', $detalle->facdet_id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar este servicio?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </section>

    <hr aria-hidden="true">

    {{-- ══ AGREGAR SERVICIO EXTRA ══ --}}
    <section aria-labelledby="titulo-agregar">
        <h2 id="titulo-agregar">Agregar servicio extra</h2>
        <p id="agregar-desc" style="color:#555;font-size:0.95rem;margin:0 0 1rem;">
            Seleccione un servicio. El resumen se actualizará de inmediato para previsualizar
            el nuevo total antes de guardar.
        </p>

        <form action="{{ route('facturadetalle.store', $factura->fac_id) }}"
              method="POST" class="facturas-form" aria-describedby="agregar-desc" novalidate>
            @csrf
            <div class="form-group">
                <label for="serv_id">
                    Servicio a agregar <span aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <select name="serv_id" id="serv_id" class="form-control" required
                        aria-required="true" aria-describedby="serv-hint"
                        data-final-principal="{{ $finalPrincipal }}"
                        data-subtotal-extras="{{ $factura->detalles->where('serv_id', '!=', $factura->turno->serv_id)->whereNotNull('serv_id')->sum('serv_precio') }}"
                        data-total-productos="{{ $totalProductos }}"
                        data-abono="{{ $abono }}">
                    <option value="" data-precio="0">Seleccione un servicio...</option>
                    @foreach(App\Models\Servicio::where('serv_estado', 'activo')->orderBy('serv_nombre')->get() as $srv)
                        @php $precioFinalSrv = $srv->serv_precio * (1 - ($srv->serv_descuento ?? 0) / 100); @endphp
                        <option value="{{ $srv->serv_id }}"
                                data-precio="{{ $precioFinalSrv }}"
                                data-nombre="{{ $srv->serv_nombre }}"
                                data-original="{{ $srv->serv_precio }}"
                                data-descuento="{{ $srv->serv_descuento ?? 0 }}">
                            {{ $srv->serv_nombre }}
                            — ${{ number_format($srv->serv_precio, 0, ',', '.') }}
                            @if(($srv->serv_descuento ?? 0) > 0)
                                ({{ $srv->serv_descuento }}% desc. → ${{ number_format($precioFinalSrv, 0, ',', '.') }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <span id="serv-hint" class="sr-only">Al seleccionar, el resumen mostrará el nuevo total antes de guardar.</span>
            </div>

            <div id="preview-servicio" hidden aria-live="polite" aria-atomic="true"
                 style="background:#f3f4f6;border-left:4px solid #DC2626;border-radius:6px;padding:0.75rem 1rem;margin-bottom:1rem;font-size:0.95rem;line-height:1.8;">
                <strong>Vista previa del servicio seleccionado:</strong>
                <span id="prev-nombre" style="display:block;"></span>
                <span id="prev-detalle" style="display:block;"></span>
                <em style="font-size:0.85rem;color:#666;">Este valor aún no está guardado.</em>
            </div>

            <button type="submit" class="btn btn-success" aria-label="Agregar servicio seleccionado a la factura">
                Agregar servicio
            </button>
        </form>
    </section>

    <hr aria-hidden="true">

    {{-- ══ PRODUCTOS AGREGADOS ══ --}}
    <section aria-labelledby="titulo-productos">
        <h2 id="titulo-productos">Productos agregados</h2>

        <ul aria-label="Productos agregados a la factura" aria-live="polite" class="sr-only">
            @forelse($productosDetalles as $detProd)
                <li style="background:#f3f4f6;border-left:4px solid #2563eb;border-radius:6px;padding:1rem 1.25rem;margin-bottom:0.75rem;line-height:1.9;">
                    <span style="display:block;">Producto: {{ $detProd->facdet_descripcion }}.</span>
                    @php
                        $precioOrig = (float)($detProd->precio_original ?? 0);
                        $descProd = (float)($detProd->descuento_membresia ?? 0);
                    @endphp
                    @if($descProd > 0)
                        <span style="display:block;color:#065f46;font-weight:700;">Descuento aplicado: -${{ number_format($descProd * $detProd->facdet_cantidad, 0, ',', '.') }} ({{ $precioOrig > 0 ? round(($descProd / $precioOrig) * 100, 2) : 0 }}%)</span>
                    @endif
                    <span style="display:block;">Cantidad: {{ $detProd->facdet_cantidad }}.</span>
                    @php $precioOrig = (float)($detProd->precio_original ?? 0); $precioFinal = (float)$detProd->facdet_precio_unitario; @endphp
                    <span style="display:block;">Precio original: ${{ number_format($precioOrig > 0 ? $precioOrig : $precioFinal, 0, ',', '.') }} pesos colombianos.</span>
                    @if($precioOrig > 0 && $precioOrig != $precioFinal)
                        <span style="display:block;color:#92400e;">Precio con descuento: <strong>${{ number_format($precioFinal, 0, ',', '.') }}</strong></span>
                    @endif
                    <span style="display:block;">Subtotal: {{ number_format($detProd->facdet_subtotal, 0, ',', '.') }} pesos colombianos.</span>

                    <form action="{{ route('facturadetalle.destroy', $detProd->facdet_id) }}"
                          method="POST" style="margin-top:0.5rem;"
                          aria-label="Eliminar {{ $detProd->facdet_descripcion }} de la factura">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                aria-label="Eliminar producto {{ $detProd->facdet_descripcion }}"
                                onclick="return confirm('¿Eliminar {{ $detProd->facdet_descripcion }} de la factura? Se restaurará el stock.')">
                            Eliminar
                        </button>
                    </form>
                </li>
            @empty
                <li style="color:#666;font-style:italic;padding:0.5rem 0;">
                    No se han agregado productos aún.
                </li>
            @endforelse
        </ul>

        @if($productosDetalles->count() > 0)
        <div class="facturas-table-wrapper" aria-hidden="true">
            <table class="facturas-table" role="presentation">
                <thead>
                    <tr>
                        <th>Producto</th><th>Cantidad</th><th>Precio unitario</th><th>Subtotal</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productosDetalles as $detProd)
                    <tr>
                        <td data-label="Producto">
                            {{ $detProd->facdet_descripcion }}
                            @php $descProd = (float)($detProd->descuento_membresia ?? 0); $precioOrig = (float)($detProd->precio_original ?? 0); @endphp
                            @if($descProd > 0)
                                <br><small style="color:#065f46;font-weight:600;">-${{ number_format($descProd * $detProd->facdet_cantidad, 0, ',', '.') }} ({{ $precioOrig > 0 ? round(($descProd / $precioOrig) * 100, 2) : 0 }}%)</small>
                            @endif
                        </td>
                        <td data-label="Cantidad">{{ $detProd->facdet_cantidad }}</td>
                        @php $precioOrig = (float)($detProd->precio_original ?? 0); $precioFinal = (float)$detProd->facdet_precio_unitario; @endphp
                        <td data-label="Precio unitario">
                            ${{ number_format($precioOrig > 0 ? $precioOrig : $precioFinal, 0, ',', '.') }}
                            @if($precioOrig > 0 && $precioOrig != $precioFinal)
                                <br><small style="color:#92400e;">Final: ${{ number_format($precioFinal, 0, ',', '.') }}</small>
                            @endif
                        </td>
                        <td data-label="Subtotal">${{ number_format($detProd->facdet_subtotal, 0, ',', '.') }}</td>
                        <td class="acciones" data-label="Acciones">
                            <form action="{{ route('facturadetalle.destroy', $detProd->facdet_id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar este producto? Se restaurará el stock.')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </section>

    <hr aria-hidden="true">

    {{-- ══ AGREGAR PRODUCTO ══ --}}
    <section aria-labelledby="titulo-agregar-prod">
        <h2 id="titulo-agregar-prod">Agregar producto</h2>
        <p id="agregar-prod-desc" style="color:#555;font-size:0.95rem;margin:0 0 1rem;">
            Seleccione un producto e indique la cantidad. El stock se descontará automáticamente.
        </p>

        <form action="{{ route('facturadetalle.storeProducto', $factura->fac_id) }}"
              method="POST" class="facturas-form" aria-describedby="agregar-prod-desc" novalidate>
            @csrf
            <div style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end;">
                <div class="form-group" style="flex:2;min-width:200px;">
                    <label for="pro_id">
                        Producto <span aria-hidden="true">*</span>
                        <span class="sr-only">(obligatorio)</span>
                    </label>
                    <select name="pro_id" id="pro_id" class="form-control" required aria-required="true">
                        <option value="" data-precio="0" data-stock="0">Seleccione un producto...</option>
                        @foreach(App\Models\Producto::where('pro_estado', 'activo')->where('pro_stock', '>', 0)->orderBy('pro_nombre')->get() as $prod)
                            @php $precioFinalProd = $prod->pro_precio * (1 - ($prod->pro_descuento ?? 0) / 100); @endphp
                            <option value="{{ $prod->pro_id }}"
                                    data-precio="{{ $precioFinalProd }}"
                                    data-nombre="{{ $prod->pro_nombre }}"
                                    data-original="{{ $prod->pro_precio }}"
                                    data-descuento="{{ $prod->pro_descuento ?? 0 }}"
                                    data-stock="{{ $prod->pro_stock }}">
                                {{ $prod->pro_nombre }}
                                — ${{ number_format($prod->pro_precio, 0, ',', '.') }}
                                @if(($prod->pro_descuento ?? 0) > 0)
                                    ({{ $prod->pro_descuento }}% desc. → ${{ number_format($precioFinalProd, 0, ',', '.') }})
                                @endif
                                — Stock: {{ $prod->pro_stock }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="flex:1;min-width:100px;max-width:150px;">
                    <label for="cantidad">
                        Cantidad <span aria-hidden="true">*</span>
                        <span class="sr-only">(obligatorio)</span>
                    </label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control"
                           value="1" min="1" max="999" required aria-required="true">
                </div>

                <div style="flex:0;padding-bottom:0.25rem;">
                    <button type="submit" class="btn btn-success" aria-label="Agregar producto seleccionado a la factura">
                        Agregar producto
                    </button>
                </div>
            </div>

            <div style="margin-top:0.75rem;display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
                <div class="form-group" style="min-width:160px;">
                    <label for="descuento_porcentaje">Descuento (%) <span class="sr-only">Opcional</span></label>
                    <input type="number" name="descuento_porcentaje" id="descuento_porcentaje" class="form-control"
                           placeholder="p. ej. 7" min="0" max="100" step="0.01">
                    <small style="color:#666;font-size:0.85rem;">Aplicar descuento solo a este producto (opcional)</small>
                </div>
            </div>

            {{-- Preview del producto seleccionado --}}
            <div id="preview-producto" hidden aria-live="polite" aria-atomic="true"
                 style="background:#eff6ff;border-left:4px solid #2563eb;border-radius:6px;padding:0.75rem 1rem;margin-top:1rem;font-size:0.95rem;line-height:1.8;">
                <strong>Vista previa del producto seleccionado:</strong>
                <span id="prev-prod-nombre" style="display:block;"></span>
                <span id="prev-prod-detalle" style="display:block;"></span>
                <span id="prev-prod-stock" style="display:block;color:#92400e;"></span>
                <em style="font-size:0.85rem;color:#666;">Este valor aún no está guardado.</em>
            </div>
        </form>
    </section>

    <hr aria-hidden="true">

    {{-- ══ RESUMEN ══ --}}
    <section aria-labelledby="titulo-resumen" aria-live="polite" aria-atomic="true">
        <h2 id="titulo-resumen">Resumen</h2>

        <div class="factura-resumen">
            <p>
                <strong>Subtotal servicios:</strong>
                <span>
                    <span aria-hidden="true" id="vis-subtotal">${{ number_format($subtotalServicios, 0, ',', '.') }}</span>
                    <span class="sr-only" id="acc-subtotal">{{ number_format($subtotalServicios, 0, ',', '.') }} pesos colombianos</span>
                </span>
            </p>
            @if($totalDescuentoMembresia > 0)
            <p style="color:#065f46;">
                <strong>Descuento membresía:</strong>
                <span>
                    <span aria-hidden="true">-${{ number_format($totalDescuentoMembresia, 0, ',', '.') }}</span>
                    <span class="sr-only">Descuento por membresía: {{ number_format($totalDescuentoMembresia, 0, ',', '.') }} pesos colombianos</span>
                </span>
            </p>
            @endif
            <p>
                <strong>Subtotal productos:</strong>
                <span>
                    <span aria-hidden="true" id="vis-productos">${{ number_format($totalProductos, 0, ',', '.') }}</span>
                    <span class="sr-only" id="acc-productos">{{ number_format($totalProductos, 0, ',', '.') }} pesos colombianos</span>
                </span>
            </p>
            <p>
                <strong>Total factura:</strong>
                <span>
                    <span aria-hidden="true" id="vis-total">${{ number_format($totalFinal, 0, ',', '.') }}</span>
                    <span class="sr-only" id="acc-total">{{ number_format($totalFinal, 0, ',', '.') }} pesos colombianos</span>
                </span>
            </p>
            <p>
                <strong>Abono:</strong>
                <span>
                    <span aria-hidden="true">${{ number_format($abono, 0, ',', '.') }}</span>
                    <span class="sr-only">{{ number_format($abono, 0, ',', '.') }} pesos colombianos</span>
                </span>
            </p>
            <p style="font-size:18px;font-weight:bold;color:#1a7f37;">
                <strong>Total a pagar:</strong>
                <span>
                    <span aria-hidden="true" id="vis-saldo">${{ number_format($saldo, 0, ',', '.') }}</span>
                    <span class="sr-only" id="acc-saldo">{{ number_format($saldo, 0, ',', '.') }} pesos colombianos</span>
                </span>
            </p>

            <p id="aviso-preview" hidden aria-live="polite"
               style="font-size:0.85rem;color:#92400e;background:#fef3c7;padding:0.5rem 0.75rem;border-radius:4px;margin-top:0.5rem;">
                El total incluye el ítem seleccionado pero <strong>aún no guardado</strong>.
                Presione el botón "Agregar" para confirmarlo.
            </p>

            <div style="margin-top:1.25rem;">
                <button type="button" id="btn-guardar-pdf" class="btn btn-success"
                        aria-label="Guardar factura, descargar PDF y volver al listado de facturas">
                    Guardar y descargar PDF
                </button>
            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectServ    = document.getElementById('serv_id');
    const selectProd    = document.getElementById('pro_id');
    const inputCant     = document.getElementById('cantidad');
    const preview       = document.getElementById('preview-servicio');
    const avisoPreview  = document.getElementById('aviso-preview');
    const prevNombre    = document.getElementById('prev-nombre');
    const prevDetalle   = document.getElementById('prev-detalle');
    const previewProd   = document.getElementById('preview-producto');
    const prevProdNombre  = document.getElementById('prev-prod-nombre');
    const prevProdDetalle = document.getElementById('prev-prod-detalle');
    const prevProdStock   = document.getElementById('prev-prod-stock');

    const visTotalEl    = document.getElementById('vis-total');
    const accTotalEl    = document.getElementById('acc-total');
    const visSubEl      = document.getElementById('vis-subtotal');
    const accSubEl      = document.getElementById('acc-subtotal');
    const visSaldoEl    = document.getElementById('vis-saldo');
    const accSaldoEl    = document.getElementById('acc-saldo');
    const visProdEl     = document.getElementById('vis-productos');
    const accProdEl     = document.getElementById('acc-productos');

    // Valores base del servidor
    const finalPrincipal  = parseFloat(selectServ.dataset.finalPrincipal)  || 0;
    const subtotalExtras  = parseFloat(selectServ.dataset.subtotalExtras)  || 0;
    const totalProductos  = parseFloat(selectServ.dataset.totalProductos)  || 0;
    const abono           = parseFloat(selectServ.dataset.abono)           || 0;

    const totalBaseServicios = finalPrincipal + subtotalExtras;

    function fmt(n) {
        return n.toLocaleString('es-CO', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    let extraServ = 0;
    let extraProd = 0;

    function actualizarResumen() {
        const nuevoSubServ = totalBaseServicios + extraServ;
        const nuevoSubProd = totalProductos + extraProd;
        const nuevoTotal = nuevoSubServ + nuevoSubProd;
        const nuevoSaldo = nuevoTotal - abono;

        visSubEl.textContent  = '$' + fmt(nuevoSubServ);
        accSubEl.textContent  = fmt(nuevoSubServ) + ' pesos colombianos';
        visProdEl.textContent = '$' + fmt(nuevoSubProd);
        accProdEl.textContent = fmt(nuevoSubProd) + ' pesos colombianos';
        visTotalEl.textContent = '$' + fmt(nuevoTotal);
        accTotalEl.textContent = fmt(nuevoTotal) + ' pesos colombianos';
        visSaldoEl.textContent = '$' + fmt(nuevoSaldo);
        accSaldoEl.textContent = fmt(nuevoSaldo) + ' pesos colombianos';
    }

    // ── Servicio select ──
    selectServ.addEventListener('change', function () {
        const opt       = this.options[this.selectedIndex];
        const precio    = parseFloat(opt.dataset.precio)   || 0;
        const nombre    = opt.dataset.nombre               || '';
        const original  = parseFloat(opt.dataset.original) || 0;
        const descuento = opt.dataset.descuento            || '0';

        if (!this.value) {
            extraServ = 0;
            actualizarResumen();
            preview.hidden      = true;
            avisoPreview.hidden = true;
            return;
        }

        prevNombre.textContent  = nombre + '.';
        prevDetalle.textContent =
            'Valor original: ' + fmt(original) + ' pesos colombianos. ' +
            'Descuento: ' + descuento + ' por ciento. ' +
            'Valor final: ' + fmt(precio) + ' pesos colombianos.';

        preview.hidden      = false;
        avisoPreview.hidden = false;
        extraServ = precio;
        actualizarResumen();
    });

    // ── Producto select + cantidad ──
    function actualizarPreviewProducto() {
        const opt      = selectProd.options[selectProd.selectedIndex];
        const precio   = parseFloat(opt.dataset.precio)   || 0;
        const nombre   = opt.dataset.nombre               || '';
        const original = parseFloat(opt.dataset.original)  || 0;
        const desc     = opt.dataset.descuento             || '0';
        const stock    = parseInt(opt.dataset.stock)        || 0;
        const cant     = parseInt(inputCant.value)          || 1;

        if (!selectProd.value) {
            extraProd = 0;
            actualizarResumen();
            previewProd.hidden  = true;
            if (!selectServ.value) avisoPreview.hidden = true;
            return;
        }

        const subtotalProd = precio * cant;
        prevProdNombre.textContent  = nombre + ' (x' + cant + ').';
        prevProdDetalle.textContent =
            'Precio unitario: ' + fmt(precio) + ' pesos colombianos. ' +
            'Subtotal: ' + fmt(subtotalProd) + ' pesos colombianos.';
        prevProdStock.textContent = cant > stock
            ? '⚠ Stock insuficiente. Disponible: ' + stock + '.'
            : 'Stock disponible: ' + stock + '.';

        previewProd.hidden  = false;
        avisoPreview.hidden = false;
        extraProd = subtotalProd;
        actualizarResumen();

        // Limitar max del input
        inputCant.max = stock;
    }

    selectProd.addEventListener('change', actualizarPreviewProducto);
    inputCant.addEventListener('input', actualizarPreviewProducto);

    // ── PDF ──
    document.getElementById('btn-guardar-pdf').addEventListener('click', function () {
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = "{{ route('facturas.pdf', $factura->fac_id) }}";
        document.body.appendChild(iframe);
        setTimeout(function () {
            window.location.href = "{{ route('factura.index') }}";
        }, 1000);
    });

    // Escape: volver al listado
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            window.location.href = "{{ route('factura.index') }}";
        }
    });
});
</script>

@endsection