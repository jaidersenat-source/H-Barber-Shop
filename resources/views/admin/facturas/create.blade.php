@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/factura/create.css'])
<div class="facturas-container">
    <h2>Crear Factura</h2>
    <form action="{{ route('factura.store') }}" method="POST" class="facturas-form" aria-label="Formulario para crear factura">
        @csrf
        <div class="form-group">
            <label for="fac_fecha">Fecha</label>
            <input type="text" name="fac_fecha" id="fac_fecha" value="{{ now()->format('Y-m-d H:i') }}" readonly class="form-control" aria-describedby="fac-fecha-descripcion">
            <span id="fac-fecha-descripcion" class="sr-only">
                {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
            </span>
        </div>
        <div class="form-group">
            <label for="tur_id">Turno</label>
            <input type="text" name="tur_id" value="{{ $turno->tur_id }}" readonly class="form-control">
        </div>
        <div class="form-group">
            <label for="tur_hora">Hora</label>
            <input type="text" name="tur_hora" value="{{ $turno->tur_hora }}" readonly class="form-control">
        </div>
        <div class="form-group">
            <label for="tur_nombre">Nombre</label>
            <input type="text" name="tur_nombre" value="{{ $turno->tur_nombre }}" readonly class="form-control">
        </div>
        <div class="form-group">
            <label for="tur_cedula">Cédula</label>
            <input type="text" name="tur_cedula" value="{{ $turno->tur_cedula }}" readonly class="form-control">
        </div>
        <div class="form-group">
            <label for="sede_id">Sede</label>
            <select name="sede_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach($sedes as $sede)
                    <option value="{{ $sede->sede_id }}">{{ $sede->sede_nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fac_abono">Abono</label>
            <input type="number" step="0.01" name="fac_abono" class="form-control" placeholder="0">
        </div>
        <button type="submit" class="btn btn-primary" aria-label="Crear factura">Crear Factura</button>
    </form>
</div>
<script>
// Navegación accesible para el formulario de crear factura
document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.facturas-container');
    if (!container) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(container.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;

    // Focus inicial en el primer campo del formulario
    focusables[0].focus();

    container.addEventListener('keydown', function (e) {
        const idx = focusables.indexOf(document.activeElement);
        if (e.key === 'Tab') {
            // Focus trap
            if (e.shiftKey && document.activeElement === focusables[0]) {
                e.preventDefault();
                focusables[focusables.length - 1].focus();
            } else if (!e.shiftKey && document.activeElement === focusables[focusables.length - 1]) {
                e.preventDefault();
                focusables[0].focus();
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            focusables[(idx + 1) % focusables.length].focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            focusables[(idx - 1 + focusables.length) % focusables.length].focus();
        } else if (e.key === 'Escape') {
            // Redirigir a la lista de facturas o cerrar modal si aplica
            window.location.href = '/admin/facturas';
        }
    });
});
</script>
@endsection
