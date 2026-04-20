@extends('admin.layout')

@section('content')
<div class="card" role="region" aria-labelledby="form-title" id="modulo-personal">
    <h1 id="form-title">Registrar Barbero</h1>

   @vite(['resources/css/Admin/personal/create.css'])

    {{-- Región para mensajes de error --}}
    @if ($errors->any())
    <div class="alert alert-error" role="alert" aria-live="assertive">
        <h2 class="sr-only">Errores en el formulario</h2>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Región para mensajes de éxito --}}
    @if (session('success'))
    <div class="alert alert-success" role="status" aria-live="polite">
        {{ session('success') }}
    </div>
    @endif

        <div class="sr-only" id="keyboard-help">Para volver al listado de barberos, presiona Alt + B en cualquier momento.</div>
        <form method="POST" 
            action="{{ route('personal.store') }}" 
            id="personalForm"
            aria-describedby="form-instructions keyboard-help"
            novalidate>
        @csrf

        <p id="form-instructions" class="sr-only">
            Todos los campos marcados con asterisco son obligatorios. 
            Use Tab para navegar entre campos.
        </p>

        {{-- Grupo: Información Personal --}}
        <fieldset>
            <legend>Información Personal</legend>

            <div class="form-group">
                <label for="per_documento">
                    Documento
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <input type="text" 
                       id="per_documento"
                       name="per_documento" 
                       required
                       aria-required="true"
                       aria-describedby="doc-hint"
                       autocomplete="off"
                       value="{{ old('per_documento') }}"
                       class="@error('per_documento') input-error @enderror">
                <span id="doc-hint" class="hint">Número de identificación sin puntos ni guiones</span>
                @error('per_documento')
                    <span class="error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="per_nombre">
                    Nombre
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <input type="text" 
                       id="per_nombre"
                       name="per_nombre" 
                       required
                       aria-required="true"
                       autocomplete="given-name"
                       value="{{ old('per_nombre') }}"
                       class="@error('per_nombre') input-error @enderror">
                @error('per_nombre')
                    <span class="error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="per_apellido">
                    Apellido
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <input type="text" 
                       id="per_apellido"
                       name="per_apellido" 
                       required
                       aria-required="true"
                       autocomplete="family-name"
                       value="{{ old('per_apellido') }}"
                       class="@error('per_apellido') input-error @enderror">
                @error('per_apellido')
                    <span class="error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </fieldset>

        {{-- Grupo: Información de Contacto --}}
        <fieldset>
            <legend>Información de Contacto</legend>

            <div class="form-group">
                <label for="per_correo">
                    Correo electrónico
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <input type="email" 
                       id="per_correo"
                       name="per_correo" 
                       required
                       aria-required="true"
                       aria-describedby="email-hint"
                       autocomplete="email"
                       value="{{ old('per_correo') }}"
                       class="@error('per_correo') input-error @enderror">
                <span id="email-hint" class="hint">Ejemplo: nombre@dominio.com</span>
                @error('per_correo')
                    <span class="error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="per_telefono">
                    Teléfono
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <input type="tel" 
                       id="per_telefono"
                       name="per_telefono" 
                       required
                       aria-required="true"
                       aria-describedby="tel-hint"
                       autocomplete="tel"
                       value="{{ old('per_telefono') }}"
                       class="@error('per_telefono') input-error @enderror">
                <span id="tel-hint" class="hint">Incluya código de área</span>
                @error('per_telefono')
                    <span class="error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </fieldset>

        {{-- Grupo: Asignación --}}
        <fieldset>
            <legend>Asignación</legend>

            <div class="form-group">
                <label for="sede_id">
                    Sede
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(obligatorio)</span>
                </label>
                <select id="sede_id"
                        name="sede_id" 
                        required
                        aria-required="true"
                        class="@error('sede_id') input-error @enderror">
                    <option value="">-- Seleccione una sede --</option>
                    @foreach($sede as $s)
                        <option value="{{ $s->sede_id }}" {{ old('sede_id') == $s->sede_id ? 'selected' : '' }}>
                            {{ $s->sede_nombre }}
                        </option>
                    @endforeach
                </select>
                @error('sede_id')
                    <span class="error-message" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- El rol del usuario creado aquí siempre será "barbero"; no permitir selección en este formulario --}}
            <input type="hidden" name="rol" value="barbero">
        </fieldset>

        {{-- Botones de acción --}}
        <div class="form-actions">
            <a href="{{ route('personal.index') }}" class="btn btn-secondary" accesskey="b" aria-label="Volver al listado de barberos (Alt+B)">
                <span aria-hidden="true">←</span> Volver
            </a>
            <button type="submit" class="btn btn-primary" aria-label="Guardar nuevo barbero">
                Guardar Barbero
            </button>
        </div>
    </form>

    {{-- Región de anuncios para lectores de pantalla --}}
    <div id="sr-announcements" 
         class="sr-only" 
         role="status" 
         aria-live="polite" 
         aria-atomic="true">
    </div>
</div>
<script>
window.turnosAvailableRoute = "{{ route('turnos.available') }}";
window.turnosStoreRoute = "{{ route('turnos.store') }}";
</script>
@vite(['resources/js/Admin/personal.js'])

@endsection
