@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/gastos.css'])

<main id="modulo-categorias" class="reportes-container" role="main" aria-labelledby="cat-titulo">

    <div class="modulo-header">
        <h2 id="cat-titulo">Categorías de Gastos</h2>
        <div class="header-acciones">
            @can('categorias_gastos.crear')
            <a href="{{ route('admin.categorias-gastos.create') }}" class="btn btn-primary">
                <span aria-hidden="true">➕</span> Nueva categoría
            </a>
            @endcan
            <a href="{{ route('admin.gastos.index') }}" class="btn btn-secundario">
                <span aria-hidden="true">←</span> Volver a Gastos
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alerta alerta-ok" role="alert">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alerta alerta-error" role="alert">❌ {{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.categorias-gastos.index') }}"
          class="reporte-form" role="search">
        <div class="form-group">
            <label for="busqueda">Buscar categoría</label>
            <input type="text" name="busqueda" id="busqueda"
                   value="{{ $busqueda }}" placeholder="Nombre...">
        </div>
        <div class="btn-group">
            <button type="submit"><span aria-hidden="true">🔍</span> Buscar</button>
            <a href="{{ route('admin.categorias-gastos.index') }}" class="btn btn-secundario">🔄 Limpiar</a>
        </div>
    </form>

    <section class="reporte-seccion">
        <table class="tabla-reporte" aria-label="Categorías de gastos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="num">Gastos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $cat)
                <tr>
                    <td><strong>{{ $cat->nombre }}</strong></td>
                    <td>{{ $cat->descripcion ?? '—' }}</td>
                    <td class="num">{{ $cat->gastos_count }}</td>
                    <td>
                        <span class="badge-estado {{ $cat->activo ? 'badge-activo' : 'badge-inactivo' }}">
                            {{ $cat->activo ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="acciones-col">
                        @can('categorias_gastos.editar')
                        <a href="{{ route('admin.categorias-gastos.edit', $cat) }}"
                           class="btn-accion btn-editar"
                           aria-label="Editar categoría {{ $cat->nombre }}">✏️</a>
                        @endcan
                        @can('categorias_gastos.eliminar')
                        @if($cat->gastos_count === 0)
                        <form method="POST"
                              action="{{ route('admin.categorias-gastos.destroy', $cat) }}"
                              onsubmit="return confirm('¿Eliminar la categoría {{ $cat->nombre }}?')"
                              style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-accion btn-eliminar"
                                    aria-label="Eliminar categoría {{ $cat->nombre }}">🗑️</button>
                        </form>
                        @endif
                        @endcan
                    </td>
                </tr>
                @empty
                <tr class="fila-vacia">
                    <td colspan="5">No hay categorías registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="paginacion">{{ $categorias->links() }}</div>
    </section>

</main>
@endsection