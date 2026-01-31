@extends('admin.layout')


@section('content')
@vite(['resources/css/Admin/servicio/edit.css'])
<div class="servicios-container" id="modulo-servicios-edit">
    <h2 tabindex="0">Editar Servicio</h2>

    <form method="POST" action="{{ route('servicios.update', $servicio->serv_id) }}" aria-label="Formulario para editar servicio">
        @csrf @method('PUT')

        <label for="serv_nombre">Nombre</label>
        <input type="text" name="serv_nombre" id="serv_nombre" value="{{ $servicio->serv_nombre }}" required tabindex="0" aria-label="Nombre del servicio">

        <label for="serv_descripcion">Descripción</label>
        <textarea name="serv_descripcion" id="serv_descripcion" tabindex="0" aria-label="Descripción del servicio">{{ $servicio->serv_descripcion }}</textarea>

        <label for="serv_precio">Precio</label>
        <input type="number" step="0.01" name="serv_precio" id="serv_precio" value="{{ $servicio->serv_precio }}" required tabindex="0" aria-label="Precio del servicio">

        <label for="serv_duracion">Duración (minutos)</label>
        <input type="number" name="serv_duracion" id="serv_duracion" value="{{ $servicio->serv_duracion }}" required tabindex="0" aria-label="Duración en minutos">

        <label for="serv_estado">Estado</label>
        <select name="serv_estado" id="serv_estado" tabindex="0" aria-label="Estado del servicio">
            <option value="activo" {{ $servicio->serv_estado=='activo'?'selected':'' }}>Activo</option>
            <option value="inactivo" {{ $servicio->serv_estado=='inactivo'?'selected':'' }}>Inactivo</option>
        </select>

        <label>Descuento (%)</label>
        <input type="number" name="serv_descuento" min="0" max="100" step="0.01" value="{{ old('serv_descuento', $servicio->serv_descuento ?? 0) }}" placeholder="Ej: 10 para 10%" aria-label="Descuento en porcentaje">

        <button type="submit" tabindex="0" aria-label="Actualizar servicio">Actualizar</button>
        <a href="{{ route('servicios.index') }}" class="btn-volver" tabindex="0" aria-label="Volver a la lista de servicios" style="margin-left:10px;">Volver</a>
    </form>
<script>
// Navegación accesible con flechas y Tab para el formulario Editar Servicio
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-servicios-edit');
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
