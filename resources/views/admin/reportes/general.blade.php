@extends('admin.layout')
@php(require_once(app_path('Helpers/num2words.php')))

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
                <span class="metrica-valor">
                    <span aria-hidden="true">{{ number_format($ventasTotales, 0) }}</span>
                    <span class="sr-only">{{ num2words($ventasTotales) }} pesos colombianos</span>
                </span>
            </li>
            <li class="metrica-card gastos">
                <span class="metrica-label">Gastos totales</span>
                <span class="metrica-valor">
                    <span aria-hidden="true">{{ number_format($gastosTotales, 0) }}</span>
                    <span class="sr-only">{{ num2words($gastosTotales) }} pesos colombianos</span>
                </span>
            </li>
            <li class="metrica-card ganancias">
                <span class="metrica-label">Ganancia neta</span>
                <span class="metrica-valor">
                    <span aria-hidden="true">{{ number_format($gananciaNeta, 0) }}</span>
                    <span class="sr-only">{{ num2words($gananciaNeta) }} pesos colombianos</span>
                </span>
            </li>
            <li class="metrica-card cortes">
                <span class="metrica-label">Cortes realizados</span>
                <span class="metrica-valor">
                    <span aria-hidden="true">{{ $cantidadCortes }}</span>
                    <span class="sr-only">{{ num2words($cantidadCortes) }} cortes realizados</span>
                </span>
            </li>
        </ul>

        {{-- Tabla de barberos --}}
        <section class="reporte-seccion" aria-labelledby="barberos-titulo">
            <h4 id="barberos-titulo">Resumen por barbero</h4>
            <ul class="sr-only" aria-label="Lista de barberos detallada">
                @forelse($barberos as $barbero)
                <li>
                    <strong>Barbero:</strong> {{ $barbero->disponibilidad->persona->per_nombre ?? '' }} {{ $barbero->disponibilidad->persona->per_apellido ?? '' }}<br>
                    <strong>Servicios realizados:</strong> {{ $barbero->cantidad_servicios }}<br>
                    <strong>Total ventas:</strong> <span aria-hidden="true">${{ number_format($barbero->total_ventas, 0) }}</span><span class="sr-only">{{ num2words((int)$barbero->total_ventas) }} pesos colombianos</span>
                </li>
                @empty
                <li>No hay datos de barberos en este período.</li>
                @endforelse
                @if($barberos->count() > 0)
                <li>
                    <strong>Total servicios realizados:</strong> {{ $barberos->sum('cantidad_servicios') }}<br>
                    <strong>Total ventas:</strong> <span aria-hidden="true">{{ number_format($barberos->sum('total_ventas'), 0) }}</span><span class="sr-only">{{ num2words((int)$barberos->sum('total_ventas')) }} pesos colombianos</span>
                </li>
                @endif
            </ul>

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
                        <td class="moneda" aria-label="{{ num2words((int)$barberos->sum('total_ventas')) }} pesos colombianos"><span aria-hidden="true">${{ number_format($barberos->sum('total_ventas'), 0) }}</span></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </section>

        {{-- Tabla de servicios más vendidos --}}
        <section class="reporte-seccion" aria-labelledby="servicios-titulo">
            <h4 id="servicios-titulo">Servicios más vendidos</h4>
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

        {{-- ══ Tabla de productos más vendidos ══ --}}
        @isset($productosMasVendidos)
        <section class="reporte-seccion" aria-labelledby="productos-titulo">
            <h4 id="productos-titulo">Productos más vendidos</h4>

            <ul class="sr-only" aria-label="Lista de productos más vendidos detallada">
                @forelse($productosMasVendidos as $prod)
                <li>
                    <strong>Producto:</strong> {{ $prod->nombre ?? 'N/A' }}<br>
                    <strong>Cantidad vendida:</strong> {{ $prod->total_vendido }}<br>
                    <strong>Ingreso total:</strong>
                    <span aria-hidden="true">${{ number_format($prod->ingreso_total, 0, ',', '.') }}</span>
                    <span class="sr-only">{{ num2words((int)$prod->ingreso_total) }} pesos colombianos</span>
                </li>
                @empty
                <li>No hay productos vendidos en este período.</li>
                @endforelse
            </ul>

            <table class="tabla-reporte" aria-hidden="true">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="num">Cantidad vendida</th>
                        <th class="num">Ingreso total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productosMasVendidos as $prod)
                        <tr>
                            <td>{{ $prod->nombre ?? 'N/A' }}</td>
                            <td class="num">{{ $prod->total_vendido }}</td>
                            <td class="moneda"
                                aria-label="{{ num2words((int)$prod->ingreso_total) }} pesos colombianos">
                                <span aria-hidden="true">${{ number_format($prod->ingreso_total, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr class="fila-vacia">
                            <td colspan="3">No hay productos vendidos en este período.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if(isset($productosMasVendidos) && $productosMasVendidos->count() > 0)
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <td class="num">{{ $productosMasVendidos->sum('total_vendido') }}</td>
                        <td class="moneda"
                            aria-label="{{ num2words((int)$productosMasVendidos->sum('ingreso_total')) }} pesos colombianos">
                            <span aria-hidden="true">${{ number_format($productosMasVendidos->sum('ingreso_total'), 0, ',', '.') }}</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>

            {{-- Enlace para exportar solo productos --}}
            @if(isset($productosMasVendidos) && $productosMasVendidos->count() > 0)
            <div class="btn-group" style="margin-top:12px;" role="group" aria-label="Exportar productos más vendidos">

            </div>
            @endif
        </section>
        @endisset

        {{-- Tabla de gastos detallados --}}
        <section class="reporte-seccion" aria-labelledby="gastos-titulo">
            <h4 id="gastos-titulo">Detalle de gastos</h4>
            <ul class="sr-only" aria-label="Lista de gastos detallada">
                @forelse($gastosDetalle as $gasto)
                <li>
                    <strong>Fecha:</strong> {{ $gasto->fecha->format('d/m/Y') }} |
                    <strong>Categoría:</strong> {{ $gasto->categoria->nombre ?? 'N/A' }} |
                    <strong>Descripción:</strong> {{ $gasto->descripcion }} |
                    <strong>Monto:</strong> <span aria-hidden="true">{{ number_format($gasto->monto, 0, ',', '.') }}</span><span class="sr-only">{{ num2words($gasto->monto) }} pesos colombianos</span> |
                    <strong>Sede:</strong> {{ $gasto->sede->sede_nombre ?? 'General' }}
                </li>
                @empty
                <li>No hay gastos registrados en este período.</li>
                @endforelse
            </ul>
            <table class="tabla-reporte" aria-hidden="true">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Sede</th>
                        <th class="num">Monto</th>
                        <th>Comprobante</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gastosDetalle as $gasto)
                    <tr>
                        <td>{{ $gasto->fecha->format('d/m/Y') }}</td>
                        <td>{{ $gasto->categoria->nombre ?? 'N/A' }}</td>
                        <td>{{ $gasto->descripcion }}</td>
                        <td>{{ $gasto->sede->sede_nombre ?? 'General' }}</td>
                        <td class="moneda" aria-label="{{ num2words((int)$gasto->monto) }} pesos colombianos"><span aria-hidden="true">{{ number_format($gasto->monto, 0, ',', '.') }}</span></td>
                        <td>
                            @if($gasto->comprobante)
                                <a href="{{ Storage::url($gasto->comprobante) }}" target="_blank" rel="noopener" class="btn-comprobante" aria-label="Ver comprobante de {{ $gasto->descripcion }}">
                                    <span aria-hidden="true">📎</span> Ver
                                </a>
                            @else
                                <span class="sin-comprobante">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="fila-vacia">
                        <td colspan="6">No hay gastos registrados en este período.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- Tabla de días con más turnos --}}
        <section class="reporte-seccion" aria-labelledby="dias-titulo">
            <h4 id="dias-titulo">Días con más turnos solicitados</h4>
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