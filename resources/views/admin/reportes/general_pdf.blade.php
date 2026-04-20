<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General - H Barber Shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            background: #ffffff;
        }

        /* ══════════════════════════════
           HEADER
        ══════════════════════════════ */
        .header {
            background: #111111;
            padding: 0;
        }

        .header-accent {
            background: #dc0000;
            height: 5px;
        }

        .header-body {
            display: table;
            width: 100%;
            padding: 18px 24px 16px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 65%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 35%;
        }

        .brand {
            font-size: 20px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1;
        }

        .brand span { color: #dc0000; }

        .brand-tagline {
            font-size: 7.5px;
            color: #999999;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .report-badge {
            display: inline-block;
            background: #dc0000;
            color: #ffffff;
            padding: 5px 14px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .report-title {
            color: #ffffff;
            font-size: 16px;
            font-weight: 900;
            margin-top: 5px;
            letter-spacing: -0.3px;
        }

        /* ══════════════════════════════
           BANDA DE PERÍODO
        ══════════════════════════════ */
        .periodo-bar {
            background: #f7f7f7;
            border-bottom: 2px solid #dc0000;
            padding: 10px 24px;
            display: table;
            width: 100%;
        }

        .periodo-left {
            display: table-cell;
            vertical-align: middle;
        }

        .periodo-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .periodo-label {
            font-size: 7px;
            font-weight: 700;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 2px;
        }

        .periodo-value {
            font-size: 11px;
            font-weight: 800;
            color: #111111;
        }

        .generado-text {
            font-size: 8px;
            color: #888888;
        }

        /* ══════════════════════════════
           MÉTRICAS PRINCIPALES
        ══════════════════════════════ */
        .metricas-grid {
            display: table;
            width: 100%;
            margin: 16px 0 0;
            padding: 0 24px;
            border-collapse: separate;
            border-spacing: 8px 0;
        }

        .metrica-card {
            display: table-cell;
            width: 25%;
            background: #f7f7f7;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 12px 14px;
            vertical-align: top;
            border-top: 3px solid #dc0000;
        }

        .metrica-card.verde-card {
            border-top-color: #10b981;
        }

        .metrica-card.rojo-card {
            border-top-color: #dc0000;
        }

        .metrica-card-label {
            font-size: 7.5px;
            font-weight: 700;
            color: #888888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .metrica-card-value {
            font-size: 16px;
            font-weight: 900;
            color: #111111;
            line-height: 1;
        }

        .metrica-card-value.positivo { color: #10b981; }
        .metrica-card-value.negativo { color: #dc0000; }

        .metrica-card-sub {
            font-size: 7.5px;
            color: #aaaaaa;
            margin-top: 4px;
        }

        /* ══════════════════════════════
           SECCIONES
        ══════════════════════════════ */
        .section {
            padding: 16px 24px 0;
        }

        .section-header {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 2px solid #111111;
        }

        .section-header-left {
            display: table-cell;
            vertical-align: bottom;
        }

        .section-header-right {
            display: table-cell;
            vertical-align: bottom;
            text-align: right;
        }

        .section-title {
            font-size: 10px;
            font-weight: 900;
            color: #111111;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .section-title-accent {
            display: inline-block;
            width: 4px;
            height: 12px;
            background: #dc0000;
            margin-right: 7px;
            vertical-align: middle;
            border-radius: 2px;
        }

        .section-count {
            font-size: 8px;
            color: #aaaaaa;
        }

        /* ══════════════════════════════
           TABLAS
        ══════════════════════════════ */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        table.data thead tr {
            background: #111111;
        }

        table.data thead th {
            padding: 8px 8px;
            color: #ffffff;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-align: left;
        }

        table.data thead th.num { text-align: center; }
        table.data thead th.moneda { text-align: right; }

        table.data tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        table.data tbody tr:nth-child(even) {
            background: #fafafa;
        }

        table.data tbody tr:hover {
            background: #fff5f5;
        }

        table.data tbody td {
            padding: 7px 8px;
            font-size: 9.5px;
            color: #333333;
            vertical-align: middle;
        }

        table.data tbody td.num { text-align: center; }
        table.data tbody td.moneda {
            text-align: right;
            font-weight: 700;
            color: #111111;
        }

        table.data tbody td.moneda-verde {
            text-align: right;
            font-weight: 700;
            color: #10b981;
        }

        /* Rank badge */
        .rank {
            display: inline-block;
            background: #dc0000;
            color: #ffffff;
            font-size: 7px;
            font-weight: 900;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            text-align: center;
            line-height: 16px;
            margin-right: 5px;
        }

        .rank.gold   { background: #d97706; }
        .rank.silver { background: #6b7280; }
        .rank.bronze { background: #92400e; }

        /* Tfoot */
        table.data tfoot tr {
            background: #111111;
        }

        table.data tfoot th,
        table.data tfoot td {
            padding: 7px 8px;
            font-size: 9px;
            font-weight: 700;
            color: #ffffff;
        }

        table.data tfoot td.num { text-align: center; }
        table.data tfoot td.moneda {
            text-align: right;
            color: #dc0000;
            font-size: 10px;
        }

        /* Fila vacía */
        .fila-vacia td {
            text-align: center;
            color: #aaaaaa;
            font-style: italic;
            padding: 14px 8px;
            font-size: 9px;
        }

        /* ══════════════════════════════
           BARRA DE PORCENTAJE (barberos)
        ══════════════════════════════ */
        .bar-wrap {
            background: #f0f0f0;
            border-radius: 3px;
            height: 6px;
            width: 100%;
            margin-top: 3px;
            overflow: hidden;
        }

        .bar-fill {
            background: #dc0000;
            height: 6px;
            border-radius: 3px;
        }

        /* ══════════════════════════════
           GANANCIA NETA BANNER
        ══════════════════════════════ */
        .ganancia-banner {
            margin: 0 24px 16px;
            padding: 12px 18px;
            border-radius: 6px;
            display: table;
            width: calc(100% - 48px);
        }

        .ganancia-banner.positiva {
            background: #f0fff4;
            border: 1px solid #10b981;
            border-left: 5px solid #10b981;
        }

        .ganancia-banner.negativa {
            background: #fff5f5;
            border: 1px solid #dc0000;
            border-left: 5px solid #dc0000;
        }

        .ganancia-banner-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }

        .ganancia-banner-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .ganancia-banner-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .ganancia-banner.positiva .ganancia-banner-label { color: #065f46; }
        .ganancia-banner.negativa .ganancia-banner-label { color: #7f1d1d; }

        .ganancia-banner-desc {
            font-size: 8.5px;
        }

        .ganancia-banner.positiva .ganancia-banner-desc { color: #065f46; }
        .ganancia-banner.negativa .ganancia-banner-desc { color: #991b1b; }

        .ganancia-banner-value {
            font-size: 18px;
            font-weight: 900;
            line-height: 1;
        }

        .ganancia-banner.positiva .ganancia-banner-value { color: #10b981; }
        .ganancia-banner.negativa .ganancia-banner-value { color: #dc0000; }

        /* ══════════════════════════════
           DÍA BADGE
        ══════════════════════════════ */
        .dia-name {
            font-weight: 700;
            color: #111111;
            text-transform: capitalize;
        }

        .dia-date {
            font-size: 8.5px;
            color: #888888;
        }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            background: #111111;
            padding: 12px 24px;
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .footer-left {
            display: table-cell;
            vertical-align: middle;
        }

        .footer-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .footer-text {
            font-size: 7.5px;
            color: #666666;
        }

        .footer-text span { color: #dc0000; }

        @media print { body { padding: 0; } }
    </style>
</head>
<body>

{{-- ══ HEADER ══ --}}
<div class="header">
    <div class="header-accent"></div>
    <div class="header-body">
        <div class="header-left">
            <div class="brand">H <span>Barber</span> Shop</div>
            <div class="brand-tagline">Tu barber&iacute;a de confianza</div>
        </div>
        <div class="header-right">
            <div class="report-badge">Reporte</div>
            <div class="report-title">Reporte General</div>
        </div>
    </div>
</div>

{{-- ══ PERÍODO ══ --}}
<div class="periodo-bar">
    <div class="periodo-left">
        <div class="periodo-label">Per&iacute;odo analizado</div>
        <div class="periodo-value">
            {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} &mdash; {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
        </div>
    </div>
    <div class="periodo-right">
        <div class="generado-text">
            Generado el {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
        </div>
    </div>
</div>

{{-- ══ MÉTRICAS EN CARDS ══ --}}
@php
    $esPositivo = $gananciaNeta >= 0;
    $maxVentas  = $barberos->max('total_ventas') ?: 1;
@endphp

<table class="metricas-grid" style="margin-top:16px;">
    <tr>
        <td class="metrica-card">
            <div class="metrica-card-label">Ventas totales</div>
            <div class="metrica-card-value">${{ number_format($ventasTotales, 0, ',', '.') }}</div>
            <div class="metrica-card-sub">Ingresos del per&iacute;odo</div>
        </td>
        <td class="metrica-card" style="border-top-color:#e5e5e5;">
            <div class="metrica-card-label">Gastos totales</div>
            <div class="metrica-card-value">${{ number_format($gastosTotales, 0, ',', '.') }}</div>
            <div class="metrica-card-sub">Egresos del per&iacute;odo</div>
        </td>
        <td class="metrica-card {{ $esPositivo ? 'verde-card' : 'rojo-card' }}">
            <div class="metrica-card-label">Ganancia neta</div>
            <div class="metrica-card-value {{ $esPositivo ? 'positivo' : 'negativo' }}">
                ${{ number_format($gananciaNeta, 0, ',', '.') }}
            </div>
            <div class="metrica-card-sub">{{ $esPositivo ? 'Balance positivo' : 'Balance negativo' }}</div>
        </td>
        <td class="metrica-card" style="border-top-color:#111111;">
            <div class="metrica-card-label">Cortes realizados</div>
            <div class="metrica-card-value">{{ $cantidadCortes }}</div>
            <div class="metrica-card-sub">Servicios completados</div>
        </td>
    </tr>
</table>

{{-- ══ BARBEROS ══ --}}
<div class="section" style="margin-top:16px;">
    <div class="section-header">
        <div class="section-header-left">
            <span class="section-title-accent"></span>
            <span class="section-title">Resumen por barbero</span>
        </div>
        <div class="section-header-right">
            <span class="section-count">{{ $barberos->count() }} barbero(s)</span>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th>Barbero</th>
                <th class="num" style="width:18%;">Servicios</th>
                <th class="moneda" style="width:20%;">Total ventas</th>
                <th style="width:22%;">Participaci&oacute;n</th>
            </tr>
        </thead>
        <tbody>
            @php $totalVentasBarberos = $barberos->sum('total_ventas') ?: 1; @endphp
            @forelse($barberos as $i => $barbero)
            @php
                $nombre = trim(($barbero->disponibilidad->persona->per_nombre ?? '') . ' ' . ($barbero->disponibilidad->persona->per_apellido ?? '')) ?: '—';
                $pct = $totalVentasBarberos > 0 ? round($barbero->total_ventas / $totalVentasBarberos * 100) : 0;
                $rankClass = $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : ''));
            @endphp
            <tr>
                <td class="num"><span class="rank {{ $rankClass }}">{{ $i + 1 }}</span></td>
                <td>{{ $nombre }}</td>
                <td class="num">{{ $barbero->cantidad_servicios }}</td>
                <td class="moneda">${{ number_format($barbero->total_ventas, 0, ',', '.') }}</td>
                <td>
                    <div style="font-size:8px;color:#888;margin-bottom:2px;">{{ $pct }}%</div>
                    <div class="bar-wrap">
                        <div class="bar-fill" style="width:{{ $pct }}%;"></div>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="fila-vacia"><td colspan="5">No hay datos de barberos en este per&iacute;odo.</td></tr>
            @endforelse
        </tbody>
        @if($barberos->count() > 0)
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <td class="num">{{ $barberos->sum('cantidad_servicios') }}</td>
                <td class="moneda">${{ number_format($barberos->sum('total_ventas'), 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

{{-- ══ SERVICIOS MÁS VENDIDOS ══ --}}
<div class="section">
    <div class="section-header">
        <div class="section-header-left">
            <span class="section-title-accent"></span>
            <span class="section-title">Servicios m&aacute;s vendidos</span>
        </div>
        <div class="section-header-right">
            <span class="section-count">Top {{ $serviciosMasVendidos->count() }}</span>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th>Servicio</th>
                <th class="num" style="width:22%;">Cantidad realizada</th>
            </tr>
        </thead>
        <tbody>
            @forelse($serviciosMasVendidos as $i => $serv)
            @php $rankClass = $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')); @endphp
            <tr>
                <td class="num"><span class="rank {{ $rankClass }}">{{ $i + 1 }}</span></td>
                <td>{{ $serv->servicios->serv_nombre ?? $serv->serv_nombre ?? 'N/A' }}</td>
                <td class="num">{{ $serv->cantidad }}</td>
            </tr>
            @empty
            <tr class="fila-vacia"><td colspan="3">No hay datos de servicios en este per&iacute;odo.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ══ PRODUCTOS MÁS VENDIDOS ══ --}}
@isset($productosMasVendidos)
<div class="section">
    <div class="section-header">
        <div class="section-header-left">
            <span class="section-title-accent"></span>
            <span class="section-title">Productos m&aacute;s vendidos</span>
        </div>
        <div class="section-header-right">
            <span class="section-count">Top {{ $productosMasVendidos->count() }}</span>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th>Producto</th>
                <th class="num" style="width:18%;">Cantidad</th>
                <th class="moneda" style="width:22%;">Ingreso total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productosMasVendidos as $i => $prod)
            @php $rankClass = $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : '')); @endphp
            <tr>
                <td class="num"><span class="rank {{ $rankClass }}">{{ $i + 1 }}</span></td>
                <td>{{ $prod->nombre ?? 'N/A' }}</td>
                <td class="num">{{ $prod->total_vendido }}</td>
                <td class="moneda-verde">${{ number_format($prod->ingreso_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr class="fila-vacia"><td colspan="4">No hay productos vendidos en este per&iacute;odo.</td></tr>
            @endforelse
        </tbody>
        @if($productosMasVendidos->count() > 0)
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <td class="num">{{ $productosMasVendidos->sum('total_vendido') }}</td>
                <td class="moneda">${{ number_format($productosMasVendidos->sum('ingreso_total'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endisset

{{-- ══ DETALLE DE GASTOS ══ --}}
<div class="section">
    <div class="section-header">
        <div class="section-header-left">
            <span class="section-title-accent"></span>
            <span class="section-title">Detalle de gastos</span>
        </div>
        <div class="section-header-right">
            <span class="section-count">{{ $gastosDetalle->count() }} registro(s)</span>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width:12%;">Fecha</th>
                <th style="width:18%;">Categor&iacute;a</th>
                <th>Descripci&oacute;n</th>
                <th style="width:15%;">Sede</th>
                <th class="moneda" style="width:16%;">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gastosDetalle as $gasto)
            <tr>
                <td>{{ $gasto->fecha->format('d/m/Y') }}</td>
                <td>
                    <span style="background:#fff0f0;color:#dc0000;padding:1px 5px;border-radius:3px;font-size:8.5px;font-weight:700;">
                        {{ $gasto->categoria->nombre ?? 'N/A' }}
                    </span>
                </td>
                <td>{{ $gasto->descripcion }}</td>
                <td style="color:#666;">{{ $gasto->sede->sede_nombre ?? 'General' }}</td>
                <td class="moneda">${{ number_format($gasto->monto, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr class="fila-vacia"><td colspan="5">No hay gastos registrados en este per&iacute;odo.</td></tr>
            @endforelse
        </tbody>
        @if($gastosDetalle->count() > 0)
        <tfoot>
            <tr>
                <th colspan="4">Total gastos</th>
                <td class="moneda">${{ number_format($gastosDetalle->sum('monto'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

{{-- ══ DÍAS CON MÁS TURNOS ══ --}}
<div class="section">
    <div class="section-header">
        <div class="section-header-left">
            <span class="section-title-accent"></span>
            <span class="section-title">D&iacute;as con m&aacute;s turnos solicitados</span>
        </div>
        <div class="section-header-right">
            <span class="section-count">Top {{ $diasMasSolicitados->count() }}</span>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">#</th>
                <th>D&iacute;a</th>
                <th class="num" style="width:22%;">Turnos</th>
                <th style="width:35%;">Carga</th>
            </tr>
        </thead>
        <tbody>
            @php $maxTurnos = $diasMasSolicitados->max('cantidad') ?: 1; @endphp
            @forelse($diasMasSolicitados as $i => $dia)
            @php
                $pct = round($dia->cantidad / $maxTurnos * 100);
                $rankClass = $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : ''));
                $carbon = \Carbon\Carbon::parse($dia->dia)->locale('es');
            @endphp
            <tr>
                <td class="num"><span class="rank {{ $rankClass }}">{{ $i + 1 }}</span></td>
                <td>
                    <div class="dia-name">{{ $carbon->isoFormat('dddd') }}</div>
                    <div class="dia-date">{{ $carbon->isoFormat('D [de] MMMM [de] YYYY') }}</div>
                </td>
                <td class="num" style="font-weight:700;">{{ $dia->cantidad }}</td>
                <td>
                    <div style="font-size:8px;color:#888;margin-bottom:2px;">{{ $pct }}% del m&aacute;ximo</div>
                    <div class="bar-wrap">
                        <div class="bar-fill" style="width:{{ $pct }}%;background:#111111;"></div>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="fila-vacia"><td colspan="4">No hay datos de turnos en este per&iacute;odo.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ══ FOOTER ══ --}}
<div class="footer">
    <div class="footer-left">
        <div class="footer-text">&copy; {{ date('Y') }} <span>H Barber Shop</span> &mdash; Reporte General &mdash; Uso interno</div>
    </div>
    <div class="footer-right">
        <div class="footer-text">
            Per&iacute;odo: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} &mdash; {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
        </div>
    </div>
</div>

</body>
</html>