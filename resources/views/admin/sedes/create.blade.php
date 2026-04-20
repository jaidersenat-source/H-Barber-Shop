@extends('admin.layout')

@section('title', 'Crear Sede')

@section('content')
@vite(['resources/css/Admin/sede/create.css'])

<main id="modulo-sedes-create">
    <div class="card">
        <h1 id="form-title">Registrar Nueva Sede</h1>

        <form
            method="POST"
            action="{{ route('sedes.store') }}"
            enctype="multipart/form-data"
            aria-labelledby="form-title"
            aria-describedby="form-instructions"
            novalidate
        >
            @csrf

            <p id="form-instructions" class="sr-only">
                Complete el formulario para registrar una nueva sede. Los campos marcados como obligatorios deben ser completados antes de guardar.
            </p>

            <fieldset>
                <legend>Información de la Sede</legend>

                {{-- Nombre --}}
                <div class="form-group">
            
                        Nombre de la sede
                        <span aria-hidden="true" class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="sede_nombre"
                        name="sede_nombre"
                        value="{{ old('sede_nombre') }}"
                        required
                        aria-required="true"
                        aria-describedby="sede_nombre_error"
                        autocomplete="organization"
                    >
                    <span id="sede_nombre_error" class="error-message" role="alert" aria-live="polite">
                        @error('sede_nombre') {{ $message }} @enderror
                    </span>
                </div>

                {{-- Dirección --}}
                <div class="form-group">
                    <label for="sede_direccion">
                        Dirección de la sede
                        <span aria-hidden="true" class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="sede_direccion"
                        name="sede_direccion"
                        value="{{ old('sede_direccion') }}"
                        required
                        aria-required="true"
                        aria-describedby="sede_direccion_error"
                        autocomplete="street-address"
                    >
                    <span id="sede_direccion_error" class="error-message" role="alert" aria-live="polite">
                        @error('sede_direccion') {{ $message }} @enderror
                    </span>
                </div>

                 <div class="form-group">
                    <label for="sede_telefono">
                        Número de teléfono de la sede
                        <span aria-hidden="true" class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="sede_telefono"
                        name="sede_telefono"
                        value="{{ old('sede_telefono') }}"
                        required
                        aria-required="true"
                        aria-describedby="sede_telefono_error"
                        autocomplete="tel"
                    >
                    <span id="sede_telefono_error" class="error-message" role="alert" aria-live="polite">
                        @error('sede_telefono') {{ $message }} @enderror
                    </span>
                </div>

                {{-- Coordenadas (opcional) --}}
                <div class="form-group">
                    <label for="sede_lat">Coordenadas (latitud / longitud)</label>
                    <div style="display:flex;gap:0.5rem;align-items:center;">
                        <input
                            type="text"
                            id="sede_lat"
                            name="sede_lat"
                            value="{{ old('sede_lat') }}"
                            placeholder="Latitud (ej. 4.711)"
                            aria-describedby="sede_lat_error"
                            style="flex:1;"
                        >
                        <input
                            type="text"
                            id="sede_lng"
                            name="sede_lng"
                            value="{{ old('sede_lng') }}"
                            placeholder="Longitud (ej. -74.072)"
                            aria-describedby="sede_lng_error"
                            style="flex:1;"
                        >
                    </div>
                    <p class="hint">Opcional: puede pegar coordenadas manualmente. El sistema intentará geocodificar la dirección si no se proveen coordenadas.</p>
                    <span id="sede_lat_error" class="error-message" role="alert" aria-live="polite">
                        @error('sede_lat') {{ $message }} @enderror
                    </span>
                    <span id="sede_lng_error" class="error-message" role="alert" aria-live="polite">
                        @error('sede_lng') {{ $message }} @enderror
                    </span>
                </div>

                {{-- Slogan --}}
                <div class="form-group">
                    <label for="sede_slogan">
                        Slogan de la sede
                    </label>
                    <input
                        type="text"
                        id="sede_slogan"
                        name="sede_slogan"
                        value="{{ old('sede_slogan') }}"
                        autocomplete="off"
                    >
                </div>

                {{-- Descripción --}}
                <div class="form-group">
                    <label for="sede_descripcion">
                        Descripción de la sede
                    </label>
                    <textarea
                        id="sede_descripcion"
                        name="sede_descripcion"
                        rows="4"
                    >{{ old('sede_descripcion') }}</textarea>
                </div>

                {{-- Logo --}}
                <div class="form-group">
                    <label for="sede_logo">
                        Logo de la sede
                    </label>
                    <div class="file-input-wrapper">
                        <input
                            type="file"
                            id="sede_logo"
                            name="sede_logo"
                            accept="image/*"
                            autocomplete="off"
                            aria-describedby="sede_logo_hint"
                            onchange="previsualizarLogo(event)"
                            class="file-input-hidden"
                        >
                        <div class="file-input-label" aria-hidden="true">
                            <span class="file-input-btn">Elegir archivo</span>
                            <span class="file-input-name" id="file-name-display">Ningún archivo seleccionado</span>
                        </div>
                    </div>
                    <p id="sede_logo_hint" class="hint">
                        Seleccione una imagen (JPG, PNG, GIF, máximo 2MB)
                    </p>

                    {{-- Vista previa --}}
                    <div id="preview-container" style="margin-top:1rem;display:none;">
                        <img id="logo-preview"
                             src=""
                             alt="Vista previa del logo"
                             style="max-width:200px;max-height:200px;border-radius:8px;border:2px solid #ddd;">
                    </div>

                    <span class="error-message" role="alert" aria-live="polite">
                        @error('sede_logo') {{ $message }} @enderror
                    </span>
                </div>

            </fieldset>

            <div class="botones-form">
                <a
                    href="{{ route('sedes.index') }}"
                    class="btn volver-btn"
                    aria-label="Cancelar y volver al listado de sedes"
                >
                    <span aria-hidden="true">&larr;</span> Cancelar
                </a>
                <button type="submit" class="btn guardar-btn">
                    Guardar Sede
                </button>
            </div>

        </form>
    </div>
</main>

<script>
function previsualizarLogo(event) {
    const file = event.target.files[0];
    const preview   = document.getElementById('logo-preview');
    const container = document.getElementById('preview-container');
    const nameDisplay = document.getElementById('file-name-display');

    if (file) {
        nameDisplay.textContent = file.name;
        nameDisplay.style.color = '#000000';
        nameDisplay.style.fontStyle = 'normal';
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            container.style.display = 'none';
        }
    } else {
        nameDisplay.textContent = 'Ningún archivo seleccionado';
        nameDisplay.style.color = '#6b7280';
        nameDisplay.style.fontStyle = 'italic';
        container.style.display = 'none';
    }
}
</script>

<script>
// Validación cliente y sanitización para el formulario de sedes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#modulo-sedes-create form');
    const telefono = document.getElementById('sede_telefono');
    const nombre = document.getElementById('sede_nombre');
    const direccion = document.getElementById('sede_direccion');
    const telError = document.getElementById('sede_telefono_error');

    if (telefono) {
        // permitir sólo dígitos
        telefono.addEventListener('input', function() {
            const raw = this.value;
            const digits = raw.replace(/\D+/g, '');
            if (raw !== digits) {
                this.value = digits;
            }
            // feedback rápido
            if (this.value.length < 7) {
                telError.textContent = 'El teléfono debe tener al menos 7 dígitos.';
                telError.style.display = 'block';
            } else if (this.value.length > 10) {
                telError.textContent = 'Máximo 10 dígitos.';
                telError.style.display = 'block';
            } else {
                telError.textContent = '';
                telError.style.display = 'none';
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            const errors = [];
            if (!nombre || !nombre.value.trim()) {
                errors.push('El nombre de la sede es obligatorio.');
                document.getElementById('sede_nombre_error').textContent = 'El nombre de la sede es obligatorio.';
            }
            if (!direccion || !direccion.value.trim()) {
                errors.push('La dirección de la sede es obligatoria.');
                document.getElementById('sede_direccion_error').textContent = 'La dirección es obligatoria.';
            }
            if (!telefono || !telefono.value.trim()) {
                errors.push('El teléfono de la sede es obligatorio.');
                document.getElementById('sede_telefono_error').textContent = 'El teléfono es obligatorio.';
            } else if (!/^\d{7,10}$/.test(telefono.value.trim())) {
                errors.push('Teléfono inválido: debe contener entre 7 y 10 dígitos.');
                document.getElementById('sede_telefono_error').textContent = 'Teléfono inválido: 7 a 10 dígitos.';
            }

            if (errors.length > 0) {
                e.preventDefault();
                // focus al primer campo con error
                if (document.getElementById('sede_nombre_error').textContent) {
                    nombre.focus();
                } else if (document.getElementById('sede_direccion_error').textContent) {
                    direccion.focus();
                } else {
                    telefono.focus();
                }
            }
        });
    }
});
</script>

<script>
// Manejo y validación simple de lat/lng en inputs: normalizar coma a punto y validar rangos
document.addEventListener('DOMContentLoaded', function() {
    const latInput = document.getElementById('sede_lat');
    const lngInput = document.getElementById('sede_lng');
    const latErr = document.getElementById('sede_lat_error');
    const lngErr = document.getElementById('sede_lng_error');

    function sanitizeDecimal(el) {
        if (!el) return;
        el.addEventListener('input', function() {
            let v = this.value.trim();
            // reemplazar coma por punto
            v = v.replace(/,/g, '.');
            // permitir signo negativo, dígitos y punto
            v = v.replace(/[^0-9.\-]+/g, '');
            // evitar múltiples puntos
            const parts = v.split('.');
            if (parts.length > 2) {
                v = parts.shift() + '.' + parts.join('');
            }
            this.value = v;
        });
    }

    sanitizeDecimal(latInput);
    sanitizeDecimal(lngInput);

    // validar rangos al enviar
    const form = document.querySelector('#modulo-sedes-create form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let coordErrors = false;
            if (latInput && latInput.value.trim() !== '') {
                const lat = parseFloat(latInput.value);
                if (Number.isNaN(lat) || lat < -90 || lat > 90) {
                    latErr.textContent = 'Latitud inválida. Debe estar entre -90 y 90.';
                    latErr.style.display = 'block';
                    coordErrors = true;
                } else {
                    latErr.textContent = '';
                    latErr.style.display = 'none';
                }
            }
            if (lngInput && lngInput.value.trim() !== '') {
                const lng = parseFloat(lngInput.value);
                if (Number.isNaN(lng) || lng < -180 || lng > 180) {
                    lngErr.textContent = 'Longitud inválida. Debe estar entre -180 y 180.';
                    lngErr.style.display = 'block';
                    coordErrors = true;
                } else {
                    lngErr.textContent = '';
                    lngErr.style.display = 'none';
                }
            }
            if (coordErrors) {
                e.preventDefault();
                // focus al primer campo con error
                if (latErr.textContent) latInput.focus();
                else lngInput.focus();
            }
        });
    }
});
</script>

@endsection