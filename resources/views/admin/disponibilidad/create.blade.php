@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/dispo/create.css'])

<div class="disponibilidad-form">
<div class="card" role="main" aria-label="Formulario para crear disponibilidad semanal">
    <div class="header-flex-responsive">
        <h2 tabindex="0" style="margin: 0;">Crear disponibilidad semanal</h2>
        <a href="{{ route('disponibilidad.index') }}" class="btn btn-outline-primary volver-btn" tabindex="0" aria-label="Cancelar y volver al listado">
            <span aria-hidden="true">&larr;</span> Volver
        </a>
    </div>
<style>
.header-flex-responsive {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    gap: 1.5rem;
    flex-wrap: wrap;
}
@media (max-width: 600px) {
    .header-flex-responsive {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }
    .header-flex-responsive .volver-btn {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }
}
</style>

    @if ($errors->any())
        <div style="color:red;" role="alert" aria-live="assertive">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('disponibilidad.storeWeekly') }}" aria-label="Formulario de disponibilidad semanal">
        @csrf

        <fieldset>
            <legend>Seleccione el barbero</legend>
            <label for="per_documento">Barbero</label>
            <select name="per_documento" id="per_documento" required tabindex="0" aria-label="Seleccionar barbero">
                <option value="">Seleccione un barbero</option>
                @foreach($personas as $p)
                    <option value="{{ $p->per_documento }}">
                        {{ $p->per_nombre }} {{ $p->per_apellido }}
                    </option>
                @endforeach
            </select>
        </fieldset>

        <fieldset>
            <legend>Días de la semana</legend>
            <span>Seleccione los días que trabaja el barbero:</span>
            <div>
                @foreach($dias as $d)
                    <label style="margin-right:12px;">
                        <input type="checkbox" name="dias[]" value="{{ $d }}" tabindex="0" aria-label="Día {{ $d }}"> {{ $d }}
                    </label>
                @endforeach
            </div>
        </fieldset>

        <fieldset>
            <legend>Horario y fecha</legend>
            <label for="dis_fecha">Fecha (opcional)</label>
            <input type="date" name="dis_fecha" id="dis_fecha" tabindex="0" aria-label="Fecha de inicio de disponibilidad" aria-describedby="dis_fecha_ayuda">
            <span id="dis_fecha_ayuda" class="sr-only">
                @php
                    $fecha = old('dis_fecha');
                @endphp
                @if($fecha)
                    Fecha seleccionada: {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l, d \d\e F \d\e Y') }}
                @else
                    No se ha seleccionado fecha.
                @endif
            </span>

            <label style="display:block; margin-top:8px;">
                <input type="checkbox" name="apply_to_week" value="1" tabindex="0" aria-label="Aplicar sólo a la semana de la fecha seleccionada"> Aplicar sólo a la semana de la fecha seleccionada
            </label>

            <label for="dis_hora_inicio">Hora inicio</label>
            <input type="time" name="dis_hora_inicio" id="dis_hora_inicio" required tabindex="0" aria-label="Hora de inicio">

            <label for="dis_hora_fin">Hora fin</label>
            <input type="time" name="dis_hora_fin" id="dis_hora_fin" required tabindex="0" aria-label="Hora de fin">
        </fieldset>

        <button type="submit" tabindex="0" aria-label="Guardar disponibilidad semanal">Guardar disponibilidad semanal</button>
    </form>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const card = document.querySelector('.card');
        const focusableSelectors = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
        const focusables = card.querySelectorAll(focusableSelectors);
        let focusable = Array.prototype.filter.call(focusables, function (el) {
            return !el.disabled && el.offsetParent !== null;
        });

        let current = 0;
        if (focusable.length) focusable[0].focus();

        card.addEventListener('keydown', function (e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    current = (current - 1 + focusable.length) % focusable.length;
                } else {
                    current = (current + 1) % focusable.length;
                }
                focusable[current].focus();
                e.preventDefault();
            } else if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
                current = (current + 1) % focusable.length;
                focusable[current].focus();
                e.preventDefault();
            } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
                current = (current - 1 + focusable.length) % focusable.length;
                focusable[current].focus();
                e.preventDefault();
            } else if (e.key === 'Escape') {
                window.location.href = '{{ route('disponibilidad.index') }}';
            } else if (e.key === 'Enter') {
                if (document.activeElement && document.activeElement.type === 'checkbox') {
                    document.activeElement.checked = !document.activeElement.checked;
                    e.preventDefault();
                }
            }
        });
    });
    </script>
</div>
</div>
@endsection
