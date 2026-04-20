@extends('admin.layout')

@section('title', 'Sedes')

@section('content')

<div class="card" role="main" aria-label="Gestión de sedes" id="modulo-sedes">
    <h1 tabindex="0">Listado de Sedes</h1>

   @vite(['resources/css/Admin/sede/sede.css'])

    <a href="{{ route('sedes.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Registrar nueva sede">
        <span aria-hidden="true">➕</span> Registrar nueva sede
    </a>

    @if(session('ok'))
        <p role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    <!-- Lista accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista de sedes detallada">
        @foreach($sedes as $s)
        <li>
            <strong>ID:</strong> {{ $s->sede_id }}<br>
            <strong>Sede:</strong> {{ $s->sede_nombre }}<br>
            <strong>Dirección:</strong> {{ $s->sede_direccion }}<br>
            <strong>Teléfono:</strong> {{ $s->sede_telefono }}<br>
            <strong>Slogan:</strong> {{ $s->sede_slogan }}<br>
            <strong>Acciones:</strong>
            <span>
                <a href="{{ route('sedes.edit', $s->sede_id) }}" aria-label="Editar sede {{ $s->sede_nombre }}">Editar sede</a>
                <form action="{{ route('sedes.destroy', $s->sede_id) }}" method="POST" style="display:inline" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="delete-btn" data-sede="{{ $s->sede_nombre }}" aria-label="Eliminar sede {{ $s->sede_nombre }}">Eliminar sede</button>
                </form>
            </span>
        </li>
        @endforeach
    </ul>
    @php
    $headers = ['ID', 'Sede', 'Dirección', 'Teléfono', 'Slogan', 'Acciones'];
    @endphp
    <table role="table" aria-label="Lista de sedes">
        <thead>
        <tr>
            <th id="th-id" scope="col">ID</th>
            <th id="th-sede" scope="col">Sede</th>
            <th id="th-direccion" scope="col">Dirección</th>
            <th id="th-telefono" scope="col">Teléfono</th>
            <th id="th-slogan" scope="col">Slogan</th>
            <th id="th-acciones" scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sedes as $s)
        <tr aria-describedby="th-id th-sede th-direccion th-telefono th-slogan th-acciones">
            <td headers="th-id">{{ $s->sede_id }}</td>
            <td headers="th-sede">{{ $s->sede_nombre }}</td>
            <td headers="th-direccion">{{ $s->sede_direccion }}</td>
            <td headers="th-telefono">{{ $s->sede_telefono }}</td>
            <td headers="th-slogan">{{ $s->sede_slogan }}</td>
            <td headers="th-acciones">
                <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <a href="{{ route('sedes.edit', $s->sede_id) }}" tabindex="0" aria-label="Editar sede {{ $s->sede_nombre }}">✏ Editar</a>
                    <form action="{{ route('sedes.destroy', $s->sede_id) }}" method="POST" style="display:inline" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="delete-btn" data-sede="{{ $s->sede_nombre }}" aria-label="Eliminar sede {{ $s->sede_nombre }}">
                            🗑 Eliminar
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de confirmación -->
<div id="delete-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-message">
    <div class="modal-content">
        <p id="modal-message">¿Estás seguro de que deseas eliminar esta sede?</p>
        <button id="modal-cancel" aria-label="Cancelar eliminación">Cancelar</button>
        <button id="modal-confirm" aria-label="Confirmar eliminación">Eliminar</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== VARIABLES GLOBALES ==========
    const modal = document.getElementById('delete-modal');
    const modalMessage = document.getElementById('modal-message');
    const cancelBtn = document.getElementById('modal-cancel');
    const confirmBtn = document.getElementById('modal-confirm');
    let formToDelete = null;
    let lastActiveElement = null;

    // Asegurar que el modal esté desactivado al cargar
    if (modal) {
        modal.classList.remove('active');
    }

    // NAVEGACIÓN: Eliminada navegación personalizada para no interferir con el lector de pantalla

    // ========== MODAL DE CONFIRMACIÓN ==========
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!modal) return;
            formToDelete = btn.closest('form');
            lastActiveElement = document.activeElement;
            modalMessage.textContent = `¿Estás seguro de que deseas eliminar la sede "${btn.getAttribute('data-sede')}"?`;
            modal.classList.add('active');
            // Foco inicial en botón cancelar
            setTimeout(() => {
                cancelBtn.focus();
            }, 100);
        });
    });

    if (modal && cancelBtn && confirmBtn) {
        cancelBtn.addEventListener('click', function() {
            modal.classList.remove('active');
            if (lastActiveElement) lastActiveElement.focus();
        });

        confirmBtn.addEventListener('click', function() {
            if (formToDelete) formToDelete.submit();
        });

        modal.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                modal.classList.remove('active');
                if (lastActiveElement) lastActiveElement.focus();
            }
        });

        // Mejorar ciclo de tabulación y anunciar el estado del modal
        modal.addEventListener('keydown', function(e) {
            const focusables = [cancelBtn, confirmBtn];
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.key === 'Tab') {
                if (e.shiftKey && document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                } else if (!e.shiftKey && document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            } else if (e.key === 'Escape') {
                modal.classList.remove('active');
                if (lastActiveElement) lastActiveElement.focus();
            }
        });
        // Anunciar el estado del modal al abrir
        modal.addEventListener('transitionend', function() {
            if (modal.classList.contains('active')) {
                modalMessage.setAttribute('aria-live', 'assertive');
            } else {
                modalMessage.removeAttribute('aria-live');
            }
        });
    }
});
</script>
@endsection
