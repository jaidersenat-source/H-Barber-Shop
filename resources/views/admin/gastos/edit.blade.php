@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/gastos/edit.css'])

<main id="modulo-gastos-editar" class="reportes-container" role="main" aria-labelledby="editar-titulo">

    <div class="modulo-header">
        <h2 id="editar-titulo">Editar Gasto</h2>
        <a href="{{ route('admin.gastos.index') }}" class="btn btn-secundario">
            <span aria-hidden="true">←</span> Volver
        </a>
    </div>

    @if($errors->any())
    <div class="alerta alerta-error" role="alert">
        <strong>❌ Corrige los siguientes errores:</strong>
        <ul>
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <section class="reporte-seccion">
        <form method="POST" action="{{ route('admin.gastos.update', $gasto) }}"
              enctype="multipart/form-data" aria-label="Formulario de edición de gasto">
            @csrf @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label for="categoria_id">Categoría <span class="requerido" aria-hidden="true">*</span></label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('categoria_id', $gasto->categoria_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')<span class="error-msg" role="alert">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="sede_id">Sede</label>
                    <select name="sede_id" id="sede_id">
                        <option value="">General (sin sede específica)</option>
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}"
                                {{ old('sede_id', $gasto->sede_id) == $sede->id ? 'selected' : '' }}>
                                {{ $sede->sed_nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-group--full">
                    <label for="descripcion">Descripción <span class="requerido" aria-hidden="true">*</span></label>
                    <input type="text" name="descripcion" id="descripcion"
                           value="{{ old('descripcion', $gasto->descripcion) }}"
                           required maxlength="255">
                    @error('descripcion')<span class="error-msg" role="alert">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                          <label for="monto">Monto <span class="requerido" aria-hidden="true">*</span></label>
                          <input type="number" name="monto" id="monto"
                              value="{{ old('monto', $gasto->monto) }}"
                              required min="0.01" step="0.01"
                              aria-label="Monto en pesos colombianos">
                    @error('monto')<span class="error-msg" role="alert">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha <span class="requerido" aria-hidden="true">*</span></label>
                    <input type="date" name="fecha" id="fecha"
                           value="{{ old('fecha', $gasto->fecha->format('Y-m-d')) }}"
                           required>
                    @error('fecha')<span class="error-msg" role="alert">{{ $message }}</span>@enderror
                </div>

                <div class="form-group form-group--full">
                    <label for="comprobante">
                        Comprobante
                        <span class="hint">(deja vacío para mantener el actual)</span>
                    </label>

                    {{-- Mostrar comprobante actual --}}
                    @if($gasto->comprobante)
                    <div class="comprobante-actual">
                        <span aria-hidden="true">📎</span>
                        <a href="{{ Storage::url($gasto->comprobante) }}"
                           target="_blank" rel="noopener">
                            Ver comprobante actual
                        </a>
                    </div>
                    @endif

                    <input type="file" name="comprobante" id="comprobante"
                           accept=".pdf,.jpg,.jpeg,.png">
                    @error('comprobante')<span class="error-msg" role="alert">{{ $message }}</span>@enderror
                </div>

            </div>

            <div class="btn-group" style="margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <span aria-hidden="true">💾</span> Actualizar gasto
                </button>
                <a href="{{ route('admin.gastos.index') }}" class="btn btn-secundario">Cancelar</a>
            </div>

        </form>
    </section>

</main>
@endsection