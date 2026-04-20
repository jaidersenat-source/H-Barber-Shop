<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero</title>
</head>
<body>

<h2>Reporte Financiero H Barber Shop</h2>
<p>Período: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>

{{-- Resumen ejecutivo --}}
<h3>Resumen</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr style="background:#333;color:#fff;">
        <th>Concepto</th><th>Valor</th>
    </tr>
    <tr>
        <td>Total Ingresos</td>
        <td>{{ number_format($totalIngresos, 2) }}</td>
    </tr>
    <tr>
        <td>Total Gastos</td>
        <td>{{ number_format($totalGastos, 2) }}</td>
    </tr>
    <tr style="background:{{ $gananciaNeta >= 0 ? '#d4edda' : '#f8d7da' }};font-weight:bold;">
        <td>Ganancia Neta</td>
        <td>{{ number_format($gananciaNeta, 2) }}</td>
    </tr>
</table>

<br>

{{-- Gastos por categoría --}}
<h3>Gastos por Categoría</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr style="background:#555;color:#fff;">
            <th>Categoría</th><th>Cantidad</th><th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($gastosPorCategoria as $item)
        <tr>
            <td>{{ $item->categoria->nombre }}</td>
            <td>{{ $item->cantidad }}</td>
            <td>{{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

{{-- Detalle de gastos --}}
<h3>Detalle de Gastos</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr style="background:#555;color:#fff;">
            <th>Fecha</th><th>Categoría</th><th>Descripción</th><th>Sede</th><th>Monto</th>
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
</table>

</body>
</html>