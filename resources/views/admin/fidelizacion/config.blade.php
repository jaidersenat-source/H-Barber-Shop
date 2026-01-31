@extends('admin.layout')
@section('content')
@vite(['resources/css/Admin/fidi/fidelizacion.css'])
<div class="fidelizacion-container" id="modulo-fidelizacion-config" style="max-width:500px;margin:auto;">
    <div class="fidelizacion-header">
        <h2>Configuración de Fidelización</h2>
    </div>
    @if(session('ok'))
        <p style="color: var(--fid-success); font-weight:600;">{{ session('ok') }}</p>
    @endif
    <form action="{{ route('fidelizacion.config.update') }}" method="POST" style="background:#fff;padding:2rem;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        @csrf
        <div class="form-grupo" style="margin-bottom:1.5rem;">
            <label for="visitas_requeridas" style="font-weight:600;display:block;margin-bottom:0.5rem;">Visitas requeridas para corte gratis</label>
            <input type="number" min="1" max="99" name="visitas_requeridas" id="visitas_requeridas" value="{{ old('visitas_requeridas', $visitas) }}" required style="width:100%;max-width:300px;padding:0.75rem;font-size:1rem;border:1.5px solid #e2e8f0;border-radius:6px;">
        </div>
        <div class="form-grupo" style="margin-bottom:2rem;">
            <label for="habilitado" style="font-weight:600;display:block;margin-bottom:0.5rem;">¿Fidelización habilitada?</label>
            <select name="habilitado" id="habilitado" style="width:100%;max-width:300px;padding:0.75rem;font-size:1rem;border:1.5px solid #e2e8f0;border-radius:6px;">
                <option value="1" @if($habilitado) selected @endif>Sí</option>
                <option value="0" @if(!$habilitado) selected @endif>No</option>
            </select>
        </div>
        <div style="display:flex;gap:1rem;margin-top:2rem;">
            <button type="submit" class="btn-ver">Guardar configuración</button>
            <a href="{{ route('fidelizacion.index') }}" class="btn-config">Volver</a>
        </div>
    </form>
<script>
// Navegación accesible con flechas y Tab para el formulario de Configuración de Fidelización
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-fidelizacion-config');
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
