@extends('admin.layout')

@section('content')
<div class="card" role="main" aria-label="Disponibilidad por fecha">
    <h2 tabindex="0">Disponibilidad para la fecha: {{ $date }} ({{ $weekdayName }})</h2>

    @if($horarios->isEmpty())
        <p role="status">No hay disponibilidad para esta fecha.</p>
    @else
        <table role="table" aria-label="Disponibilidad para {{ $date }}">
            <thead>
                <tr>
                    <th scope="col">Barbero</th>
                    <th scope="col">Día</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora Inicio</th>
                    <th scope="col">Hora Fin</th>
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

    <a href="{{ route('disponibilidad.index') }}" aria-label="Volver al listado de disponibilidad">Volver</a>
</div>
@endsection
