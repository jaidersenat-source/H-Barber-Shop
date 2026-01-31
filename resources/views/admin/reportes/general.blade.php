@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/reportes.css'])
<main id="modulo-reporte-general" class="reportes-container" role="main" aria-labelledby="reporte-titulo">
    <h2 id="reporte-titulo">Reporte General</h2>

    {{-- Anuncio para lectores de pantalla --}}
    <div role="status" aria-live="polite" class="sr-only" id="reporte-status"></div>

    {{-- Formulario de filtros --}}
    <form method="GET" action="" class="reporte-form" role="search" aria-label="Filtrar reporte por fechas">
        <div class="form-group">
            <label for="desde">Fecha inicial</label>
            <input 
                type="date" 
                name="desde" 
                id="desde" 
                value="{{ $desde }}" 
                required
                aria-required="true"
                aria-describedby="desde-desc"
            >
            <span id="desde-desc" class="sr-only">Seleccione la fecha de inicio del período a reportar</span>
        </div>

        <div class="form-group">
            <label for="hasta">Fecha final</label>
            <input 
                type="date" 
                name="hasta" 
                id="hasta" 
                value="{{ $hasta }}" 
                required
                aria-required="true"
                aria-describedby="hasta-desc"
            >
            <span id="hasta-desc" class="sr-only">Seleccione la fecha de fin del período a reportar</span>
        </div>

        <div class="btn-group" role="group" aria-label="Acciones del reporte">
            <button type="submit">
                <span aria-hidden="true">🔍</span>
                Generar reporte
            </button>
            <a 
                href="{{ route('admin.reportes.general.pdf', request()->all()) }}" 
                class="btn btn-pdf"
                target="_blank"
                rel="noopener"
                aria-label="Descargar reporte en formato PDF, se abre en nueva ventana"
            >
                <span aria-hidden="true">📄</span>
                Descargar PDF
            </a>
            <a 
                href="{{ route('admin.reportes.general.excel', request()->all()) }}" 
                class="btn btn-excel"
                target="_blank"
                rel="noopener"
                aria-label="Descargar reporte en formato Excel, se abre en nueva ventana"
            >
                <span aria-hidden="true">📊</span>
                Descargar Excel
            </a>
        </div>
    </form>

    {{-- Sección de métricas --}}
    <section class="reporte-metricas" aria-labelledby="metricas-titulo">
        <h3 id="metricas-titulo">Métricas principales</h3>

        {{-- Tarjetas de resumen --}}
        <ul class="metricas-principales" role="list" aria-label="Resumen de métricas">
            <li class="metrica-card ventas">
                <span class="metrica-label">Ventas totales</span>
                <span class="metrica-valor" aria-label="Ventas totales: {{ number_format($ventasTotales, 0) }} pesos">
                    ${{ number_format($ventasTotales, 0) }}
                </span>
            </li>
            <li class="metrica-card cortes">
                <span class="metrica-label">Cortes realizados</span>
                <span class="metrica-valor" aria-label="Cantidad de cortes realizados: {{ $cantidadCortes }}">
                    {{ $cantidadCortes }}
                </span>
            </li>
        </ul>

        {{-- Tabla de barberos --}}
        <section class="reporte-seccion" aria-labelledby="barberos-titulo">
            <h4 id="barberos-titulo">Resumen por barbero</h4>
            <!-- Lista vertical accesible para lectores de pantalla -->
            <ul class="sr-only" aria-label="Lista de barberos detallada">
                @forelse($barberos as $barbero)
                <li>
                    <strong>Barbero:</strong> {{ $barbero->disponibilidad->persona->per_nombre ?? '' }} {{ $barbero->disponibilidad->persona->per_apellido ?? '' }}<br>
                    <strong>Servicios realizados:</strong> {{ $barbero->cantidad_servicios }}<br>
                    <strong>Total ventas:</strong> ${{ number_format($barbero->total_ventas, 0) }}
                </li>
                @empty
                <li>No hay datos de barberos en este período.</li>
                @endforelse
                @if($barberos->count() > 0)
                <li>
                    <strong>Total servicios realizados:</strong> {{ $barberos->sum('cantidad_servicios') }}<br>
                    <strong>Total ventas:</strong> ${{ number_format($barberos->sum('total_ventas'), 0) }}
                </li>
                @endif
            </ul>

            <!-- Tabla visual solo para usuarios videntes -->
            <table class="tabla-reporte" aria-hidden="true">
                <thead>
                    <tr>
                        <th>Barbero</th>
                        <th class="num">Servicios realizados</th>
                        <th class="num">Total ventas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barberos as $barbero)
                        <tr>
                            <td>{{ $barbero->disponibilidad->persona->per_nombre ?? '' }} {{ $barbero->disponibilidad->persona->per_apellido ?? '' }}</td>
                            <td class="num">{{ $barbero->cantidad_servicios }}</td>
                            <td class="moneda">${{ number_format($barbero->total_ventas, 0) }}</td>
                        </tr>
                    @empty
                        <tr class="fila-vacia">
                            <td colspan="3">No hay datos de barberos en este período.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($barberos->count() > 0)
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <td class="num">{{ $barberos->sum('cantidad_servicios') }}</td>
                        <td class="moneda">${{ number_format($barberos->sum('total_ventas'), 0) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </section>

        {{-- Tabla de servicios más vendidos --}}
        <section class="reporte-seccion" aria-labelledby="servicios-titulo">
            <h4 id="servicios-titulo">Servicios más vendidos</h4>
            <!-- Lista vertical accesible para lectores de pantalla -->
            <ul class="sr-only" aria-label="Lista de servicios más vendidos detallada">
                @forelse($serviciosMasVendidos as $index => $serv)
                <li>
                    <strong>Servicio:</strong> {{ $serv->servicios->serv_nombre ?? $serv->serv_nombre ?? 'N/A' }}<br>
                    <strong>Cantidad realizada:</strong> {{ $serv->cantidad }}
                </li>
                @empty
                <li>No hay datos de servicios en este período.</li>
                @endforelse
            </ul>

            <!-- Tabla visual solo para usuarios videntes -->
            <table class="tabla-reporte" aria-hidden="true">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th class="num">Cantidad realizada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviciosMasVendidos as $index => $serv)
                        <tr>
                            <td>{{ $serv->servicios->serv_nombre ?? $serv->serv_nombre ?? 'N/A' }}</td>
                            <td class="num">{{ $serv->cantidad }}</td>
                        </tr>
                    @empty
                        <tr class="fila-vacia">
                            <td colspan="2">No hay datos de servicios en este período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- Tabla de días con más turnos --}}
        <section class="reporte-seccion" aria-labelledby="dias-titulo">
            <h4 id="dias-titulo">Días con más turnos solicitados</h4>
            <!-- Lista vertical accesible para lectores de pantalla -->
            <ul class="sr-only" aria-label="Lista de días con más turnos detallada">
                @forelse($diasMasSolicitados as $index => $dia)
                <li>
                    <strong>Día:</strong>
                        <span aria-describedby="dia-mas-turnos-lista-{{ $index }}">{{ \Carbon\Carbon::parse($dia->dia)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</span>
                        <span id="dia-mas-turnos-lista-{{ $index }}" class="sr-only">
                            {{ \Carbon\Carbon::parse($dia->dia)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                        </span><br>
                    <strong>Cantidad de turnos:</strong> {{ $dia->cantidad }}
                </li>
                @empty
                <li>No hay datos de turnos en este período.</li>
                @endforelse
            </ul>

            <!-- Tabla visual solo para usuarios videntes -->
            <table class="tabla-reporte" aria-hidden="true">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th class="num">Cantidad de turnos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diasMasSolicitados as $index => $dia)
                        <tr>
                            <td>
                                <span aria-describedby="dia-mas-turnos-tabla-{{ $index }}">{{ \Carbon\Carbon::parse($dia->dia)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</span>
                                <span id="dia-mas-turnos-tabla-{{ $index }}" class="sr-only">
                                    {{ \Carbon\Carbon::parse($dia->dia)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                                </span>
                            </td>
                            <td class="num">{{ $dia->cantidad }}</td>
                        </tr>
                    @empty
                        <tr class="fila-vacia">
                            <td colspan="2">No hay datos de turnos en este período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </section>
</main>

{{-- Clase sr-only para textos solo de lector de pantalla --}}
<style>
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}
</style>
@endsection
<script>
// Navegación accesible con flechas y Tab para el módulo Reporte General
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-reporte-general');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;
    let current = 0;
    focusables[0].focus();
    modulo.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Focus trap
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.shiftKey) {
                if (document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                if (document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            }
        } else if (["ArrowDown", "ArrowRight"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let next = (current + 1) % focusables.length;
                focusables[next].focus();
            }
        } else if (["ArrowUp", "ArrowLeft"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let prev = (current - 1 + focusables.length) % focusables.length;
                focusables[prev].focus();
            }
        } else if (e.key === 'Escape') {
            const menu = document.querySelector('.sidebar a');
            if (menu) menu.focus();
        }
    });
});
</script>
