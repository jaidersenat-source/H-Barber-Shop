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
                    Editar disponibilidad / Eliminar disponibilidad
                </li>
                @empty
                <li>No hay horarios registrados.</li>
                @endforelse
            </ul>
            <!-- Tabla visual solo para usuarios videntes -->
            <table border="1" width="100%" role="table" aria-label="Disponibilidad de {{ $barbero->per_nombre }}" aria-hidden="true">
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
                            <td aria-label="Fecha">{{ \Carbon\Carbon::parse($h->dis_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</td>
                            <td aria-label="Día">{{ $h->dia }}</td>
                            <td aria-label="Hora inicio">{{ $h->dis_hora_inicio }}</td>
                            <td aria-label="Hora fin">{{ $h->dis_hora_fin }}</td>
                            <td aria-label="Estado">{{ $h->dis_estado }}</td>
                            <td aria-label="Acciones">
                                <a href="{{ route('disponibilidad.edit', $h->dis_id) }}" tabindex="0" aria-label="Editar disponibilidad">Editar</a>
                                <form action="{{ route('disponibilidad.destroy', $h->dis_id) }}" method="POST" style="display:inline;" aria-label="Eliminar disponibilidad">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-eliminar-dispon" style="color:red;" tabindex="0" aria-label="Eliminar disponibilidad">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" aria-label="Sin disponibilidad registrada">No hay horarios registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>


<!-- Modal de confirmación de eliminación con estilo personalizado -->
<div id="modal-eliminar" class="modal-eliminar" role="dialog" aria-modal="true" aria-labelledby="modal-eliminar-titulo" aria-hidden="true" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2rem 2rem 2rem;border-radius:24px;max-width:90vw;width:400px;box-shadow:0 2px 16px #0002;outline:0;position:relative;display:flex;flex-direction:column;align-items:center;">
        <button id="cerrar-modal-eliminar" type="button" aria-label="Cerrar" style="position:absolute;top:18px;right:18px;background:transparent;border:none;font-size:1.7rem;color:#22304a;cursor:pointer;line-height:1;">&times;</button>
        <h2 id="modal-eliminar-titulo" style="margin:0 0 0.5rem 0;font-size:1.6rem;font-weight:700;color:#22304a;text-align:center;">¿Eliminar horario?</h2>
        <p style="margin:0 0 2rem 0;font-size:1.1rem;color:#22304a;text-align:center;">Esta acción no se puede deshacer.</p>
        <div style="display:flex;gap:1.5rem;justify-content:center;width:100%;">
            <button id="cancelar-eliminar" type="button" style="background:#fff;color:#22304a;border:2px solid #22304a;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Cancelar</button>
            <button id="confirmar-eliminar" type="button" style="background:#22304a;color:#fff;border:none;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Eliminar</button>
        </div>
    </div>
</div>

<script>
// Modal de confirmación de eliminación para disponibilidad
document.addEventListener('DOMContentLoaded', function() {
    let formAEliminar = null;
    const modal = document.getElementById('modal-eliminar');
    const btnCancelar = document.getElementById('cancelar-eliminar');
    const btnConfirmar = document.getElementById('confirmar-eliminar');
    // Mostrar modal al hacer click en Eliminar
    document.querySelectorAll('.btn-eliminar-dispon').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            formAEliminar = btn.closest('form');
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            document.getElementById('confirmar-eliminar').focus();
        });
    });
    // Cancelar y cerrar (botón o X)
    function cerrarModal() {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        formAEliminar = null;
    }
    btnCancelar.addEventListener('click', cerrarModal);
    document.getElementById('cerrar-modal-eliminar').addEventListener('click', cerrarModal);
    // Confirmar
    btnConfirmar.addEventListener('click', function() {
        if(formAEliminar) formAEliminar.submit();
    });
    // Cerrar modal con Escape
    modal.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            cerrarModal();
        }
    });
});
</script>

    @endforeach
</div>

<script>
// Navegación accesible con flechas y Tab para todo el módulo Disponibilidad
// y volver al menú con Esc

document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-disponibilidad');
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
@endsection
