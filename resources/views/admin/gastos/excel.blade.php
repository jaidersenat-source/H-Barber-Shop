<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gastos {{ $desde }} al {{ $hasta }}</title>
</head>
<body>
<h2>Reporte de Gastos</h2>
<p>Período: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr style="background:#333;color:#fff;">
            <th>Fecha</th>
            <th>Categoría</th>
            <th>Descripción</th>
            <th>Sede</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gastos as $gasto)
        <tr>
            <td>{{ $gasto->fecha->format('d/m/Y') }}</td>
            <td>{{ $gasto->categoria->nombre }}</td>
            <td>{{ $gasto->descripcion }}</td>
            <td>{{ $gasto->sede->sed_nombre ?? 'General' }}</td>
            <td>{{ number_format($gasto->monto, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background:#eee;font-weight:bold;">
            <td colspan="4">TOTAL</td>
            <td>{{ number_format($gastos->sum('monto'), 2) }}</td>
        </tr>
    </tfoot>
</table>
</body>
</html>