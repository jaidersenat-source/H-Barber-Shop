@extends('barbero.layout')

@section('content')
@vite(['resources/css/Barberos/turnos/create.css'])

<div class="card" id="modulo-turnos-create">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;">
        <h2 style="margin:0;font-size:2rem;font-weight:700;color:#1a365d;">Crear turno — Calendario</h2>
        <a href="{{ route('barbero.turnos') }}" class="btn btn-outline-primary volver-btn" accesskey="b" aria-label="Volver al listado de turnos (Alt+B)">
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
<div id="modal-turno-exito" class="modal-turno-exito" style="display:none;">
    <div class="modal-turno-exito-content">
        <button type="button" class="modal-turno-exito-close" aria-label="Cerrar" tabindex="0">&times;</button>
        <h3>¡Turno registrado!</h3>
        <p>El turno se registró correctamente.</p>
        <div class="modal-turno-exito-actions">
            <button type="button" class="modal-turno-exito-accept">Aceptar</button>
        </div>
    </div>
</div>

<!-- Modal de error para turno -->
<div id="modal-turno-error" class="modal-turno-error" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:10001;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2rem 2rem 2rem;border-radius:24px;max-width:90vw;width:400px;box-shadow:0 2px 16px #0002;outline:0;position:relative;display:flex;flex-direction:column;align-items:center;">
        <button type="button" class="modal-turno-error-close" aria-label="Cerrar" tabindex="0" style="position:absolute;top:18px;right:18px;background:transparent;border:none;font-size:1.7rem;color:#22304a;cursor:pointer;line-height:1;">&times;</button>
        <h2 style="margin:0 0 0.5rem 0;font-size:1.6rem;font-weight:700;color:#b91c1c;text-align:center;">¡Error al registrar turno!</h2>
        <p id="modal-turno-error-msg" style="margin:0 0 2rem 0;font-size:1.1rem;color:#22304a;text-align:center;"></p>
        <div style="display:flex;justify-content:center;width:100%;">
            <button type="button" class="modal-turno-error-accept" style="background:#22304a;color:#fff;border:none;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Aceptar</button>
        </div>
    </div>
</div>

<script>
window.turnosAvailableRoute = "{{ route('barbero.turnos.available') }}";
window.turnosStoreRoute = "{{ route('barbero.turnos.store') }}";
</script>
@vite(['resources/js/Barberos/turnos.js'])
   
@endsection
