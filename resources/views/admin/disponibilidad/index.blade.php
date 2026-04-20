@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/dispo/disponibilidad.css'])

<div class="card" id="modulo-disponibilidad" role="main" aria-label="Gestión de disponibilidad de barberos">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;flex-wrap:wrap;">
        <h2 tabindex="0" style="margin:0;font-size:2rem;font-weight:700;color:#1a365d;">Disponibilidad de Barberos</h2>
        <a href="{{ route('disponibilidad.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nueva disponibilidad">
            <span aria-hidden="true">&#43;</span> Crear disponibilidad
        </a>
    </div>

    @if(session('ok'))
        <p style="color:green;" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif

    @foreach($barberos as $barbero)
        <div class="barbero-block" style="margin-bottom: 24px;">
            <h3 tabindex="0">{{ $barbero->per_nombre }} {{ $barbero->per_apellido }}</h3>
            
            <!-- Lista vertical accesible para lectores de pantalla -->
            <ul class="sr-only" aria-label="Disponibilidad de {{ $barbero->per_nombre }} {{ $barbero->per_apellido }}">
                @forelse($barbero->disponibilidades as $h)
                <li>
                    @php $fechaNatural = \Carbon\Carbon::parse($h->dis_fecha)->translatedFormat('l, d \d\e F \d\e Y'); @endphp
                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}<br>
                    <strong>Día:</strong> {{ $h->dia }}<br>
                    <strong>Hora inicio:</strong> {{ $h->dis_hora_inicio }}<br>
                    <strong>Hora fin:</strong> {{ $h->dis_hora_fin }}<br>
                    <strong>Estado:</strong> {{ $h->dis_estado }}<br>
                    <strong>Acciones:</strong>
                    <a href="{{ route('disponibilidad.edit', $h->dis_id) }}" class="sr-only-link" tabindex="0" aria-label="Editar disponibilidad de {{ $barbero->per_nombre }} el {{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM') }}">
                        Editar disponibilidad
                    </a>
                    
                    <a href="#" class="sr-only-link eliminar-dispo-accesible" tabindex="0" aria-label="Eliminar disponibilidad de {{ $barbero->per_nombre }} el {{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM') }}" data-id="{{ $h->dis_id }}">
                        Eliminar disponibilidad
                    </a>
                </li>
                @empty
                <li>No hay horarios registrados.</li>
                @endforelse
            </ul>
            
            <!-- Tabla visual solo para usuarios videntes -->
            <table border="1" width="100%" role="table" aria-label="Disponibilidad de {{ $barbero->per_nombre }}">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Día</th>
                        <th scope="col">Hora inicio</th>
                        <th scope="col">Hora fin</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barbero->disponibilidades as $h)
                        <tr>
                            @php $fechaNatural = \Carbon\Carbon::parse($h->dis_fecha)->translatedFormat('l, d \d\e F \d\e Y'); @endphp
                            <td data-label="Fecha">{{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</td>
                            <td data-label="Día">{{ $h->dia }}</td>
                            <td data-label="Hora inicio">{{ $h->dis_hora_inicio }}</td>
                            <td data-label="Hora fin">{{ $h->dis_hora_fin }}</td>
                            <td data-label="Estado">{{ $h->dis_estado }}</td>
                            <td data-label="Acciones">
                                <div class="acciones-disponibilidad">
                                    <a href="{{ route('disponibilidad.edit', $h->dis_id) }}" class="btn btn-sm btn-primary" tabindex="0" aria-label="Editar disponibilidad de {{ $barbero->per_nombre }} el {{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM') }}">
                                        Editar
                                    </a>
                                    <form action="{{ route('disponibilidad.destroy', $h->dis_id) }}" method="POST" class="form-eliminar-dispo">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-eliminar-dispon" tabindex="0" aria-label="Eliminar disponibilidad de {{ $barbero->per_nombre }} el {{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM') }}">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;">No hay horarios registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach

</div>

<!-- Modal FUERA del div.card para evitar conflictos con focus trap -->
<div id="modal-eliminar" class="modal-eliminar" role="dialog" aria-modal="true" aria-labelledby="modal-eliminar-titulo" aria-describedby="modal-eliminar-desc" tabindex="-1">
    <div class="modal-contenido">
        <button id="cerrar-modal-eliminar" type="button" class="btn-cerrar-modal" aria-label="Cerrar modal">&times;</button>
        <h2 id="modal-eliminar-titulo" tabindex="0">¿Eliminar horario?</h2>
        <p id="modal-eliminar-desc" class="modal-mensaje" aria-live="assertive">Esta acción no se puede deshacer. Si confirmas, el horario será eliminado permanentemente.</p>
        <div class="modal-acciones">
            <button id="cancelar-eliminar" type="button" class="btn-modal btn-cancelar" aria-label="Cancelar y cerrar el modal">Cancelar</button>
            <button id="confirmar-eliminar" type="button" class="btn-modal btn-confirmar" aria-label="Confirmar eliminación del horario">Eliminar</button>
        </div>
    </div>
</div>

<script>
// ========================================
// MODAL DE ELIMINACIÓN
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    let formAEliminar = null;
    let botonQueAbrio = null;
    const modal = document.getElementById('modal-eliminar');
    const btnCancelar = document.getElementById('cancelar-eliminar');
    const btnConfirmar = document.getElementById('confirmar-eliminar');
    const btnCerrar = document.getElementById('cerrar-modal-eliminar');

    // Abrir modal desde botón visual
    document.querySelectorAll('.btn-eliminar-dispon').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            formAEliminar = btn.closest('.form-eliminar-dispo');
            botonQueAbrio = btn;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            setTimeout(() => { btnCancelar.focus(); }, 100);
        });
    });

    // Abrir modal desde enlace accesible
    document.querySelectorAll('.eliminar-dispo-accesible').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Buscar el form correspondiente por data-id
            const disId = link.getAttribute('data-id');
            formAEliminar = document.querySelector('.form-eliminar-dispo[action*="/' + disId + '"]');
            botonQueAbrio = link;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            setTimeout(() => { btnCancelar.focus(); }, 100);
        });
    });

    // Cerrar modal
    function cerrarModal() {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        if (botonQueAbrio) { botonQueAbrio.focus(); }
        formAEliminar = null;
        botonQueAbrio = null;
    }
    btnCancelar.addEventListener('click', cerrarModal);
    btnCerrar.addEventListener('click', cerrarModal);

    // Confirmar eliminación
    btnConfirmar.addEventListener('click', function() {
        if (formAEliminar) { formAEliminar.submit(); }
    });

    // Cerrar con Escape
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { cerrarModal(); }
    });

    // Cerrar al hacer clic fuera del modal
    modal.addEventListener('click', function(e) {
        if (e.target === modal) { cerrarModal(); }
    });

    // Focus trap dentro del modal
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            const focusableElements = modal.querySelectorAll('button:not([disabled])');
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            } else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    });
});
</script>

@endsection