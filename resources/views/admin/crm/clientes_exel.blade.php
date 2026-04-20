@php echo "\xEF\xBB\xBF"; @endphp
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 12px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #1e3a5f; color: #fff; font-weight: bold; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .titulo { font-size: 18px; font-weight: bold; color: #1e3a5f; padding: 16px 0; text-align: center; }
        .subtitulo { font-size: 14px; color: #2c5282; padding-bottom: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="titulo">Reporte de Clientes CRM</div>
    <div class="subtitulo">Listado detallado de clientes, visitas, gastos y servicios realizados</div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Celular</th>
                <th>Visitas</th>
                <th>Última visita</th>
                <th>Gasto total</th>
                <th>Servicios/Cortes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
            <tr>
                <td>{{ $c->tur_nombre }}</td>
                <td>{{ $c->tur_cedula }}</td>
                <td>{{ $c->tur_celular }}</td>
                <td style="text-align:center">{{ $c->visitas }}</td>
                <td>{{ $c->ultima_visita }}</td>
                <td style="text-align:right">${{ number_format($c->gasto_total, 0, ',', '.') }}</td>
                <td>
                    @if(count($c->servicios))
                        <ul style="margin:0; padding-left:18px;">
                        @foreach($c->servicios as $servicio)
                            <li>{{ $servicio->serv_nombre }} <span style="color:#888">({{ $servicio->cantidad }})</span></li>
                        @endforeach
                        </ul>
                    @else
                        <span style="color:#888">Sin servicios</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>