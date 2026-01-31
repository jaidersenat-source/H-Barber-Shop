@extends('admin.layout')

@section('title', 'Sedes')

@section('content')

<div class="card" role="main" aria-label="Gestión de sedes" id="modulo-sedes">
    <h1 tabindex="0">Listado de Sedes</h1>

   @vite(['resources/css/Admin/Sede/sede.css'])

    <a href="{{ route('sedes.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Registrar nueva sede">
        <span aria-hidden="true">➕</span> Registrar nueva sede
    </a>

    @if(session('ok'))
        <p style="color: green;" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;" role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    @php
    $headers = ['ID', 'Sede', 'Dirección', 'Slogan', 'Acciones'];
    @endphp
    <table role="table" aria-label="Lista de sedes">
        <thead>
        <tr>
            @foreach($headers as $header)
                <th scope="col">{{ $header }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($sedes as $s)
        <tr>
            <td data-label="ID">{{ $s->sede_id }}</td>
            <td data-label="Sede">{{ $s->sede_nombre }}</td>
            <td data-label="Dirección">{{ $s->sede_direccion }}</td>
            <td data-label="Slogan">{{ $s->sede_slogan }}</td>
            <td data-label="Acciones">
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
<div id="delete-modal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
    <div class="modal-content" style="background:#fff; padding:2em; border-radius:8px; max-width:90vw; width:350px; text-align:center; position:relative;">
        <p id="modal-message" style="margin-bottom:2em;">¿Estás seguro de que deseas eliminar esta sede?</p>
        <button id="modal-cancel" style="margin-right:1em; padding:0.5em 1.5em;">Cancelar</button>
        <button id="modal-confirm" style="background:#d9534f; color:#fff; padding:0.5em 1.5em;">Eliminar</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navegación accesible con flechas y Tab para todo el módulo Sedes
    // y volver al menú con Esc

    const modulo = document.getElementById('modulo-sedes');
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

    // Modal de confirmación de eliminación
    let modal = document.getElementById('delete-modal');
    let modalMessage = document.getElementById('modal-message');
    let cancelBtn = document.getElementById('modal-cancel');
    let confirmBtn = document.getElementById('modal-confirm');
    let formToDelete = null;
    let lastActiveElement = null;

    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            formToDelete = btn.closest('form');
            lastActiveElement = document.activeElement;
            modalMessage.textContent = `¿Estás seguro de que deseas eliminar la sede "${btn.getAttribute('data-sede')}"?`;
            modal.style.display = 'flex';
            cancelBtn.focus();
        });
    });

    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        if (lastActiveElement) lastActiveElement.focus();
    });
    confirmBtn.addEventListener('click', function() {
        if (formToDelete) formToDelete.submit();
    });
    // Cerrar modal con Escape
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.style.display = 'none';
            if (lastActiveElement) lastActiveElement.focus();
        }
    });
    // Trap focus en el modal
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            const focusables = [cancelBtn, confirmBtn];
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    });
});
</script>
@endsection
