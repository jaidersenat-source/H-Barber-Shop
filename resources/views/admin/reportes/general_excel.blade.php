@php echo "\xEF\xBB\xBF"; @endphp
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--[if gte mso 9]>
    <xml>
    </xml>
    <![endif]-->
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #1e3a5f; color: #ffffff; font-weight: bold; }
        .section-title { background-color: #2c5282; color: #ffffff; font-size: 14pt; font-weight: bold; }
        .metric-label { font-weight: bold; background-color: #e2e8f0; }
        .metric-value { text-align: right; }
        .currency { mso-number-format: "\$\#\,\#\#0\.00"; text-align: right; }
        .number { mso-number-format: "0"; text-align: center; }
        .date { mso-number-format: "yyyy-mm-dd"; }
        .total-row { background-color: #edf2f7; font-weight: bold; }
    </style>
</head>
<body>
    <table>
        <!-- Titulo principal -->
        <tr>
            <th colspan="6" class="section-title">Metricas principales</th>
        </tr>
        <tr>
            <td class="metric-label">Ventas totales</td>
            <td class="currency" colspan="5">{{ number_format($ventasTotales, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td class="metric-label">Gastos totales</td>
            <td class="currency" colspan="5">{{ number_format($gastosTotales, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td class="metric-label">Ganancia neta</td>
            <td class="currency" colspan="5">{{ number_format($gananciaNeta, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td class="metric-label">Cantidad de cortes realizados</td>
            <td class="number" colspan="5">{{ $cantidadCortes }}</td>
        </tr>
        <tr><td colspan="6"></td></tr>

        <!-- Resumen de barberos -->
        <tr>
            <th colspan="6" class="section-title">Resumen de barberos</th>
        </tr>
        <tr>
            <th colspan="4">Barbero</th>
            <th>Cantidad de servicios</th>
            <th>Total ventas</th>
        </tr>
        @foreach($barberos as $b)
        <tr>
            <td colspan="4">{{ $b->disponibilidad->persona->per_nombre ?? 'Sin asignar' }}</td>
            <td class="number">{{ $b->cantidad_servicios }}</td>
            <td class="currency">{{ number_format($b->total_ventas, 2, '.', '') }}</td>
        </tr>
        @endforeach
        <tr><td colspan="6"></td></tr>

        <!-- Servicios mas vendidos -->
        <tr>
            <th colspan="6" class="section-title">Servicios mas vendidos</th>
        </tr>
        <tr>
            <th colspan="5">Servicio</th>
            <th>Cantidad realizada</th>
        </tr>
        @foreach($serviciosMasVendidos as $s)
        <tr>
            <td colspan="5">{{ $s->servicios->serv_nombre ?? 'N/A' }}</td>
            <td class="number">{{ $s->cantidad }}</td>
        </tr>
        @endforeach
        <tr><td colspan="6"></td></tr>

        <!-- Productos mas vendidos -->
        @isset($productosMasVendidos)
        <tr>
            <th colspan="6" class="section-title">Productos mas vendidos</th>
        </tr>
        <tr>
            <th colspan="3">Producto</th>
            <th>Cantidad vendida</th>
            <th colspan="2">Ingreso total</th>
        </tr>
        @forelse($productosMasVendidos as $prod)
        <tr>
            <td colspan="3">{{ $prod->nombre ?? 'N/A' }}</td>
            <td class="number">{{ $prod->total_vendido }}</td>
            <td class="currency" colspan="2">{{ number_format($prod->ingreso_total, 2, '.', '') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">No hay productos vendidos en este período.</td>
        </tr>
        @endforelse
        @if(isset($productosMasVendidos) && $productosMasVendidos->count() > 0)
        <tr class="total-row">
            <td colspan="3">Total</td>
            <td class="number">{{ $productosMasVendidos->sum('total_vendido') }}</td>
            <td class="currency" colspan="2">{{ number_format($productosMasVendidos->sum('ingreso_total'), 2, '.', '') }}</td>
        </tr>
        @endif
        <tr><td colspan="6"></td></tr>
        @endisset

        <!-- Detalle de gastos -->
        <tr>
            <th colspan="6" class="section-title">Detalle de gastos</th>
        </tr>
        <tr>
            <th>Fecha</th>
            <th>Categoría</th>
            <th>Descripción</th>
            <th>Sede</th>
            <th>Monto</th>
            <th>Comprobante</th>
        </tr>
        @foreach($gastosDetalle as $gasto)
        <tr>
            <td class="date">{{ $gasto->fecha->format('Y-m-d') }}</td>
            <td>{{ $gasto->categoria->nombre ?? 'N/A' }}</td>
            <td>{{ $gasto->descripcion }}</td>
            <td>{{ $gasto->sede->sede_nombre ?? 'General' }}</td>
            <td class="currency">{{ number_format($gasto->monto, 2, '.', '') }}</td>
            <td>
                @if($gasto->comprobante)
                    {{ $gasto->comprobante }}
                @else
                    —
                @endif
            </td>
        </tr>
        @endforeach
        <tr><td colspan="6"></td></tr>

        <!-- Dias con mas turnos solicitados -->
        <tr>
            <th colspan="6" class="section-title">Dias con mas turnos solicitados</th>
        </tr>
        <tr>
            <th colspan="5">Dia</th>
            <th>Cantidad de turnos</th>
        </tr>
        @foreach($diasMasSolicitados as $d)
        <tr>
            <td colspan="5" class="date">{{ \Carbon\Carbon::parse($d->dia)->format('Y-m-d') }}</td>
            <td class="number">{{ $d->cantidad }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>