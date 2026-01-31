<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes CRM</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Listado de Clientes CRM</h2>
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Celular</th>
                <th>Visitas</th>
                <th>Última visita</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
            <tr>
                <td>{{ $c->tur_nombre }}</td>
                <td>{{ $c->tur_celular }}</td>
                <td>{{ $c->visitas }}</td>
                <td>{{ $c->ultima_visita }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
