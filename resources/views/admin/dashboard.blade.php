@extends('admin.layout')

@section('title', 'Dashboard CRM')

@section('content')
@vite(['resources/css/Admin/dashboard.css'])

@auth
<div class="dashboard-container">
    <div class="sr-only" aria-live="polite">Bienvenido al panel principal. Aquí puedes consultar los datos clave de tu barbería.</div>
    <h1 class="dashboard-title" tabindex="0">Dashboard CRM</h1>
    <section class="stats-section" aria-label="Resumen de datos">
        <div class="stat-card stat-card--clientes" role="region" aria-label="Clientes totales">
            <span class="stat-label">Clientes Totales</span>
            <span class="stat-value stat-value--clientes" aria-live="polite">{{ $clientesTotales }}</span>
        </div>
        <div class="stat-card stat-card--pendientes" role="region" aria-label="Turnos pendientes">
            <span class="stat-label">Turnos Pendientes</span>
            <span class="stat-value stat-value--pendientes" aria-live="polite">{{ $turnosPendientes }}</span>
        </div>
        <div class="stat-card stat-card--realizados" role="region" aria-label="Turnos realizados">
            <span class="stat-label">Turnos Realizados</span>
            <span class="stat-value stat-value--realizados" aria-live="polite">{{ $turnosRealizados }}</span>
        </div>
        <div class="stat-card stat-card--ingresos" role="region" aria-label="Ingresos del mes">
            <span class="stat-label">Ingresos del mes</span>
            <span class="stat-value stat-value--ingresos" aria-live="polite"><span class="sr-only">Pesos colombianos </span>COP ${{ number_format($ingresosMes, 0) }}</span>
        </div>
    </section>
    <div style="margin-top:40px;">
        <div class="dashboard-section">
            <h3 class="section-title">Servicios más vendidos</h3>
            @if(count($serviciosTop) == 0)
                <p class="section-empty">No hay datos aún.</p>
            @else
                <ul class="sr-only">
                    @foreach($serviciosTop as $s)
                        <li>Servicio más vendido: {{ $s->serv_nombre }}, ventas: {{ $s->total }}</li>
                    @endforeach
                </ul>
                <table class="dashboard-table" aria-label="Servicios más vendidos" aria-hidden="true">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Ventas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviciosTop as $s)
                        <tr>
                            <td>{{ $s->serv_nombre }}</td>
                            <td>{{ $s->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="dashboard-section">
            <h3 class="section-title">Clientes frecuentes</h3>
            @if(count($clientesFrecuentes) == 0)
                <p class="section-empty">No hay datos aún.</p>
            @else
                <ul class="sr-only">
                    @foreach($clientesFrecuentes as $c)
                        <li>Cliente frecuente: {{ $c->tur_nombre }}, visitas: {{ $c->visitas }}</li>
                    @endforeach
                </ul>
                <table class="dashboard-table" aria-label="Clientes frecuentes" aria-hidden="true">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Visitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientesFrecuentes as $c)
                        <tr>
                            <td>{{ $c->tur_nombre }}</td>
                            <td>{{ $c->visitas }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endauth
@endsection
