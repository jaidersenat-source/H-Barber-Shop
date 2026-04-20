@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/gastos/gastos.css'])

<main id="modulo-gastos" class="reportes-container" role="main" aria-labelledby="gastos-titulo">

    <div class="modulo-header">
        <h2 id="gastos-titulo">Gestión de Gastos</h2>
        <div class="header-acciones">
            <a href="{{ route('admin.gastos.create') }}" class="btn btn-primary">
                <span aria-hidden="true">➕</span> Registrar gasto
            </a>
            @can('categorias_gastos.ver')
            <a href="{{ route('admin.categorias-gastos.index') }}" class="btn btn-secundario">
                <span aria-hidden="true">🏷️</span> Categorías
            </a>
            @endcan
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alerta alerta-ok" role="alert" aria-live="polite">
            <span aria-hidden="true">✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alerta alerta-error" role="alert" aria-live="polite">
            <span aria-hidden="true">❌</span> {{ session('error') }}
        </div>
    @endif

    {{-- Formulario de filtros (igual patrón que reportes) --}}
    <form method="GET" action="{{ route('admin.gastos.index') }}"
          class="reporte-form" role="search" aria-label="Filtrar gastos">

        <div class="form-group">
            <label for="desde">Fecha inicial</label>
            <input type="date" name="desde" id="desde" value="{{ $desde }}">
        </div>

        <div class="form-group">
            <label for="hasta">Fecha final</label>
            <input type="date" name="hasta" id="hasta" value="{{ $hasta }}">
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" id="categoria_id">
                <option value="">Todas</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}"
                        {{ $categoriaId == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="sede_id">Sede</label>
            <select name="sede_id" id="sede_id">
                <option value="">Todas</option>
                @foreach($sedes as $sede)
                    <option value="{{ $sede->id }}"
                        {{ $sedeId == $sede->id ? 'selected' : '' }}>
                        {{ $sede->sed_nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="busqueda">Descripción</label>
            <input type="text" name="busqueda" id="busqueda"
                   placeholder="Buscar..." value="{{ $busqueda }}">
        </div>

        <div class="btn-group" role="group" aria-label="Acciones de filtro">
            <button type="submit">
                <span aria-hidden="true">🔍</span> Filtrar
            </button>
            <a href="{{ route('admin.gastos.index') }}" class="btn btn-secundario">
                <span aria-hidden="true">🔄</span> Limpiar
            </a>
            <a href="{{ route('admin.gastos.excel', request()->all()) }}"
               class="btn btn-excel" target="_blank" rel="noopener"
               aria-label="Exportar gastos a Excel">
                <span aria-hidden="true">📊</span> Excel
            </a>
            @can('reporte_financiero.ver')
            <a href="{{ route('admin.gastos.reporte-financiero', request()->all()) }}"
               class="btn btn-excel" target="_blank" rel="noopener"
               aria-label="Descargar reporte financiero completo">
                <span aria-hidden="true">💰</span> Reporte Financiero
            </a>
            @endcan
        </div>
    </form>

    {{-- Tarjeta resumen --}}
    <section class="reporte-metricas" aria-labelledby="resumen-titulo">
        <h3 id="resumen-titulo" class="sr-only">Resumen de gastos</h3>
        <ul class="metricas-principales" role="list">
            <li class="metrica-card ventas">
                <span class="metrica-label">Total gastos período</span>
                <span class="metrica-valor">
                    {{ $totalGastos }} pesos colombianos
                </span>
            </li>
            <li class="metrica-card cortes">
                <span class="metrica-label">Registros encontrados</span>
                <span class="metrica-valor">{{ $gastos->total() }}</span>
            </li>
        </ul>
    </section>

    {{-- Tabla de gastos --}}
    <section class="reporte-seccion" aria-labelledby="tabla-titulo">
        <h3 id="tabla-titulo">Listado de gastos</h3>

        {{-- Lista accesible para lectores de pantalla --}}
        <ul class="sr-only" aria-label="Lista de gastos detallada">
            @forelse($gastos as $gasto)
            <li>
                <strong>Fecha:</strong> {{ $gasto->fecha->format('d/m/Y') }} |
                <strong>Categoría:</strong> {{ $gasto->categoria->nombre }} |
                <strong>Descripción:</strong> {{ $gasto->descripcion }} |
                <strong>Monto:</strong> {{ $gasto->monto }} pesos colombianos |
                <strong>Sede:</strong> {{ $gasto->sede->sed_nombre ?? 'General' }}
                @if($gasto->comprobante)
                    | <strong>Comprobante:</strong>
                    <a href="{{ Storage::url($gasto->comprobante) }}"
                       target="_blank" rel="noopener"
                       aria-label="Ver comprobante de {{ $gasto->descripcion }}">
                        Ver comprobante
                    </a>    
                @else
                    | <strong>Comprobante:</strong> No disponible
                @endif
                | <strong>Acciones:</strong>
                <a href="{{ route('admin.gastos.edit', $gasto) }}"
                   class="btn-ver" aria-label="Editar gasto {{ $gasto->descripcion }}">
                    Editar
                </a>
                <button type="button"
                        class="btn-ver btn-delete"
                        data-gasto-id="{{ $gasto->id }}"
                        data-gasto-descripcion="{{ $gasto->descripcion }}"
                        data-gasto-action="{{ route('admin.gastos.destroy', $gasto) }}"
                        aria-label="Eliminar gasto {{ $gasto->descripcion }}">
                    Eliminar
                </button>
            </li>
            @empty
            <li>No hay gastos en este período.</li>
            @endforelse
        </ul>

        {{-- Tabla visual --}}
        <table class="tabla-reporte" aria-hidden="true">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Sede</th>
                    <th class="num">Monto</th>
                    <th>Comprobante</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gastos as $gasto)
                <tr>
                    <td>{{ $gasto->fecha->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge-categoria">{{ $gasto->categoria->nombre }}</span>
                    </td>
                    <td>{{ $gasto->descripcion }}</td>
                    <td>{{ $gasto->sede->sed_nombre ?? 'General' }}</td>
                    <td class="moneda">${{ number_format($gasto->monto, 0, ',', '.') }}</td>
                    <td>
                        @if($gasto->comprobante)
                            <a href="{{ Storage::url($gasto->comprobante) }}"
                               target="_blank" rel="noopener"
                               class="btn-comprobante"
                               aria-label="Ver comprobante de {{ $gasto->descripcion }}">
                                <span aria-hidden="true">📎</span> Ver
                            </a>
                        @else
                            <span class="sin-comprobante">—</span>
                        @endif
                    </td>
                    
                    <td class="acciones-col">
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <a href="{{ route('admin.gastos.edit', $gasto) }}"
                               class="btn-action btn-edit"
                               aria-label="Editar gasto {{ $gasto->descripcion }}">
                                    Editar
                                </a>
                                <button type="button"
                                        class="btn-action btn-delete"
                                        data-gasto-id="{{ $gasto->id }}"
                                        data-gasto-descripcion="{{ $gasto->descripcion }}"
                                        data-gasto-action="{{ route('admin.gastos.destroy', $gasto) }}"
                                        aria-label="Eliminar gasto {{ $gasto->descripcion }}">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                </tr>
                @empty
                <tr class="fila-vacia">
                    <td colspan="7">No hay gastos registrados en este período.</td>
                </tr>
                @endforelse
            </tbody>
            @if($gastos->count() > 0)
            <tfoot>
                <tr>
                    <th colspan="4">Total período</th>
                    <td class="moneda">${{ number_format($totalGastos, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>

        {{-- Paginación --}}
        <div class="paginacion" aria-label="Paginación de gastos">
            {{ $gastos->links() }}
        </div>
    </section>


<!-- Modal de confirmación de eliminación -->
<div id="modal-eliminar-gasto" class="modal-eliminar" role="dialog" aria-modal="true" aria-labelledby="modal-eliminar-titulo" aria-hidden="true" tabindex="-1">
    <div class="modal-contenido">
        <h4 id="modal-eliminar-titulo">Confirmar eliminación</h4>
        <p>¿Estás seguro de que deseas eliminar el gasto <strong id="gasto-descripcion-eliminar"></strong>?</p>
        <form id="form-eliminar-gasto" method="POST" action="">
            @csrf @method('DELETE')
            <div class="modal-acciones">
                <button type="button" id="btn-cancelar-eliminar-gasto" class="btn btn-secundario">Cancelar</button>
                <button type="submit" id="btn-confirmar-eliminar-gasto" class="btn btn-delete">Eliminar</button>
            </div>
        </form>
    </div>
</div>

</main>

<script>
   
document.addEventListener('DOMContentLoaded', function () {
    let gastoIdAEliminar = null;
    const modal = document.getElementById('modal-eliminar-gasto');
    const form = document.getElementById('form-eliminar-gasto');
    const btnCancelar = document.getElementById('btn-cancelar-eliminar-gasto');
    const btnConfirmar = document.getElementById('btn-confirmar-eliminar-gasto');
    const descripcionSpan = document.getElementById('gasto-descripcion-eliminar');

    document.querySelectorAll('.btn-delete[data-gasto-id]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            gastoIdAEliminar = this.getAttribute('data-gasto-id');
            const descripcion = this.getAttribute('data-gasto-descripcion');
            const action = this.getAttribute('data-gasto-action');
            form.action = action;
            descripcionSpan.textContent = descripcion;
            modal.classList.add('show');
            modal.removeAttribute('aria-hidden');
            btnConfirmar.focus();
        });
    });

    btnCancelar.addEventListener('click', function () {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    });

    // Cerrar modal con Escape
    document.addEventListener('keydown', function (e) {
        if (modal.classList.contains('show') && e.key === 'Escape') {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        }
    });

    // Evitar submit doble
    form.addEventListener('submit', function () {
        btnConfirmar.disabled = true;
    });
});
</script>

<style>
.sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }
.modal-eliminar {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0; width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
}
.modal-eliminar.show {
    display: flex;
}
.modal-contenido {
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 2px 16px rgba(0,0,0,0.2);
    text-align: center;
}
.modal-acciones {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 1.5rem;
}
</style>
@endsection