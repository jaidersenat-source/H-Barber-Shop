@extends('barbero.layout')

@section('title', 'Mi Horario Semanal')

@section('content')
@vite(['resources/css/Barberos/horarios.css'])
<div class="horario-container" role="main" aria-label="Mi horario semanal">
    <div class="horario-header">
        <h2 tabindex="0">Mi Horario de la Semana</h2>
    </div>

    @if($disponibilidades->isEmpty())
        <div class="horario-empty" role="status" aria-live="polite">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p>No tienes horario asignado para esta semana.</p>
        </div>
    @else
        {{-- Tabla visible solo en desktop --}}
        <div class="tabla-desktop">
            <table class="table" role="table" aria-label="Horario semanal del barbero">
                <thead>
                    <tr>
                        <th scope="col">Dia</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora Inicio</th>
                        <th scope="col">Hora Fin</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hoy = date('Y-m-d');
                    @endphp
                    @foreach($disponibilidades as $disp)
                        @if($disp->dis_fecha >= $hoy)
                            <tr class="{{ $disp->dis_fecha == $hoy ? 'fila-hoy' : '' }}">
                                <td>{{ ucfirst($disp->dia) }}</td>
                                <td>{{ $disp->dis_fecha }}</td>
                                <td>{{ $disp->dis_hora_inicio }}</td>
                                <td>{{ $disp->dis_hora_fin }}</td>
                                <td>
                                    <span class="badge-estado badge-{{ strtolower($disp->dis_estado) }}">
                                        {{ $disp->dis_estado }}
                                    </span>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tarjetas visibles solo en movil --}}
        <div class="tarjetas-movil">
            @php
                $hoy = date('Y-m-d');
            @endphp
            @foreach($disponibilidades as $disp)
                @if($disp->dis_fecha >= $hoy)
                    <div class="tarjeta-horario {{ $disp->dis_fecha == $hoy ? 'tarjeta-hoy' : '' }}" role="article" aria-label="Horario del {{ ucfirst($disp->dia) }}">
                        <div class="tarjeta-top">
                            <span class="tarjeta-dia">{{ ucfirst($disp->dia) }}</span>
                            <span class="badge-estado badge-{{ strtolower($disp->dis_estado) }}">
                                {{ $disp->dis_estado }}
                            </span>
                        </div>
                        <div class="tarjeta-fecha">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ $disp->dis_fecha }}
                        </div>
                        <div class="tarjeta-horas">
                            <div class="tarjeta-hora">
                                <span class="hora-label">Inicio</span>
                                <span class="hora-valor">{{ $disp->dis_hora_inicio }}</span>
                            </div>
                            <div class="tarjeta-separador" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </div>
                            <div class="tarjeta-hora">
                                <span class="hora-label">Fin</span>
                                <span class="hora-valor">{{ $disp->dis_hora_fin }}</span>
                            </div>
                        </div>
                        @if($disp->dis_fecha == $hoy)
                            <div class="tarjeta-badge-hoy">Hoy</div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection