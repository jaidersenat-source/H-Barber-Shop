@extends('barbero.layout')

@section('content')
@vite(['resources/css/Barberos/dashboard.css'])
<main id="main-content" class="barbero-dashboard">
    <header class="dashboard-header">
        <h1 class="dashboard-title">Panel del Barbero</h1>
        <p class="welcome-text">Bienvenido, <strong>{{ Auth::user()->persona->per_nombre }}</strong></p>
    </header>

    <section class="performance-section" aria-labelledby="performance-heading">
        <h2 id="performance-heading" class="section-title">Rendimiento de la Semana</h2>
        
        <div class="stats-grid">
            <!-- Cortes realizados -->
            <div class="stat-card stat-primary">
                <div class="stat-icon" aria-hidden="true">✂</div>
                <div class="stat-content">
                    <span class="stat-label">Cortes realizados</span>
                    <span class="stat-value">{{ $totalCortes }}</span>
                </div>
            </div>

            <!-- Total de servicios -->
            <div class="stat-card stat-secondary">
                <div class="stat-icon" aria-hidden="true">📋</div>
                <div class="stat-content">
                    <span class="stat-label">Total de servicios</span>
                    <span class="stat-value">{{ $totalServicios }}</span>
                </div>
            </div>

            <!-- Ganancia barbero -->
            <div class="stat-card stat-success">
                <div class="stat-icon" aria-hidden="true">💰</div>
                <div class="stat-content">
                    <span class="stat-label">Tu ganancia (50%)</span>
                    <span class="stat-value">${{ number_format($totalGanado, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

        <!-- Desglose de servicios -->
        <div class="services-breakdown">
            <h3 class="breakdown-title">Desglose de Servicios Realizados</h3>
            <ul class="services-list" role="list">
                @foreach($servicios as $nombre => $cantidad)
                    <li class="service-item">
                        <span class="service-name">{{ $nombre }}</span>
                        <span class="service-count">
                            <span class="sr-only">Cantidad:</span>
                            {{ $cantidad }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</main>
@endsection
