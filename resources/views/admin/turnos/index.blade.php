@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/Turnos/turnos.css'])
<div class="card" role="main" aria-label="Gestión de turnos registrados" id="modulo-turnos">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
        <h2 tabindex="0" style="margin:0;font-size:2rem;font-weight:700;color:#1a365d;">Turnos Registrados</h2>
        <a href="{{ route('turnos.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nuevo turno">
            <span style="font-size:1.3em;font-weight:bold;vertical-align:middle;" aria-hidden="true">&#43;</span> Crear turno
        </a>
    </div>

    @if(session('ok'))
        <p style="color: green;" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;" role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    <form method="GET" style="margin-bottom: 20px;" aria-label="Filtrar turnos">
        <label for="estado">Estado:</label>
        <select name="estado" id="estado" tabindex="0" aria-label="Filtrar por estado">
            <option value="" @if(request('estado')=='') selected @endif>Todos</option>
            <option value="Pendiente" @if(request('estado')=='Pendiente') selected @endif>Pendiente</option>
            <option value="Cancelado" @if(request('estado')=='Cancelado') selected @endif>Cancelado</option>
            <option value="Realizado" @if(request('estado')=='Realizado') selected @endif>Realizado</option>
        </select>

        <label for="fecha" style="margin-left:24px;">Fecha:</label>
        <input type="date" name="fecha" id="fecha" tabindex="0" aria-label="Filtrar por fecha (puede escribir o usar el calendario)" style="display:inline-block;width:200px;padding:10px 12px;border:1.5px solid #bfc9d1;border-radius:8px;background:#fff;font-size:1rem;">

        <button type="submit" tabindex="0" aria-label="Filtrar turnos">Filtrar</button>
    </form>

    <div id="turnos-vertical-list" style="margin-top:2rem;">
        <!-- Lista vertical accesible para lectores de pantalla -->
        <ul class="sr-only" aria-label="Lista de turnos detallada">
            @forelse($turnos as $t)
            <li>
                <strong>Cliente:</strong> {{ $t->tur_nombre }} ({{ $t->tur_celular }})<br>
                <strong>Barbero:</strong> {{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }}<br>
                <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($t->tur_fecha)->translatedFormat('l, d \d\e F \d\e Y') }}<br>
                <strong>Hora:</strong> {{ $t->tur_hora }}<br>
                <strong>Estado:</strong> {{ $t->tur_estado }}<br>
                <strong>Acciones:</strong>
                @if ($t->tur_estado == 'Pendiente')
                    <span role="button" aria-label="Marcar como realizado el turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->translatedFormat('l, d \d\e F \d\e Y') }}">Marcar como realizado</span> |
                    <span role="button" aria-label="Cancelar el turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->translatedFormat('l, d \d\e F \d\e Y') }}">Cancelar</span> |
                    <span role="button" aria-label="Reprogramar turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->translatedFormat('l, d \d\e F \d\e Y') }}">Reprogramar</span>
                @elseif ($t->tur_estado == 'Realizado')
                    <span>Realizado</span> |
                    <span role="button" aria-label="Facturar turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->translatedFormat('l, d \d\e F \d\e Y') }}">Facturar turno</span>
                @elseif ($t->tur_estado == 'Cancelado')
                    <span>Cancelado</span>
                @endif
            </li>
            @empty
            <li>No hay turnos registrados</li>
            @endforelse
        </ul>

        <!-- Tabla visual solo para usuarios videntes -->
        <table class="table" role="table" aria-label="Lista de turnos" aria-hidden="true">
            <thead>
                <tr>
                    <th scope="col">Cliente</th>
                    <th scope="col">Barbero</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($turnos as $t)
                <tr>
                    <td data-label="Cliente">{{ $t->tur_nombre }} ({{ $t->tur_celular }})</td>
                    <td data-label="Barbero">{{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }}</td>
                    <td data-label="Fecha">{{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</td>
                    <td data-label="Hora">{{ $t->tur_hora }}</td>
                    <td data-label="Estado">{{ $t->tur_estado }}</td>
                    <td data-label="Acciones">
                        <div class="acciones-turno" role="group" aria-label="Acciones para el turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}">
                        @if ($t->tur_estado == 'Pendiente')
                            <form action="{{ route('turnos.complete', $t->tur_id) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-success" aria-label="Marcar como realizado el turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}">
                                    <span aria-hidden="true">✔</span>
                                    <span class="sr-only">Marcar como realizado</span>
                                    Marcar como realizado
                                </button>
                            </form>
                            <form action="{{ route('turnos.cancel', $t->tur_id) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" aria-label="Cancelar el turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}">
                                    <span aria-hidden="true">✖</span>
                                    <span class="sr-only">Cancelar turno</span>
                                    Cancelar
                                </button>
                            </form>
                            <button type="button" class="btn btn-warning btn-reprogramar-turno" data-tur-id="{{ $t->tur_id }}" data-tur-fecha="{{ $t->tur_fecha }}" data-tur-hora="{{ $t->tur_hora }}" aria-label="Reprogramar turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}">
                                <span aria-hidden="true">🗓️</span>
                                <span class="sr-only">Reprogramar turno</span>
                                Reprogramar
                            </button>
                        @elseif ($t->tur_estado == 'Realizado')
                            <span style="color:#25644a;font-weight:700;">Realizado</span>
                            <a href="{{ route('facturas.createFromTurno', ['tur_id' => $t->tur_id]) }}" class="btn btn-success btn-sm" aria-label="Facturar turno de {{ $t->tur_nombre }} a las {{ $t->tur_hora }} el {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}">
                                Facturar turno
                            </a>
                        @elseif ($t->tur_estado == 'Cancelado')
                            <span style="color:#b91c1c;font-weight:700;">Cancelado</span>
                        @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;">No hay turnos registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $turnos->links() }}
</div>
<script>
// Navegación accesible con flechas y Tab para todo el módulo Turnos
// y volver al menú con Esc

document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-turnos');
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
<!-- Modal de reprogramación de turno -->
<div id="modal-reprogramar-turno" class="modal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.45);align-items:center;justify-content:center;">
    <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalReprogramarTitulo" style="background:#fff;padding:2rem 2.5rem;border-radius:16px;max-width:400px;width:90vw;box-shadow:0 8px 32px rgba(0,0,0,0.18);outline:none;">
        <h3 id="modalReprogramarTitulo" style="margin-top:0;">Reprogramar turno</h3>
        <form id="form-reprogramar-turno" method="POST" action="" autocomplete="off">
            @csrf
            @method('PUT')
            <input type="hidden" name="tur_id" id="repro-tur-id">
            <div class="form-group" style="margin-bottom:1.2rem;">
                <label for="repro-tur-fecha">Nueva fecha</label>
                <input type="date" name="tur_fecha" id="repro-tur-fecha" class="form-control" required>
            </div>
            <div class="form-group" style="margin-bottom:1.2rem;">
                <label for="repro-tur-hora">Nueva hora</label>
                <input type="time" name="tur_hora" id="repro-tur-hora" class="form-control" required>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <button type="button" id="btn-cerrar-modal-repro" class="btn btn-secondary" aria-label="Cancelar reprogramación">Cancelar</button>
                <button type="submit" class="btn btn-primary" aria-label="Guardar nueva fecha y hora">Guardar</button>
            </div>
        </form>
    </div>
</div>
<script>
// Modal accesible para reprogramar turno: focus trap, navegación con teclado y cierre accesible
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-reprogramar-turno');
    const form = document.getElementById('form-reprogramar-turno');
    const btnCerrar = document.getElementById('btn-cerrar-modal-repro');
    let lastTrigger = null;
    let focusables = [];
    function updateFocusables() {
        focusables = Array.from(modal.querySelectorAll('input, button, select, textarea, [tabindex]:not([tabindex="-1"])')).filter(el => !el.disabled && el.offsetParent !== null);
    }
    document.querySelectorAll('.btn-reprogramar-turno').forEach(btn => {
        btn.addEventListener('click', function() {
            lastTrigger = btn;
            const turId = btn.getAttribute('data-tur-id');
            const turFecha = btn.getAttribute('data-tur-fecha');
            const turHora = btn.getAttribute('data-tur-hora');
            document.getElementById('repro-tur-id').value = turId;
            document.getElementById('repro-tur-fecha').value = turFecha;
            document.getElementById('repro-tur-hora').value = turHora;
            form.action = `/admin/turnos/${turId}/reprogramar`;
            modal.style.display = 'flex';
            setTimeout(() => {
                updateFocusables();
                if (focusables.length) focusables[0].focus();
            }, 100);
        });
    });
    btnCerrar.addEventListener('click', function() {
        modal.style.display = 'none';
        if (lastTrigger) lastTrigger.focus();
    });
    // Focus trap y navegación con flechas/Tab
    modal.addEventListener('keydown', function(e) {
        updateFocusables();
        const idx = focusables.indexOf(document.activeElement);
        if (e.key === 'Tab') {
            if (focusables.length === 0) return;
            if (e.shiftKey && document.activeElement === focusables[0]) {
                e.preventDefault();
                focusables[focusables.length - 1].focus();
            } else if (!e.shiftKey && document.activeElement === focusables[focusables.length - 1]) {
                e.preventDefault();
                focusables[0].focus();
            }
        } else if (["ArrowDown", "ArrowRight"].includes(e.key)) {
            e.preventDefault();
            if (idx !== -1) focusables[(idx + 1) % focusables.length].focus();
        } else if (["ArrowUp", "ArrowLeft"].includes(e.key)) {
            e.preventDefault();
            if (idx !== -1) focusables[(idx - 1 + focusables.length) % focusables.length].focus();
        } else if (e.key === 'Escape') {
            modal.style.display = 'none';
            if (lastTrigger) lastTrigger.focus();
        }
    });
    // Cerrar al hacer click fuera del dialog
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            if (lastTrigger) lastTrigger.focus();
        }
    });
});
</script>
@endsection
