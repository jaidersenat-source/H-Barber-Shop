@extends('admin.layout')

@section('title', 'Crear Sede')

@section('content')
@vite(['resources/css/Admin/Sede/create.css'])
<div class="card" id="modulo-sedes-create">
    <h1>Registrar Nueva Sede</h1>

    <form method="POST" action="{{ route('sedes.store') }}" style="margin-bottom:0;">
        @csrf

        <label for="sede_nombre">Nombre de la sede</label>
        <input type="text" id="sede_nombre" name="sede_nombre" required aria-required="true" aria-label="Nombre de la sede">

        <label for="sede_direccion">Dirección de la sede</label>
        <input type="text" id="sede_direccion" name="sede_direccion" required aria-required="true" aria-label="Dirección de la sede">

        <label for="sede_slogan">Slogan de la sede</label>
        <input type="text" id="sede_slogan" name="sede_slogan" aria-label="Slogan de la sede">

        <label for="sede_descripcion">Descripción de la sede</label>
        <textarea id="sede_descripcion" name="sede_descripcion" aria-label="Descripción de la sede"></textarea>

        <label for="sede_logo">Logo de la sede (URL o Base64)</label>
        <input type="text" id="sede_logo" name="sede_logo" aria-label="Logo de la sede (URL o Base64)">

        <div class="botones-form">
            <a href="{{ route('sedes.index') }}" class="btn btn-outline-primary volver-btn" aria-label="Volver al listado de sedes">
                <span aria-hidden="true">&larr;</span> Volver
            </a>
            <button type="submit" class="btn btn-primary guardar-btn">Guardar Sede</button>
        </div>
    </form>
</form>
</div>
<script>
// Navegación accesible con flechas y Tab para todo el módulo Sedes (crear)
// y volver al menú con Esc

document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-sedes-create');
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
