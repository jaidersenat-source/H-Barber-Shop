@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/turnos/create.css'])

<div class="card" id="modulo-turnos-create">
    <div>
        <h2>Crear turno — Calendario</h2>
        <a href="{{ route('turnos.index') }}" class="btn btn-outline-primary volver-btn" accesskey="b" aria-label="Volver al listado de turnos (Alt+B)">
            <span aria-hidden="true">&larr;</span> Volver
        </a>
    </div>

    <label for="fecha">Elige una fecha:</label>
    <input type="date" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" aria-describedby="fecha-ayuda">
    <span id="fecha-ayuda" class="sr-only">
        Fecha seleccionada: {{ \Carbon\Carbon::parse(old('fecha', date('Y-m-d')))->translatedFormat('l, d \d\e F \d\e Y') }}
    </span>
    <label for="servicio">Servicio:</label>
    <select id="servicio" name="servicio">
        <option value="">-- Selecciona --</option>
        @foreach($servicios as $s)
            <option value="{{ $s->serv_id }}" data-duracion="{{ $s->serv_duracion }}">{{ $s->serv_nombre }} ({{ $s->serv_duracion }} min)</option>
        @endforeach
    </select>

    <div id="result" style="margin-top:20px;"></div>

</div>




<!-- Modal de éxito para turno registrado -->
<div id="modal-turno-exito" class="modal-turno-exito" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modal-exito-titulo" aria-describedby="modal-exito-desc">
    <div class="modal-turno-exito-content">
        <button type="button" class="modal-turno-exito-close" aria-label="Cerrar" tabindex="0">&times;</button>
        <h3 id="modal-exito-titulo">¡Turno registrado!</h3>
        <p id="modal-exito-desc">El turno se registró correctamente.</p>
        <div class="modal-turno-exito-actions">
            <button type="button" class="modal-turno-exito-accept" aria-label="Aceptar y cerrar modal">Aceptar</button>
        </div>
    </div>
</div>

<!-- Modal de error para turno -->
<div id="modal-turno-error" class="modal-turno-error" style="display:none;" role="alertdialog" aria-modal="true" aria-labelledby="modal-error-titulo" aria-describedby="modal-turno-error-msg">
    <div class="modal-turno-error-content">
        <button type="button" class="modal-turno-error-close" aria-label="Cerrar" tabindex="0">&times;</button>
        <h2 id="modal-error-titulo">¡Error al registrar turno!</h2>
        <p id="modal-turno-error-msg"></p>
        <div class="modal-turno-error-actions">
            <button type="button" class="modal-turno-error-accept" aria-label="Aceptar y cerrar modal">Aceptar</button>
        </div>
    </div>
</div>

<script>
window.turnosAvailableRoute = "{{ route('turnos.available') }}";
window.turnosStoreRoute = "{{ route('turnos.store') }}";
</script>
@vite(['resources/js/Admin/turnos.js'])
   
@endsection
