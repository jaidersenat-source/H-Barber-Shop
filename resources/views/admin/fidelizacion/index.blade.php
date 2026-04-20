@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/fidi/fidelizacion.css'])
<div class="fidelizacion-container" id="modulo-fidelizacion">
    <div class="fidelizacion-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;">
        <h2 id="titulo-fidelizacion" tabindex="0" style="margin:0;">Fidelización de Clientes</h2>
        <a href="{{ route('fidelizacion.config') }}" class="btn btn-outline-primary configurar-btn" tabindex="0" aria-label="Configurar fidelización">
            <span aria-hidden="true">&#9881;</span> Configurar fidelización
        </a>
    </div>

    @if(session('ok'))
        <p role="status" aria-live="polite" style="color: var(--fid-success); font-weight:600;">{{ session('ok') }}</p>
    @endif

    <!-- Lista vertical accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista de clientes fidelizados detallada">
        @forelse($items as $f)
        <li>
            <strong>Cliente:</strong> {{ $f->tur_nombre }}<br>
            <strong>Cédula:</strong> {{ $f->tur_cedula }}<br>
            <strong>Teléfono:</strong> {{ $f->tur_celular }}<br>
            <strong>Visitas acumuladas:</strong> {{ $f->visitas_acumuladas }}<br>
            <strong>Cortes gratis:</strong> {{ $f->cortes_gratis }}<br>
            <strong>Última actualización:</strong>
                {{ \Carbon\Carbon::parse($f->fecha_actualizacion)->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}<br>
            <strong>Acción:</strong>
            <a href="{{ route('fidelizacion.show', $f->fid_id) }}" class="btn-ver" tabindex="0" aria-label="Ver detalles de fidelización de {{ $f->tur_nombre }}">Ver detalles de fidelización</a>
        </li>
        @empty
        <li>No hay registros de fidelización</li>
        @endforelse
    </ul>

    <!-- Tabla visual solo para usuarios videntes -->
    <table class="fidelizacion-table" role="table" aria-describedby="tabla-fidelizacion-desc">
        <caption id="tabla-fidelizacion-desc" class="sr-only">Listado de clientes fidelizados y sus beneficios acumulados</caption>
        <thead>
            <tr>
                <th scope="col">Cliente</th>
                <th scope="col">Cédula</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Visitas</th>
                <th scope="col">Cortes Gratis</th>
                <th scope="col">Última actualización</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $f)
                <tr tabindex="0">
                    <td data-label="Cliente">{{ $f->tur_nombre }}</td>
                    <td data-label="Cédula">{{ $f->tur_cedula }}</td>
                    <td data-label="Teléfono">{{ $f->tur_celular }}</td>
                    <td data-label="Visitas">{{ $f->visitas_acumuladas }}</td>
                    <td data-label="Cortes Gratis">{{ $f->cortes_gratis }}</td>
                    <td data-label="Última actualización">
                        {{ \Carbon\Carbon::parse($f->fecha_actualizacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
                    </td>
                    <td data-label="Acciones">
                        <a href="{{ route('fidelizacion.show', $f->fid_id) }}" class="btn-ver" aria-label="Ver detalles de fidelización de {{ $f->tur_nombre }}" tabindex="1">Ver</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;" role="alert">No hay registros de fidelización</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <nav aria-label="Paginación de fidelización">
        {{ $items->links() }}
    </nav>
</div>
@endsection
