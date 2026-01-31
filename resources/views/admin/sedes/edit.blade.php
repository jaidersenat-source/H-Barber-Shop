@extends('admin.layout')

@section('title', 'Editar Sede')

@section('content')

@vite(['resources/css/Admin/Sede/create.css'])
<div class="card" id="modulo-sedes-form">
    <h1>Editar Sede</h1>

    

    <form method="POST" action="{{ route('sedes.update', $sede->sede_id) }}">
        @csrf
        @method('PUT')

        <label>Nombre</label>
        <input type="text" name="sede_nombre" value="{{ $sede->sede_nombre }}" required>

        <label>Dirección</label>
        <input type="text" name="sede_direccion" value="{{ $sede->sede_direccion }}" required>

        <label>Slogan</label>
        <input type="text" name="sede_slogan" value="{{ $sede->sede_slogan }}">

        <label>Descripción</label>
        <textarea name="sede_descripcion">{{ $sede->sede_descripcion }}</textarea>

        <label>Logo (URL o Base64)</label>
        <input type="text" name="sede_logo" value="{{ $sede->sede_logo }}">

        
 <div class="botones-form">
            <a href="{{ route('sedes.index') }}" class="btn btn-outline-primary volver-btn" aria-label="Volver al listado de sedes">
                <span aria-hidden="true">&larr;</span> Volver
            </a>
            <button type="submit" class="btn btn-primary guardar-btn">Actualizar Sede</button>
        </div>
    </form>
</div>
<script>
// Focus trap para el formulario de editar sede y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-sedes-form');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;
    focusables[0].focus();
    modulo.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
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
        } else if (e.key === 'Escape') {
            const menu = document.querySelector('.sidebar a');
            if (menu) menu.focus();
        }
        // Atajo Alt+B para volver
        if ((e.altKey || e.metaKey) && (e.key === 'b' || e.key === 'B')) {
            const volverBtn = modulo.querySelector('a[accesskey="b"]');
            if (volverBtn) {
                volverBtn.focus();
                volverBtn.click();
            }
        }
    });
});
</script>
@endsection
