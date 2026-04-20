<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->fac_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #1a1a1a;
            background: #fff;
        }

        /* ══════════════════════════════
           CONTENEDOR
        ══════════════════════════════ */
        .page {
            width: 100%;
            max-width: 780px;
            margin: 0 auto;
        }

        /* ══════════════════════════════
           HEADER
        ══════════════════════════════ */
        .header {
            background: #111111;
            padding: 0;
            position: relative;
            overflow: hidden;
        }

        .header-accent {
            background: #dc0000;
            height: 6px;
            width: 100%;
        }

        .header-body {
            display: table;
            width: 100%;
            padding: 22px 28px 20px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 60%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            width: 40%;
            text-align: right;
        }

        .brand-name {
            font-size: 26px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1;
        }

        .brand-name span {
            color: #dc0000;
        }

        .brand-tagline {
            font-size: 9.5px;
            color: #aaaaaa;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .header-contact {
            font-size: 9px;
            color: #cccccc;
            line-height: 1.8;
            margin-top: 10px;
        }

        .factura-badge {
            background: #dc0000;
            color: #ffffff;
            display: inline-block;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .factura-numero {
            color: #ffffff;
            font-size: 22px;
            font-weight: 900;
            margin-top: 6px;
            letter-spacing: 1px;
        }

        .factura-fecha {
            color: #999999;
            font-size: 9.5px;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        /* ══════════════════════════════
           BLOQUE INFO CLIENTE / SEDE
        ══════════════════════════════ */
        .info-block {
            display: table;
            width: 100%;
            background: #f7f7f7;
            border-bottom: 3px solid #dc0000;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            padding: 18px 28px;
            vertical-align: top;
        }

        .info-col + .info-col {
            border-left: 1px solid #e0e0e0;
        }

        .info-col-title {
            font-size: 8px;
            font-weight: 800;
            color: #dc0000;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row {
            display: table;
            width: 100%;
            padding: 3px 0;
        }

        .info-row-label {
            display: table-cell;
            font-size: 9px;
            font-weight: 700;
            color: #888888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 90px;
        }

        .info-row-value {
            display: table-cell;
            font-size: 10.5px;
            color: #1a1a1a;
            font-weight: 600;
        }

        /* ══════════════════════════════
           SECCIONES
        ══════════════════════════════ */
        .section {
            padding: 20px 28px;
        }

        .section + .section {
            border-top: 1px solid #eeeeee;
        }

        .section-title {
            font-size: 9px;
            font-weight: 800;
            color: #dc0000;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 14px;
            display: table;
            width: 100%;
        }

        .section-title::after {
            content: '';
            display: table-cell;
            border-bottom: 2px solid #dc0000;
            vertical-align: bottom;
            padding-left: 10px;
        }

        /* ══════════════════════════════
           TABLAS
        ══════════════════════════════ */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.data-table thead tr {
            background: #111111;
            color: #ffffff;
        }

        table.data-table thead th {
            padding: 10px 10px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        table.data-table thead th.r { text-align: right; }
        table.data-table thead th.c { text-align: center; }

        table.data-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        table.data-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        table.data-table tbody td {
            padding: 10px 10px;
            font-size: 10.5px;
            color: #333333;
            vertical-align: middle;
        }

        table.data-table tbody td.r { text-align: right; }
        table.data-table tbody td.c { text-align: center; }

        table.data-table tbody td .td-name {
            font-weight: 700;
            color: #111111;
            font-size: 11px;
        }

        table.data-table tbody td .td-sub {
            font-size: 9px;
            color: #10b981;
            font-weight: 700;
            margin-top: 2px;
        }

        table.data-table tbody td .td-desc {
            font-size: 9px;
            color: #888888;
            margin-top: 1px;
        }

        table.data-table tfoot tr {
            background: #f0f0f0;
        }

        table.data-table tfoot td {
            padding: 8px 10px;
            font-size: 10px;
            font-weight: 700;
            color: #111111;
        }

        table.data-table tfoot td.r { text-align: right; }

        /* Descuento membresía */
        .membresia-tag {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            font-size: 8px;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 3px;
            border: 1px solid #10b981;
            margin-top: 3px;
        }

        .desc-membresia {
            color: #10b981;
            font-weight: 700;
            font-size: 10px;
        }

        /* ══════════════════════════════
           RESUMEN / TOTALES
        ══════════════════════════════ */
        .summary-section {
            background: #f7f7f7;
            padding: 20px 28px;
            border-top: 1px solid #eeeeee;
        }

        .summary-inner {
            width: 52%;
            margin-left: auto;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 6px 0;
            border-bottom: 1px solid #ebebeb;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .sum-label {
            display: table-cell;
            font-size: 10px;
            color: #555555;
            width: 60%;
        }

        .sum-value {
            display: table-cell;
            font-size: 10px;
            color: #111111;
            font-weight: 600;
            text-align: right;
            width: 40%;
        }

        .summary-row.desc .sum-label,
        .summary-row.desc .sum-value {
            color: #10b981;
            font-weight: 700;
        }

        .summary-divider {
            border: none;
            border-top: 2px solid #dddddd;
            margin: 8px 0;
        }

        .summary-row.total-row {
            background: #dc0000;
            border-radius: 5px;
            padding: 10px 12px;
            border-bottom: none;
            margin-top: 4px;
        }

        .summary-row.total-row .sum-label,
        .summary-row.total-row .sum-value {
            color: #ffffff;
            font-size: 13px;
            font-weight: 900;
        }

        .summary-row.abono-row {
            background: #e8f5e9;
            border-radius: 4px;
            padding: 7px 12px;
            margin-top: 6px;
            border: 1px solid #c8e6c9;
            border-bottom: 1px solid #c8e6c9;
        }

        .summary-row.abono-row .sum-label { color: #2e7d32; font-weight: 700; }
        .summary-row.abono-row .sum-value { color: #2e7d32; font-weight: 700; }

        .summary-row.saldo-row {
            background: #fff3cd;
            border-radius: 4px;
            padding: 7px 12px;
            margin-top: 4px;
            border: 1px solid #ffc107;
            border-bottom: 1px solid #ffc107;
        }

        .summary-row.saldo-row .sum-label { color: #856404; font-weight: 700; }
        .summary-row.saldo-row .sum-value { color: #856404; font-weight: 800; font-size: 12px; }

        /* ══════════════════════════════
           CÓDIGO DE BARRAS
        ══════════════════════════════ */
        .barcode-section {
            text-align: center;
            padding: 14px 28px;
            background: #ffffff;
            border-top: 1px dashed #cccccc;
        }

        .barcode-lines {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            letter-spacing: 3px;
            color: #222222;
            margin-bottom: 4px;
        }

        .barcode-num {
            font-family: 'Courier New', monospace;
            font-size: 9px;
            letter-spacing: 4px;
            color: #555555;
        }

        .barcode-label {
            font-size: 8px;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            background: #111111;
            padding: 18px 28px;
        }

        .footer-top {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }

        .footer-col {
            display: table-cell;
            vertical-align: top;
            width: 33.33%;
            padding: 0 10px;
        }

        .footer-col:first-child { padding-left: 0; }
        .footer-col:last-child { padding-right: 0; text-align: right; }

        .footer-col-title {
            font-size: 8px;
            font-weight: 800;
            color: #dc0000;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 5px;
        }

        .footer-col-text {
            font-size: 8.5px;
            color: #aaaaaa;
            line-height: 1.7;
        }

        .footer-divider {
            border: none;
            border-top: 1px solid #333333;
            margin: 12px 0;
        }

        .footer-bottom {
            text-align: center;
            font-size: 8px;
            color: #666666;
            letter-spacing: 0.5px;
        }

        .footer-bottom span {
            color: #dc0000;
        }

        /* ══════════════════════════════
           UTILIDADES
        ══════════════════════════════ */
        .red { color: #dc0000; }
        .green { color: #10b981; }
        .bold { font-weight: 700; }

        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="header">
        <div class="header-accent"></div>
        <div class="header-body">
            <div class="header-left">
                <div class="brand-name">H <span>Barber</span> Shop</div>
                <div class="brand-tagline">Tu barbería de confianza</div>
                <div class="header-contact">
                    📍 {{ $factura->sede->sede_direccion ?? 'Dirección no disponible' }}<br>
                    📞 {{ $factura->sede->sede_telefono ?? '(311) 8104 544' }}
                </div>
            </div>
            <div class="header-right">
                <div class="factura-badge">Factura</div>
                <div class="factura-numero">#{{ str_pad($factura->fac_id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="factura-fecha">{{ \Carbon\Carbon::parse($factura->fac_fecha)->format('d \d\e F \d\e Y') }}</div>
            </div>
        </div>
    </div>

    {{-- ══ INFO CLIENTE / SEDE ══ --}}
    <div class="info-block">
        <div class="info-col">
            <div class="info-col-title">Información del cliente</div>
            <div class="info-row">
                <div class="info-row-label">Cliente</div>
                <div class="info-row-value">{{ $factura->turno->tur_nombre ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-row-label">Cédula</div>
                <div class="info-row-value">{{ $factura->turno->tur_cedula ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-row-label">Barbero</div>
                <div class="info-row-value">
                    {{ $factura->turno->disponibilidad->persona->per_nombre ?? '' }}
                    {{ $factura->turno->disponibilidad->persona->per_apellido ?? '—' }}
                </div>
            </div>
        </div>
        <div class="info-col">
            <div class="info-col-title">Información de la sede</div>
            <div class="info-row">
                <div class="info-row-label">Sede</div>
                <div class="info-row-value">{{ $factura->sede->sede_nombre ?? 'No especificada' }}</div>
            </div>
            <div class="info-row">
                <div class="info-row-label">Dirección</div>
                <div class="info-row-value">{{ $factura->sede->sede_direccion ?? '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-row-label">Teléfono</div>
                <div class="info-row-value">{{ $factura->sede->sede_telefono ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- ══ SERVICIOS ══ --}}
    <div class="section">
        <div class="section-title">Servicios facturados</div>

        @php
            $precioOrigPrincipalPdf  = (float)($factura->turno->servicio->serv_precio ?? 0);
            $descServPrincipalPdf    = (float)($factura->turno->servicio->serv_descuento ?? 0);
            $membresiaDescPdf        = (float)($factura->membresia_descuento ?? 0);
            $precioFinalPrincipalPdf = max(0, $precioOrigPrincipalPdf * (1 - $descServPrincipalPdf / 100) - $membresiaDescPdf);
        @endphp

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:48%;">Servicio</th>
                    <th class="r" style="width:18%;">Precio original</th>
                    <th class="c" style="width:16%;">Descuento</th>
                    <th class="r" style="width:18%;">Precio final</th>
                </tr>
            </thead>
            <tbody>
                {{-- Servicio principal --}}
                <tr>
                    <td>
                        <div class="td-name">{{ $factura->turno->servicio->serv_nombre ?? '—' }}</div>
                        @if($membresiaDescPdf > 0)
                            <div><span class="membresia-tag">★ Membresía aplicada</span></div>
                        @endif
                    </td>
                    <td class="r">${{ number_format($precioOrigPrincipalPdf, 0, ',', '.') }}</td>
                    <td class="c">
                        @if($membresiaDescPdf > 0)
                            <span class="desc-membresia">-${{ number_format($membresiaDescPdf, 0, ',', '.') }}</span>
                        @else
                            {{ $descServPrincipalPdf }}%
                        @endif
                    </td>
                    <td class="r bold red">${{ number_format($precioFinalPrincipalPdf, 0, ',', '.') }}</td>
                </tr>

                {{-- Servicios extra --}}
                @foreach($factura->detalles->whereNotNull('serv_id') as $detalle)
                @php
                    $precioOrigExtraPdf = $detalle->precio_original ?? ($detalle->servicios->serv_precio ?? $detalle->serv_precio ?? 0);
                    $descMemExtraPdf    = (float)($detalle->descuento_membresia ?? 0);
                @endphp
                <tr>
                    <td>
                        <div class="td-name">{{ $detalle->servicios->serv_nombre ?? '—' }}</div>
                        @if($descMemExtraPdf > 0)
                            <div><span class="membresia-tag">★ Membresía aplicada</span></div>
                        @endif
                    </td>
                    <td class="r">${{ number_format($precioOrigExtraPdf, 0, ',', '.') }}</td>
                    <td class="c">
                        @if($descMemExtraPdf > 0)
                            <span class="desc-membresia">-${{ number_format($descMemExtraPdf, 0, ',', '.') }}</span>
                        @elseif(($detalle->servicios->serv_descuento ?? 0) > 0)
                            {{ $detalle->servicios->serv_descuento }}%
                        @else
                            —
                        @endif
                    </td>
                    <td class="r bold red">${{ number_format($detalle->serv_precio, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ══ PRODUCTOS ══ --}}
    @php $productosDetalles = $factura->detalles->whereNotNull('pro_id'); @endphp
    @if($productosDetalles->count() > 0)
    <div class="section">
        <div class="section-title">Productos</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:44%;">Producto</th>
                    <th class="c" style="width:16%;">Cantidad</th>
                    <th class="r" style="width:20%;">Precio unitario</th>
                    <th class="r" style="width:20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosDetalles as $detProd)
                <tr>
                    <td>
                        <div class="td-name">{{ $detProd->facdet_descripcion }}</div>
                        @php
                            $precioOrig = (float)($detProd->precio_original ?? 0);
                            $descuentoProd = (float)($detProd->descuento_membresia ?? 0);
                        @endphp
                        @if($descuentoProd > 0)
                            @php
                                $porc = $precioOrig > 0 ? round(($descuentoProd / $precioOrig) * 100, 2) : null;
                            @endphp
                            <div><span class="membresia-tag">★ Descuento aplicado</span></div>
                            <div class="td-sub">-${{ number_format($descuentoProd * $detProd->facdet_cantidad, 0, ',', '.') }} @if($porc) ({{ $porc }}%) @endif</div>
                        @endif
                    </td>
                    <td class="c">{{ $detProd->facdet_cantidad }}</td>
                    <td class="r">${{ number_format($detProd->facdet_precio_unitario, 0, ',', '.') }}</td>
                    <td class="r bold">${{ number_format($detProd->facdet_subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="r">Total productos:</td>
                    <td class="r red">${{ number_format($productosDetalles->sum('facdet_subtotal'), 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    {{-- ══ RESUMEN ══ --}}
    @php
        $servPrincipal      = $factura->turno->servicio;
        $precioPrincipalSum = (float)($servPrincipal->serv_precio ?? 0);
        $descPrincipalSum   = (float)($servPrincipal->serv_descuento ?? 0);
        $membresiaDescSum   = (float)($factura->membresia_descuento ?? 0)
            + $factura->detalles->whereNotNull('serv_id')->sum('descuento_membresia')
            + $factura->detalles->whereNotNull('pro_id')->sum('descuento_membresia');
        $finalPrincipalSum  = max(0, $precioPrincipalSum * (1 - $descPrincipalSum / 100) - (float)($factura->membresia_descuento ?? 0));
        $totalExtras        = $factura->detalles->whereNotNull('serv_id')->sum('serv_precio');
        $totalProductos     = $factura->detalles->whereNotNull('pro_id')->sum('facdet_subtotal');
        $totalFinal         = $factura->fac_total;
        $abono              = $factura->fac_abono > 0 ? $factura->fac_abono : ($factura->turno->tur_anticipo ?? 0);
        $saldo              = $totalFinal - $abono;
    @endphp

    <div class="summary-section">
        <div class="summary-inner">

            <div class="summary-row">
                <div class="sum-label">Subtotal servicios</div>
                <div class="sum-value">${{ number_format($finalPrincipalSum + $totalExtras, 0, ',', '.') }}</div>
            </div>

            @if($membresiaDescSum > 0)
            <div class="summary-row desc">
                <div class="sum-label">✓ Descuento membresía</div>
                <div class="sum-value">-${{ number_format($membresiaDescSum, 0, ',', '.') }}</div>
            </div>
            @endif

            @if($totalProductos > 0)
            <div class="summary-row">
                <div class="sum-label">Subtotal productos</div>
                <div class="sum-value">${{ number_format($totalProductos, 0, ',', '.') }}</div>
            </div>
            @endif

            <hr class="summary-divider">

            <div class="summary-row total-row">
                <div class="sum-label">TOTAL</div>
                <div class="sum-value">${{ number_format($totalFinal, 0, ',', '.') }}</div>
            </div>

            <div class="summary-row abono-row">
                <div class="sum-label">✓ Abono / anticipo</div>
                <div class="sum-value">${{ number_format($abono, 0, ',', '.') }}</div>
            </div>

            <div class="summary-row saldo-row">
                <div class="sum-label">Saldo pendiente</div>
                <div class="sum-value">${{ number_format($saldo, 0, ',', '.') }}</div>
            </div>

        </div>
    </div>

    {{-- ══ CÓDIGO DE BARRAS ══ --}}
    <div class="barcode-section">
        <div class="barcode-lines">||| || |||| | || ||| |||| || | ||| || ||||</div>
        <div class="barcode-num">FAC-{{ str_pad($factura->fac_id, 8, '0', STR_PAD_LEFT) }}</div>
        <div class="barcode-label">Factura electrónica · Validado: {{ now()->format('Y-m-d H:i:s') }}</div>
    </div>

    {{-- ══ FOOTER ══ --}}
    <div class="footer">
        <div class="footer-top">
            <div class="footer-col">
                <div class="footer-col-title">Comprobante</div>
                <div class="footer-col-text">
                    Este documento es una factura válida y puede ser utilizado como comprobante de pago.
                </div>
            </div>
            <div class="footer-col" style="text-align:center;">
                <div class="footer-col-title">Atención al cliente</div>
                <div class="footer-col-text">
                    Para consultas o reclamos contáctanos a través de nuestros canales oficiales.
                </div>
            </div>
            <div class="footer-col">
                <div class="footer-col-title">Gracias</div>
                <div class="footer-col-text">
                    ¡Gracias por tu preferencia! Te esperamos pronto.
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            © {{ date('Y') }} <span>H Barber Shop</span> · Todos los derechos reservados
        </div>
    </div>

</div>
</body>
</html>