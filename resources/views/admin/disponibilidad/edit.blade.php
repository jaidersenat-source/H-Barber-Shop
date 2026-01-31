@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/dispo/edit.css'])

<div class="card">
    <h2>Editar disponibilidad</h2>

    @if ($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('disponibilidad.update', $horario->dis_id) }}">
        @csrf

        <label for="per_documento">Barbero</label>
        <select name="per_documento" required>
            @foreach ($personas as $p)
                <option value="{{ $p->per_documento }}"
                    {{ $horario->per_documento == $p->per_documento ? 'selected' : '' }}>
                    {{ $p->per_nombre }} {{ $p->per_apellido }}
                </option>
            @endforeach
        </select>

        <label for="dis_fecha">Fecha</label>
        <input type="date" name="dis_fecha" id="dis_fecha" value="{{ $horario->dis_fecha }}" required aria-describedby="dis_fecha_ayuda">
        <span id="dis_fecha_ayuda" class="sr-only">
            Fecha seleccionada: {{ \Carbon\Carbon::parse($horario->dis_fecha)->translatedFormat('l, d \d\e F \d\e Y') }}
        </span>

        <label>Día</label>
        <select name="dia" required>
            @foreach ($dias as $d)
                <option value="{{ $d }}" {{ $horario->dia == $d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach 

        <label>Hora inicio</label>
        <input type="time" name="dis_hora_inicio" value="{{ $horario->dis_hora_inicio }}" required>

        <label>Hora fin</label>
        <input type="time" name="dis_hora_fin" value="{{ $horario->dis_hora_fin }}" required>

        <label>Estado</label>
        <select name="dis_estado">
            <option value="disponible" {{ $horario->dis_estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="inactivo" {{ $horario->dis_estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            <option value="ocupado" {{ $horario->dis_estado == 'ocupado' ? 'selected' : '' }}>Ocupado</option>
        </select>

        <button type="submit">Actualizar</button>
        <a href="{{ route('disponibilidad.index') }}">Cancelar</a>
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
    </form>
</div>
@endsection
