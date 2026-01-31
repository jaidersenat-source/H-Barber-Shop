@extends('barbero.layout')

@section('title', 'Mi Horario Semanal')

@section('content')
@vite(['resources/css/Barberos/horarios.css'])
<div class="card">
    <h2>Mi Horario de la Semana</h2>
    @if($disponibilidades->isEmpty())
        <p>No tienes horario asignado para esta semana.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hoy = date('Y-m-d');
                @endphp
                @foreach($disponibilidades as $disp)
                    @if($disp->dis_fecha >= $hoy)
                        <tr>
                            <td>{{ ucfirst($disp->dia) }}</td>
                            <td>{{ $disp->dis_fecha }}</td>
                            <td>{{ $disp->dis_hora_inicio }}</td>
                            <td>{{ $disp->dis_hora_fin }}</td>
                            <td>{{ $disp->dis_estado }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
