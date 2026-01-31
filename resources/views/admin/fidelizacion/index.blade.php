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
                <span aria-describedby="fecha-actualizacion-{{ $f->fid_id }}">{{ $f->fecha_actualizacion }}</span>
                <span id="fecha-actualizacion-{{ $f->fid_id }}" class="sr-only">
                    {{ \Carbon\Carbon::parse($f->fecha_actualizacion)->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
                </span><br>
            <strong>Acción:</strong> Ver detalles de fidelización
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
                        <span aria-describedby="fecha-actualizacion-tabla-{{ $f->fid_id }}">{{ $f->fecha_actualizacion }}</span>
                        <span id="fecha-actualizacion-tabla-{{ $f->fid_id }}" class="sr-only">
                            {{ \Carbon\Carbon::parse($f->fecha_actualizacion)->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
                        </span>
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
<script>
// Navegación accesible con flechas y Tab para todo el módulo Fidelización
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-fidelizacion');
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
</div>
@endsection
