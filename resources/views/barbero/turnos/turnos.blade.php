@extends('barbero.layout')

@section('title', 'Mis Turnos de la Semana')

@section('content')
@vite(['resources/css/Barberos/turnos/turnos.css'])

<div class="turnos-container" role="main" aria-label="Mis turnos de la semana">

    {{-- Encabezado --}}
    <div class="turnos-header">
        <h2 tabindex="0">Mis Turnos</h2>
        <p class="turnos-doc"><strong>Doc:</strong> {{ Auth::user()->persona->per_documento }}</p>
        <a href="{{ route('barbero.turnos.create') }}" class="btn-nuevo-turno" aria-label="Registrar nuevo turno">
            + Nuevo turno
        </a>
    </div>

    @if($turnos->isEmpty())
        <div class="turnos-vacio" role="status" aria-live="polite">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p>No tienes turnos esta semana.</p>
        </div>
    @else

        {{-- Lista de tarjetas (visible en mobile, oculta en desktop) --}}
        <div class="turnos-cards">
            @foreach($turnos as $turno)
                <div class="turno-card" role="article" aria-label="Turno de {{ $turno->tur_nombre }}">
                    {{-- Fila superior: fecha/hora + estado --}}
                    <div class="turno-card-top">
                        <div class="turno-fecha-hora">
                            <span class="turno-fecha">{{ \Carbon\Carbon::parse($turno->tur_fecha)->translatedFormat('D d M') }}</span>
                            <span class="turno-hora">{{ $turno->tur_hora }}</span>
                        </div>
                        <span class="turno-estado turno-estado--{{ strtolower($turno->tur_estado) }}">
                            {{ $turno->tur_estado }}
                        </span>
                    </div>

                    {{-- Info del cliente --}}
                    <div class="turno-cliente">
                        <span class="turno-cliente-nombre">{{ $turno->tur_nombre }}</span>
                        <span class="turno-cliente-doc">CC {{ $turno->tur_cedula }}</span>
                    </div>

                    {{-- Acción rápida --}}
                    <form action="{{ route('barbero.turnos.estado', $turno->tur_id) }}" method="POST" class="turno-accion">
                        @csrf
                        <select name="estado" onchange="this.form.submit()" aria-label="Cambiar estado del turno">
                            <option value="" disabled selected>Cambiar estado</option>
                            <option value="Realizado">Realizado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Reprogramado">Reprogramado</option>
                        </select>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Tabla (visible solo en desktop) --}}
        <div class="turnos-tabla-wrapper">
            <table class="turnos-tabla" role="table" aria-label="Listado de turnos de la semana">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turnos as $turno)
                        <tr>
                            <td>{{ $turno->tur_fecha }}</td>
                            <td>{{ $turno->tur_hora }}</td>
                            <td>{{ $turno->tur_nombre }}</td>
                            <td>
                                <span class="turno-estado turno-estado--{{ strtolower($turno->tur_estado) }}">
                                    {{ $turno->tur_estado }}
                                </span>
                            </td>
                            <td>{{ $turno->tur_cedula }}</td>
                            <td>
                                <form action="{{ route('barbero.turnos.estado', $turno->tur_id) }}" method="POST">
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
        </div>

    @endif
</div>
@endsection