<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes CRM - H Barber Shop</title>
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
        .header { background: #111111; }

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
            width: 60%;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 40%;
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
            font-size: 15px;
            font-weight: 900;
            margin-top: 5px;
            letter-spacing: -0.3px;
        }

        /* ══════════════════════════════
           BANDA RESUMEN
        ══════════════════════════════ */
        .info-bar {
            background: #f7f7f7;
            border-bottom: 2px solid #dc0000;
            padding: 10px 24px;
            display: table;
            width: 100%;
        }

        .info-bar-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }

        .info-bar-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .info-label {
            font-size: 7px;
            font-weight: 700;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 11px;
            font-weight: 800;
            color: #111111;
        }

        .generado-text {
            font-size: 8px;
            color: #888888;
        }

        /* ══════════════════════════════
           MÉTRICAS RÁPIDAS
        ══════════════════════════════ */
        .metricas-row {
            display: table;
            width: 100%;
            padding: 14px 24px;
            border-bottom: 1px solid #eeeeee;
        }

        .metrica-mini {
            display: table-cell;
            width: 25%;
            padding-right: 12px;
            vertical-align: top;
        }

        .metrica-mini:last-child { padding-right: 0; }

        .metrica-mini-label {
            font-size: 7px;
            font-weight: 700;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .metrica-mini-value {
            font-size: 15px;
            font-weight: 900;
            color: #111111;
            line-height: 1;
        }

        .metrica-mini-value.rojo { color: #dc0000; }
        .metrica-mini-value.verde { color: #10b981; }

        .metrica-mini-sub {
            font-size: 7.5px;
            color: #aaaaaa;
            margin-top: 3px;
        }

        /* ══════════════════════════════
           SECCIÓN
        ══════════════════════════════ */
        .section {
            padding: 14px 24px 0;
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

        .section-title-accent {
            display: inline-block;
            width: 4px;
            height: 12px;
            background: #dc0000;
            margin-right: 7px;
            vertical-align: middle;
            border-radius: 2px;
        }

        .section-title {
            font-size: 10px;
            font-weight: 900;
            color: #111111;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            vertical-align: middle;
        }

        .section-count {
            font-size: 8px;
            color: #aaaaaa;
        }

        /* ══════════════════════════════
           TABLA PRINCIPAL
        ══════════════════════════════ */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        table.data thead tr {
            background: #111111;
        }

        table.data thead th {
            padding: 8px 7px;
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

        /* Fila resaltada: cliente inactivo +2 meses */
        table.data tbody tr.inactivo {
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
        }

        table.data tbody tr.inactivo:nth-child(even) {
            background: #fef9e7;
        }

        table.data tbody td {
            padding: 7px 7px;
            font-size: 9px;
            color: #333333;
            vertical-align: top;
        }

        table.data tbody td.num {
            text-align: center;
            font-weight: 700;
            color: #111111;
        }

        table.data tbody td.moneda {
            text-align: right;
            font-weight: 700;
            color: #dc0000;
        }

        /* Nombre del cliente */
        .cliente-nombre {
            font-weight: 700;
            color: #111111;
            font-size: 9.5px;
        }

        .cliente-cedula {
            font-size: 8px;
            color: #888888;
            margin-top: 1px;
        }

        /* Celular */
        .celular {
            font-size: 9px;
            color: #555555;
        }

        /* Fecha */
        .fecha-value {
            font-size: 9px;
            color: #333333;
        }

        .fecha-inactivo {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            font-size: 7px;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 3px;
            margin-top: 2px;
            border: 1px solid #fbbf24;
        }

        /* Servicios */
        .servicio-item {
            font-size: 8.5px;
            color: #444444;
            padding: 1px 0;
            line-height: 1.5;
        }

        .servicio-count {
            display: inline-block;
            background: #f0f0f0;
            color: #555555;
            font-size: 7.5px;
            font-weight: 700;
            padding: 0px 5px;
            border-radius: 3px;
            margin-left: 3px;
        }

        /* Fila vacía */
        .fila-vacia td {
            text-align: center;
            color: #aaaaaa;
            font-style: italic;
            padding: 20px 8px;
            font-size: 9px;
        }

        /* Tfoot */
        table.data tfoot tr {
            background: #111111;
        }

        table.data tfoot th,
        table.data tfoot td {
            padding: 7px 7px;
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

        /* ══════════════════════════════
           LEYENDA
        ══════════════════════════════ */
        .leyenda {
            padding: 10px 24px;
            display: table;
            width: 100%;
        }

        .leyenda-item {
            display: table-cell;
            vertical-align: middle;
            font-size: 8px;
            color: #666666;
            padding-right: 20px;
        }

        .leyenda-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 2px;
            vertical-align: middle;
            margin-right: 4px;
        }

        .leyenda-amarillo { background: #fef3c7; border: 1px solid #fbbf24; }
        .leyenda-normal   { background: #ffffff; border: 1px solid #e5e5e5; }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            background: #111111;
            padding: 12px 24px;
            display: table;
            width: 100%;
            margin-top: 16px;
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
            <div class="report-badge">CRM</div>
            <div class="report-title">Listado de Clientes</div>
        </div>
    </div>
</div>

{{-- ══ BANDA DE INFO ══ --}}
@php
    $totalClientes   = count($clientes);
    $totalVisitas    = $clientes->sum('visitas');
    $totalGasto      = $clientes->sum('gasto_total');
    $promedioGasto   = $totalClientes > 0 ? $totalGasto / $totalClientes : 0;
    $inactivos       = $clientes->filter(function($c) {
        return $c->ultima_visita && \Carbon\Carbon::parse($c->ultima_visita)->diffInMonths(now()) >= 2;
    })->count();
@endphp

<div class="info-bar">
    <div class="info-bar-left">
        <div class="info-label">Reporte CRM &mdash; Base de clientes</div>
        <div class="info-value">{{ $totalClientes }} cliente(s) registrados</div>
    </div>
    <div class="info-bar-right">
        <div class="generado-text">
            Generado el {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
        </div>
    </div>
</div>

{{-- ══ MÉTRICAS ══ --}}
<div class="metricas-row">
    <div class="metrica-mini">
        <div class="metrica-mini-label">Total clientes</div>
        <div class="metrica-mini-value">{{ $totalClientes }}</div>
        <div class="metrica-mini-sub">En la base de datos</div>
    </div>
    <div class="metrica-mini">
        <div class="metrica-mini-label">Total visitas</div>
        <div class="metrica-mini-value">{{ $totalVisitas }}</div>
        <div class="metrica-mini-sub">Acumuladas</div>
    </div>
    <div class="metrica-mini">
        <div class="metrica-mini-label">Facturaci&oacute;n total</div>
        <div class="metrica-mini-value rojo">${{ number_format($totalGasto, 0, ',', '.') }}</div>
        <div class="metrica-mini-sub">Gasto acumulado</div>
    </div>
    <div class="metrica-mini">
        <div class="metrica-mini-label">Clientes inactivos</div>
        <div class="metrica-mini-value {{ $inactivos > 0 ? 'rojo' : 'verde' }}">{{ $inactivos }}</div>
        <div class="metrica-mini-sub">Más de 2 meses sin visitar</div>
    </div>
</div>

{{-- ══ TABLA PRINCIPAL ══ --}}
<div class="section">
    <div class="section-header">
        <div class="section-header-left">
            <span class="section-title-accent"></span>
            <span class="section-title">Detalle de clientes</span>
        </div>
        <div class="section-header-right">
            <span class="section-count">{{ $totalClientes }} registro(s)</span>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width:22%;">Cliente</th>
                <th style="width:12%;">Celular</th>
                <th class="num" style="width:8%;">Visitas</th>
                <th style="width:13%;">&Uacute;ltima visita</th>
                <th class="moneda" style="width:13%;">Gasto total</th>
                <th style="width:32%;">Servicios / Cortes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $c)
            @php
                $esInactivo = $c->ultima_visita &&
                    \Carbon\Carbon::parse($c->ultima_visita)->diffInMonths(now()) >= 2;
            @endphp
            <tr class="{{ $esInactivo ? 'inactivo' : '' }}">
                <td>
                    <div class="cliente-nombre">{{ $c->tur_nombre }}</div>
                    <div class="cliente-cedula">CC {{ $c->tur_cedula }}</div>
                </td>
                <td>
                    <div class="celular">{{ $c->tur_celular }}</div>
                </td>
                <td class="num">{{ $c->visitas }}</td>
                <td>
                    @if($c->ultima_visita)
                        <div class="fecha-value">
                            {{ \Carbon\Carbon::parse($c->ultima_visita)->format('d/m/Y') }}
                        </div>
                        @if($esInactivo)
                            <div class="fecha-inactivo">
                                +{{ \Carbon\Carbon::parse($c->ultima_visita)->diffInMonths(now()) }} meses inactivo
                            </div>
                        @endif
                    @else
                        <span style="color:#aaa;font-style:italic;">Sin visitas</span>
                    @endif
                </td>
                <td class="moneda">${{ number_format($c->gasto_total, 0, ',', '.') }}</td>
                <td>
                    @if($c->servicios && count($c->servicios) > 0)
                        @foreach($c->servicios as $servicio)
                            <div class="servicio-item">
                                {{ $servicio->serv_nombre }}
                                <span class="servicio-count">x{{ $servicio->cantidad }}</span>
                            </div>
                        @endforeach
                    @else
                        <span style="color:#aaa;font-style:italic;font-size:8.5px;">Sin servicios</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr class="fila-vacia">
                <td colspan="6">No hay clientes registrados.</td>
            </tr>
            @endforelse
        </tbody>
        @if($totalClientes > 0)
        <tfoot>
            <tr>
                <th colspan="2">Totales</th>
                <td class="num">{{ $totalVisitas }}</td>
                <td></td>
                <td class="moneda">${{ number_format($totalGasto, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

{{-- ══ LEYENDA ══ --}}
@if($inactivos > 0)
<div class="leyenda">
    <div class="leyenda-item">
        <span class="leyenda-box leyenda-amarillo"></span>
        Cliente inactivo (más de 2 meses sin visitar) — se recomienda contactar por WhatsApp.
    </div>
    <div class="leyenda-item">
        <span class="leyenda-box leyenda-normal"></span>
        Cliente activo.
    </div>
</div>
@endif

{{-- ══ FOOTER ══ --}}
<div class="footer">
    <div class="footer-left">
        <div class="footer-text">&copy; {{ date('Y') }} <span>H Barber Shop</span> &mdash; Listado CRM &mdash; Uso interno</div>
    </div>
    <div class="footer-right">
        <div class="footer-text">
            {{ $totalClientes }} cliente(s) &mdash; Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>
</div>

</body>
</html>