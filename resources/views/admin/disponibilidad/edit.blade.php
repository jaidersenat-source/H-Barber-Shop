@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/dispo/edit.css'])

<div class="card" role="main" aria-label="Formulario para editar disponibilidad">
    <h2 tabindex="0">Editar disponibilidad</h2>

    @if ($errors->any())
        <p style="color:red;" role="alert" aria-live="assertive">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('disponibilidad.update', $horario->dis_id) }}" aria-label="Formulario editar disponibilidad">
        @csrf

        <label for="per_documento">Barbero</label>
        <select name="per_documento" id="per_documento" required aria-required="true" aria-label="Seleccionar barbero">
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

        <label for="dia">Día</label>
        <select name="dia" id="dia" required aria-required="true" aria-label="Día de la semana">
            @foreach ($dias as $d)
                <option value="{{ $d }}" {{ $horario->dia == $d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach 

        <label for="dis_hora_inicio">Hora inicio</label>
        <input type="time" name="dis_hora_inicio" id="dis_hora_inicio" value="{{ $horario->dis_hora_inicio }}" required aria-required="true" aria-label="Hora de inicio">

        <label for="dis_hora_fin">Hora fin</label>
        <input type="time" name="dis_hora_fin" id="dis_hora_fin" value="{{ $horario->dis_hora_fin }}" required aria-required="true" aria-label="Hora de fin">

        <label for="dis_estado">Estado</label>
        <select name="dis_estado" id="dis_estado" aria-label="Estado de disponibilidad">
            <option value="disponible" {{ $horario->dis_estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="inactivo" {{ $horario->dis_estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            <option value="ocupado" {{ $horario->dis_estado == 'ocupado' ? 'selected' : '' }}>Ocupado</option>
        </select>

        <button type="submit" aria-label="Actualizar disponibilidad">Actualizar</button>
        <a href="{{ route('disponibilidad.index') }}" aria-label="Cancelar y volver al listado">Cancelar</a>
    </form>
    
    </form>
</div>
@endsection
