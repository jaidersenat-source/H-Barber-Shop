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
    </style>
</head>
<body>
    <table>
        <!-- Titulo principal -->
        <tr>
            <th colspan="3" class="section-title">Metricas principales</th>
        </tr>
        <tr>
            <td class="metric-label">Ventas totales</td>
            <td class="currency" colspan="2">{{ number_format($ventasTotales, 2, '.', '') }}</td>
        </tr>
        <tr>
            <td class="metric-label">Cantidad de cortes realizados</td>
            <td class="number" colspan="2">{{ $cantidadCortes }}</td>
        </tr>
        <tr><td colspan="3"></td></tr>

        <!-- Resumen de barberos -->
        <tr>
            <th colspan="3" class="section-title">Resumen de barberos</th>
        </tr>
        <tr>
            <th>Barbero</th>
            <th>Cantidad de servicios</th>
            <th>Total ventas</th>
        </tr>
        @foreach($barberos as $b)
        <tr>
            <td>{{ $b->disponibilidad->persona->per_nombre ?? 'Sin asignar' }}</td>
            <td class="number">{{ $b->cantidad_servicios }}</td>
            <td class="currency">{{ number_format($b->total_ventas, 2, '.', '') }}</td>
        </tr>
        @endforeach
        <tr><td colspan="3"></td></tr>

        <!-- Servicios mas vendidos -->
        <tr>
            <th colspan="3" class="section-title">Servicios mas vendidos</th>
        </tr>
        <tr>
            <th colspan="2">Servicio</th>
            <th>Cantidad realizada</th>
        </tr>
        @foreach($serviciosMasVendidos as $s)
        <tr>
            <td colspan="2">{{ $s->servicios->serv_nombre ?? 'N/A' }}</td>
            <td class="number">{{ $s->cantidad }}</td>
        </tr>
        @endforeach
        <tr><td colspan="3"></td></tr>

        <!-- Dias con mas turnos solicitados -->
        <tr>
            <th colspan="3" class="section-title">Dias con mas turnos solicitados</th>
        </tr>
        <tr>
            <th colspan="2">Dia</th>
            <th>Cantidad de turnos</th>
        </tr>
        @foreach($diasMasSolicitados as $d)
        <tr>
            <td colspan="2" class="date">{{ \Carbon\Carbon::parse($d->dia)->format('Y-m-d') }}</td>
            <td class="number">{{ $d->cantidad }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
