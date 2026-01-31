@extends('barbero.layout')

@section('title', 'Mis Turnos de la Semana')

@section('content')
@vite(['resources/css/Barberos/turnos/turnos.css'])
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;">
        <h2>Mis Turnos de la Semana</h2>
        <a href="{{ route('barbero.turnos.create') }}" class="btn btn-primary" style="font-weight:600;">+ Registrar nuevo turno</a>
    </div>
    <p><strong>Mi documento:</strong> {{ Auth::user()->persona->per_documento }}</p>
    @if($turnos->isEmpty())
        <p>No tienes turnos programados para esta semana.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Documento Turno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($turnos as $turno)
                    <tr>
                        <td>{{ $turno->tur_fecha }}</td>
                        <td>{{ $turno->tur_hora }}</td>
                        <td>{{ $turno->tur_nombre }}</td>
                        <td>{{ $turno->tur_estado }}</td>
                        <td>{{ $turno->tur_cedula }}</td>
                        <td>
                            <form action="{{ route('barbero.turnos.estado', $turno->tur_id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <select name="estado" onchange="this.form.submit()">
                                    <option value="" disabled selected>Cambiar estado</option>
                                    <option value="Realizado">Realizado</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Reprogramado">Reprogramado</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
