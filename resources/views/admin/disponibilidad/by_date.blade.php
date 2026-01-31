@extends('admin.layout')

@section('content')
<div class="card">
    <h2>Disponibilidad para la fecha: {{ $date }} ({{ $weekdayName }})</h2>

    @if($horarios->isEmpty())
        <p>No hay disponibilidad para esta fecha.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Barbero</th>
                    <th>Día</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $h)
                    <tr>
                        <td>{{ $h->persona->per_nombre ?? $h->per_documento }}</td>
                        <td>{{ $h->dia }}</td>
                        <td>{{ $h->dis_fecha ?? 'Semanal' }}</td>
                        <td>{{ $h->dis_hora_inicio }}</td>
                        <td>{{ $h->dis_hora_fin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('disponibilidad.index') }}">Volver</a>
</div>
@endsection
