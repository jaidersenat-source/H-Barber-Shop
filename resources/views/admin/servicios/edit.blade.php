@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/servicios/edit.css'])
<div class="servicios-container" id="modulo-servicios-edit">
    <h2 tabindex="0">Editar {{ $servicio->serv_categoria === 'combos' ? 'Combo' : 'Servicio' }}</h2>

    @if($errors->any())
        <div role="alert" aria-live="assertive" style="color:#DC2626;margin-bottom:1rem;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('servicios.update', $servicio->serv_id) }}" aria-label="Formulario para editar servicio o combo">
        @csrf @method('PUT')

        <label for="serv_categoria">Categoría</label>
        <select name="serv_categoria" id="serv_categoria" required tabindex="0" aria-label="Categoría del servicio. Seleccione combos para definir un combo especial.">
            <option value="">Seleccione una categoría</option>
            <option value="cortes" {{ old('serv_categoria', $servicio->serv_categoria)=='cortes' ? 'selected' : '' }}>Cortes de Cabello</option>
            <option value="barba" {{ old('serv_categoria', $servicio->serv_categoria)=='barba' ? 'selected' : '' }}>Servicios de Barba</option>
            <option value="tratamientos" {{ old('serv_categoria', $servicio->serv_categoria)=='tratamientos' ? 'selected' : '' }}>Tratamientos Especiales</option>
            <option value="combos" {{ old('serv_categoria', $servicio->serv_categoria)=='combos' ? 'selected' : '' }}>Combos Especiales</option>
        </select>
        @error('serv_categoria')<span class="error" role="alert">{{ $message }}</span>@enderror

        {{-- Sección de servicios incluidos (visible solo cuando categoría = combos) --}}
        @php
            $incluidosActuales = old('serv_servicios_incluidos', $servicio->serv_servicios_incluidos ?? []);
        @endphp
        <fieldset id="combo-servicios-fieldset" class="combo-servicios-fieldset" style="{{ old('serv_categoria', $servicio->serv_categoria) === 'combos' ? '' : 'display:none;' }}" aria-label="Servicios incluidos en el combo">
            <legend>Servicios incluidos en el combo</legend>
            <p class="combo-help" id="combo-help-text">Seleccione los servicios que forman parte de este combo. Puede marcar varios.</p>

            <div class="combo-servicios-list" role="group" aria-describedby="combo-help-text">
                @forelse($serviciosDisponibles as $sd)
                    <label class="combo-servicio-check" for="serv_inc_{{ $sd->serv_id }}">
                        <input
                            type="checkbox"
                            name="serv_servicios_incluidos[]"
                            id="serv_inc_{{ $sd->serv_id }}"
                            value="{{ $sd->serv_id }}"
                            {{ in_array($sd->serv_id, $incluidosActuales) ? 'checked' : '' }}
                            tabindex="0"
                            aria-label="{{ $sd->serv_nombre }} — {{ number_format($sd->serv_precio, 2, ',', '') }} pesos colombianos — {{ $sd->serv_duracion }} min"
                        >
                        <span class="combo-servicio-info">
                            <strong>{{ $sd->serv_nombre }}</strong>
                            <small>{{ ucfirst($sd->serv_categoria) }} &bull; {{ number_format($sd->serv_precio, 2, ',', '') }} pesos colombianos &bull; {{ $sd->serv_duracion }} min</small>
                        </span>
                    </label>
                @empty
                    <p>No hay servicios disponibles para incluir en el combo.</p>
                @endforelse
            </div>
            @error('serv_servicios_incluidos')<span class="error" role="alert">{{ $message }}</span>@enderror
        </fieldset>

        <label for="serv_nombre">Nombre</label>
        <input type="text" name="serv_nombre" id="serv_nombre" value="{{ old('serv_nombre', $servicio->serv_nombre) }}" required tabindex="0" aria-label="Nombre del servicio">
        @error('serv_nombre')<span class="error" role="alert">{{ $message }}</span>@enderror

        <label for="serv_descripcion">Descripción</label>
        <textarea name="serv_descripcion" id="serv_descripcion" tabindex="0" aria-label="Descripción del servicio">{{ old('serv_descripcion', $servicio->serv_descripcion) }}</textarea>

        <label for="serv_precio">Precio</label>
        <input type="number" step="0.01" name="serv_precio" id="serv_precio" value="{{ old('serv_precio', $servicio->serv_precio) }}" required tabindex="0" aria-label="Precio del servicio">
        @error('serv_precio')<span class="error" role="alert">{{ $message }}</span>@enderror

        <label for="serv_duracion">Duración (minutos)</label>
        <input type="number" name="serv_duracion" id="serv_duracion" value="{{ old('serv_duracion', $servicio->serv_duracion) }}" required tabindex="0" aria-label="Duración en minutos">
        @error('serv_duracion')<span class="error" role="alert">{{ $message }}</span>@enderror

        <label for="serv_estado">Estado</label>
        <select name="serv_estado" id="serv_estado" tabindex="0" aria-label="Estado del servicio">
            <option value="activo" {{ old('serv_estado', $servicio->serv_estado)=='activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('serv_estado', $servicio->serv_estado)=='inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>

        <label for="serv_descuento">Descuento (%)</label>
        <input type="number" name="serv_descuento" id="serv_descuento" min="0" max="100" step="0.01" value="{{ old('serv_descuento', $servicio->serv_descuento ?? 0) }}" placeholder="Ej: 10 para 10%" tabindex="0" aria-label="Descuento en porcentaje">

        <div class="botones-form">
            <a href="{{ route('servicios.index') }}" class="btn-volver" tabindex="0" aria-label="Volver a la lista de servicios">&larr; Volver</a>
            <button type="submit" class="btn-guardar" tabindex="0" aria-label="Actualizar servicio o combo">Actualizar</button>
        </div>
    </form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('serv_categoria');
    const comboFieldset = document.getElementById('combo-servicios-fieldset');

    function toggleComboSection() {
        const esCombo = categoriaSelect.value === 'combos';
        comboFieldset.style.display = esCombo ? '' : 'none';
        if (!esCombo) {
            comboFieldset.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        }
        const anuncio = document.getElementById('combo-anuncio');
        if (anuncio) {
            anuncio.textContent = esCombo
                ? 'Se muestra la sección para seleccionar servicios incluidos en el combo.'
                : 'Sección de servicios de combo oculta.';
        }
    }

    categoriaSelect.addEventListener('change', toggleComboSection);
    // Inicializar la sección de combo al cargar la página
    toggleComboSection();
});
</script>
<div id="combo-anuncio" class="sr-only" aria-live="polite" role="status"></div>
</div>
@endsection
