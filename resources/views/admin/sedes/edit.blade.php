@extends('admin.layout')

@section('title', 'Editar Sede')

@section('content')

@vite(['resources/css/Admin/sede/edit.css'])

<main id="modulo-sedes-form">
    <div class="card">

        <h1 id="editar-sede-titulo">Editar Sede</h1>

        <form 
            method="POST" 
            action="{{ route('sedes.update', $sede->sede_id) }}" 
            enctype="multipart/form-data"
            aria-labelledby="editar-sede-titulo"
            aria-describedby="form-instructions" 
            novalidate
        >
            @csrf
            @method('PUT')

            <p id="form-instructions" class="sr-only">
                Complete el formulario para editar la sede. Los campos marcados como obligatorios deben ser completados antes de guardar.
            </p>

            <fieldset>
                <legend>Información de la Sede</legend>

                {{-- Nombre --}}
                <div class="form-group">
                    <label for="sede_nombre_edit">
                        Nombre de la sede
                        <span aria-hidden="true" class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="sede_nombre_edit" 
                        name="sede_nombre" 
                        value="{{ old('sede_nombre', $sede->sede_nombre) }}" 
                        required 
                        aria-required="true"
                        aria-describedby="sede_nombre_edit_error"
                        autocomplete="organization"
                    >
                    <span id="sede_nombre_edit_error" class="sr-only" role="alert" aria-live="polite">
                        @error('sede_nombre') {{ $message }} @enderror
                    </span>
                </div>

                {{-- Dirección --}}
                <div class="form-group">
                    <label for="sede_direccion_edit">
                        Dirección de la sede
                        <span aria-hidden="true" class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="sede_direccion_edit" 
                        name="sede_direccion" 
                        value="{{ old('sede_direccion', $sede->sede_direccion) }}" 
                        required 
                        aria-required="true"
                        aria-describedby="sede_direccion_edit_error"
                        autocomplete="street-address"
                    >
                    <span id="sede_direccion_edit_error" class="sr-only" role="alert" aria-live="polite">
                        @error('sede_direccion') {{ $message }} @enderror
                    </span>
                </div>

                  <div class="form-group">
                    <label for="sede_telefono_edit">
                        Número de teléfono de la sede
                        <span aria-hidden="true" class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="sede_telefono_edit" 
                        name="sede_telefono" 
                        value="{{ old('sede_telefono', $sede->sede_telefono) }}" 
                        required 
                        aria-required="true"
                        aria-describedby="sede_telefono_edit_error"
                        autocomplete="tel"
                    >
                    <span id="sede_telefono_edit_error" class="sr-only" role="alert" aria-live="polite">
                        @error('sede_telefono') {{ $message }} @enderror
                    </span>
                </div>

                {{-- Coordenadas (opcional) --}}
                <div class="form-group">
                    <label for="sede_lat_edit">Coordenadas (latitud / longitud)</label>
                    <div style="display:flex;gap:0.5rem;align-items:center;">
                        <input 
                            type="text" 
                            id="sede_lat_edit" 
                            name="sede_lat" 
                            value="{{ old('sede_lat', $sede->sede_lat) }}" 
                            placeholder="Latitud (ej. 4.711)" 
                            aria-describedby="sede_lat_edit_error"
                            style="flex:1;"
                        >
                        <input 
                            type="text" 
                            id="sede_lng_edit" 
                            name="sede_lng" 
                            value="{{ old('sede_lng', $sede->sede_lng) }}" 
                            placeholder="Longitud (ej. -74.072)" 
                            aria-describedby="sede_lng_edit_error"
                            style="flex:1;"
                        >
                    </div>
                    <p class="hint">Opcional: puede pegar coordenadas manualmente. El sistema intentará geocodificar la dirección si no se proveen coordenadas.</p>
                    <span id="sede_lat_edit_error" class="sr-only" role="alert" aria-live="polite">
                        @error('sede_lat') {{ $message }} @enderror
                    </span>
                    <span id="sede_lng_edit_error" class="sr-only" role="alert" aria-live="polite">
                        @error('sede_lng') {{ $message }} @enderror
                    </span>
                </div>

                {{-- Slogan --}}
                <div class="form-group">
                    <label for="sede_slogan_edit">
                        Slogan de la sede
                    </label>
                    <input 
                        type="text" 
                        id="sede_slogan_edit" 
                        name="sede_slogan" 
                        value="{{ old('sede_slogan', $sede->sede_slogan) }}" 
                        autocomplete="off"
                    >
                </div>

                {{-- Descripción --}}
                <div class="form-group">
                    <label for="sede_descripcion_edit">
                        Descripción de la sede
                    </label>
                    <textarea 
                        id="sede_descripcion_edit" 
                        name="sede_descripcion"
                        rows="4"
                    >{{ old('sede_descripcion', $sede->sede_descripcion) }}</textarea>
                </div>

  <div class="form-group">
                    <label for="sede_logo_edit">
                        Logo de la sede
                    </label>

                    {{-- Mostrar logo actual --}}
                    @if($sede->sede_logo)
                        <div style="margin-bottom:1rem;">
                            <p style="font-size:0.9rem;color:#666;margin-bottom:0.5rem;">Logo actual:</p>
                            <img src="{{ asset('storage/' . $sede->sede_logo) }}"
                                 alt="Logo actual de {{ $sede->sede_nombre }}"
                                 style="max-width:150px;max-height:150px;border-radius:8px;border:2px solid #ddd;">
                        </div>
                    @endif

                    <div class="file-input-wrapper">
                        <input
                            type="file"
                            id="sede_logo_edit"
                            name="sede_logo"
                            accept="image/*"
                            autocomplete="off"
                            aria-describedby="sede_logo_edit_hint"
                            onchange="previsualizarLogoEdit(event)"
                            class="file-input-hidden"
                        >
                        <div class="file-input-label" aria-hidden="true">
                            <span class="file-input-btn">Elegir archivo</span>
                            <span class="file-input-name" id="file-name-display-edit">Ningún archivo seleccionado</span>
                        </div>
                    </div>

                    <p id="sede_logo_edit_hint" class="hint">
                        Seleccione una nueva imagen para reemplazar el logo actual (JPG, PNG, GIF, máximo 2MB).
                        Si no selecciona nada, se mantendrá el logo actual.
                    </p>

                    {{-- Vista previa del nuevo logo --}}
                    <div id="preview-container-edit" style="margin-top:1rem;display:none;">
                        <p style="font-size:0.9rem;color:#666;margin-bottom:0.5rem;">Vista previa del nuevo logo:</p>
                        <img id="logo-preview-edit"
                             src=""
                             alt="Vista previa del nuevo logo"
                             style="max-width:200px;max-height:200px;border-radius:8px;border:2px solid #10b981;">
                    </div>

                    <span class="error-message" role="alert" aria-live="polite">
                        @error('sede_logo') {{ $message }} @enderror
                    </span>
                </div>

            </fieldset>

            <div class="botones-form">
                <a 
                    href="{{ route('sedes.index') }}" 
                    class="btn btn-outline-primary volver-btn"
                    aria-label="Cancelar y volver al listado de sedes"
                >
                    <span aria-hidden="true">&larr;</span> Cancelar
                </a>
                <button 
                    type="submit" 
                    class="btn btn-primary guardar-btn"
                >
                    Actualizar sede
                </button>
            </div>

        </form>
    </div>
</main>
<script>
function previsualizarLogoEdit(event) {
    const file = event.target.files[0];
    const preview     = document.getElementById('logo-preview-edit');
    const container   = document.getElementById('preview-container-edit');
    const nameDisplay = document.getElementById('file-name-display-edit');

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
// Sanitización y validación para lat/lng en el formulario de edición
document.addEventListener('DOMContentLoaded', function() {
    const latInput = document.getElementById('sede_lat_edit');
    const lngInput = document.getElementById('sede_lng_edit');
    const latErr = document.getElementById('sede_lat_edit_error');
    const lngErr = document.getElementById('sede_lng_edit_error');

    function sanitizeDecimal(el) {
        if (!el) return;
        el.addEventListener('input', function() {
            let v = this.value.trim();
            v = v.replace(/,/g, '.');
            v = v.replace(/[^0-9.\-]+/g, '');
            const parts = v.split('.');
            if (parts.length > 2) {
                v = parts.shift() + '.' + parts.join('');
            }
            this.value = v;
        });
    }

    sanitizeDecimal(latInput);
    sanitizeDecimal(lngInput);

    const form = document.querySelector('#modulo-sedes-form form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let coordErrors = false;
            if (latInput && latInput.value.trim() !== '') {
                const lat = parseFloat(latInput.value);
                if (Number.isNaN(lat) || lat < -90 || lat > 90) {
                    latErr.textContent = 'Latitud inválida. Debe estar entre -90 y 90.';
                    latErr.classList.remove('sr-only');
                    coordErrors = true;
                } else {
                    latErr.textContent = '';
                    latErr.classList.add('sr-only');
                }
            }
            if (lngInput && lngInput.value.trim() !== '') {
                const lng = parseFloat(lngInput.value);
                if (Number.isNaN(lng) || lng < -180 || lng > 180) {
                    lngErr.textContent = 'Longitud inválida. Debe estar entre -180 y 180.';
                    lngErr.classList.remove('sr-only');
                    coordErrors = true;
                } else {
                    lngErr.textContent = '';
                    lngErr.classList.add('sr-only');
                }
            }
            if (coordErrors) {
                e.preventDefault();
                if (latErr.textContent) latInput.focus();
                else lngInput.focus();
            }
        });
    }
});
</script>

@endsection