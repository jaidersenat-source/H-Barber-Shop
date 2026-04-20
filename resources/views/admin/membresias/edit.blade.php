@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/membresias/create.css'])

<div class="membresias-container">
    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        
        <h2 tabindex="0" style="margin:0;">Editar membresía: {{ $membresia->nombre }}</h2>
    </div>

    @if($errors->any())
        <div role="alert" aria-live="assertive" style="color:#DC2626;margin-bottom:1rem;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('membresias.update', $membresia->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre <span aria-hidden="true">*</span></label>
            <input type="text" id="nombre" name="nombre"
                   value="{{ old('nombre', $membresia->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror"
                   required maxlength="150" aria-required="true">
            @error('nombre')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion"
                      class="form-control @error('descripcion') is-invalid @enderror"
                      rows="3">{{ old('descripcion', $membresia->descripcion) }}</textarea>
            @error('descripcion')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label for="precio">Precio (COP) <span aria-hidden="true">*</span></label>
                <input type="number" id="precio" name="precio"
                       value="{{ old('precio', $membresia->precio) }}"
                       class="form-control @error('precio') is-invalid @enderror"
                       required min="0" step="0.01" aria-required="true">
                @error('precio')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="duracion_meses">Duración <span aria-hidden="true">*</span></label>
                <select id="duracion_meses" name="duracion_meses"
                        class="form-control @error('duracion_meses') is-invalid @enderror"
                        required aria-required="true">
                    @foreach([1 => '1 mes', 3 => '3 meses', 6 => '6 meses', 12 => '1 año (12 meses)'] as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('duracion_meses', $membresia->duracion_meses) == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('duracion_meses')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Beneficio: bloque estructurado que MembresiaService puede leer --}}
        @php
            $benRaw  = $membresia->beneficios ?? [];
            $benTipo = old('ben_tipo', $benRaw['tipo'] ?? 'gratis');
            $benUsos = old('ben_usos_limite', $benRaw['usos_limite'] ?? 1);
            $benPct  = old('ben_descuento_pct', $benRaw['descuento_pct'] ?? '');
            $benServs = old('servicios_aplicables', $benRaw['servicios_aplicables'] ?? []);
        @endphp

        <div class="form-group">
            <label>Tipo de descuento <span aria-hidden="true">*</span></label>
            <select name="ben_tipo" id="ben_tipo" class="form-control" required aria-required="true"
                    onchange="toggleBenFields()">
                <option value="gratis"     {{ $benTipo === 'gratis'     ? 'selected' : '' }}>Gratis (usos limitados)</option>
                <option value="porcentaje" {{ $benTipo === 'porcentaje' ? 'selected' : '' }}>Porcentaje de descuento</option>
            </select>
        </div>

        <div class="form-group" id="campo-usos" style="{{ $benTipo === 'gratis' ? '' : 'display:none;' }}">
            <label for="ben_usos_limite">Número máximo de usos gratuitos</label>
            <input type="number" id="ben_usos_limite" name="ben_usos_limite"
                   value="{{ $benUsos }}"
                   class="form-control" min="1" placeholder="Ej: 5">
            <small style="color:#666;">0 = sin límite de usos.</small>
        </div>

        <div class="form-group" id="campo-pct" style="{{ $benTipo === 'porcentaje' ? '' : 'display:none;' }}">
            <label for="ben_descuento_pct">Porcentaje de descuento (1–100)</label>
            <input type="number" id="ben_descuento_pct" name="ben_descuento_pct"
                   value="{{ $benPct }}"
                   class="form-control" min="1" max="100" step="0.01" placeholder="Ej: 20">
        </div>

        <div class="form-group">
            <label>Servicios donde aplica el descuento</label>
            <small style="color:#666;display:block;margin-bottom:0.5rem;">Si no marcas ninguno, aplica a TODOS los servicios.</small>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                @foreach($servicios as $s)
                    <label style="display:flex;align-items:center;gap:0.35rem;background:#f3f4f6;padding:0.4rem 0.75rem;border-radius:6px;cursor:pointer;font-size:0.875rem;">
                        <input type="checkbox" name="servicios_aplicables[]" value="{{ $s->serv_id }}"
                               {{ in_array($s->serv_id, array_map('intval', (array)$benServs)) ? 'checked' : '' }}>
                        {{ $s->serv_nombre }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Imagen --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label for="imagen">Imagen</label>
                @if($membresia->imagen)
                    <div style="margin-bottom:0.5rem;">
                        <img src="{{ asset('storage/' . $membresia->imagen) }}"
                             alt="Imagen actual de {{ $membresia->nombre }}"
                             style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                        <small style="display:block;color:#666;margin-top:0.25rem;">Imagen actual</small>
                    </div>
                @endif
                <input type="file" id="imagen" name="imagen"
                       class="form-control @error('imagen') is-invalid @enderror"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <small style="color:#666;">Sube una nueva imagen para reemplazar la actual. Máx. 2MB.</small>
                @error('imagen')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div id="imagen-preview" style="margin-top:0.5rem;"></div>
            </div>

            <div class="form-group">
                <label for="orden">Orden de aparición</label>
                <input type="number" id="orden" name="orden"
                       value="{{ old('orden', $membresia->orden) }}"
                       class="form-control @error('orden') is-invalid @enderror"
                       min="0">
                <small style="color:#666;">Menor número = aparece primero.</small>
                @error('orden')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group" style="display:flex;align-items:center;gap:0.75rem;">
            <input type="checkbox" id="activo" name="activo" value="1"
                   {{ old('activo', $membresia->activo) ? 'checked' : '' }}
                   aria-label="Membresía activa">
            <label for="activo" style="margin:0;cursor:pointer;">
                Activa (visible en el sitio público)
            </label>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem;flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="{{ route('membresias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    toggleBenFields();

    document.getElementById('imagen').addEventListener('change', function () {
        const preview = document.getElementById('imagen-preview');
        preview.innerHTML = '';
        if (this.files && this.files[0]) {
            const img = document.createElement('img');
            img.style.cssText = 'width:100px;height:100px;object-fit:cover;border-radius:8px;';
            img.src = URL.createObjectURL(this.files[0]);
            img.alt = 'Vista previa de la nueva imagen';
            preview.appendChild(img);
        }
    });
});

function toggleBenFields() {
    const tipo = document.getElementById('ben_tipo').value;
    document.getElementById('campo-usos').style.display = tipo === 'gratis'     ? '' : 'none';
    document.getElementById('campo-pct').style.display  = tipo === 'porcentaje' ? '' : 'none';
}
</script>
@endsection