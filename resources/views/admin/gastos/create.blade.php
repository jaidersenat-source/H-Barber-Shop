@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/gastos/create.css'])

<main id="modulo-gastos-crear" class="reportes-container" role="main" aria-labelledby="crear-titulo">

    <div class="modulo-header">
        <h2 id="crear-titulo">Registrar Gasto</h2>
        <a href="{{ route('admin.gastos.index') }}" class="btn btn-secundario">
            <span aria-hidden="true">←</span> Volver
        </a>
    </div>

    @if($errors->any())
    <div class="alerta alerta-error" role="alert" aria-live="polite">
        <strong>❌ Corrige los siguientes errores:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <section class="reporte-seccion">
        <form method="POST" action="{{ route('admin.gastos.store') }}"
              enctype="multipart/form-data" aria-label="Formulario de registro de gasto">
            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label for="categoria_id">
                        Categoría <span class="requerido" aria-hidden="true">*</span>
                    </label>
                    <select name="categoria_id" id="categoria_id"
                            required aria-required="true"
                            class="{{ $errors->has('categoria_id') ? 'input-error' : '' }}">
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <span class="error-msg" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sede_id">Sede</label>
                    <select name="sede_id" id="sede_id">
                        <option value="">General (sin sede específica)</option>
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->sede_id }}"
                                {{ old('sede_id') == $sede->sede_id ? 'selected' : '' }}>
                                {{ $sede->sede_nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-group--full">
                    <label for="descripcion">
                        Descripción <span class="requerido" aria-hidden="true">*</span>
                    </label>
                    <input type="text" name="descripcion" id="descripcion"
                           value="{{ old('descripcion') }}"
                           required aria-required="true" maxlength="255"
                           placeholder="Ej: Pago arriendo mes de enero"
                           class="{{ $errors->has('descripcion') ? 'input-error' : '' }}">
                    @error('descripcion')
                        <span class="error-msg" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="monto">
                        Monto <span class="requerido" aria-hidden="true">*</span>
                    </label>
                    <input type="number" name="monto" id="monto"
                           value="{{ old('monto') }}"
                           required aria-required="true"
                           min="0.01" step="0.01"
                           placeholder="0.00"
                           class="{{ $errors->has('monto') ? 'input-error' : '' }}"
                           aria-label="Monto en pesos colombianos">
                    @error('monto')
                        <span class="error-msg" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha">
                        Fecha <span class="requerido" aria-hidden="true">*</span>
                    </label>
                    <input type="date" name="fecha" id="fecha"
                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
                           required aria-required="true"
                           class="{{ $errors->has('fecha') ? 'input-error' : '' }}">
                    @error('fecha')
                        <span class="error-msg" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group form-group--full">
                    <label for="comprobante">
                        Comprobante
                        <span class="hint">(PDF, JPG o PNG — máx. 5MB)</span>
                    </label>
                    <input type="file" name="comprobante" id="comprobante"
                           accept=".pdf,.jpg,.jpeg,.png"
                           aria-describedby="comprobante-desc">
                    <span id="comprobante-desc" class="sr-only">
                        Adjunta el comprobante del gasto en formato PDF, JPG o PNG. Opcional.
                    </span>
                    @error('comprobante')
                        <span class="error-msg" role="alert">{{ $message }}</span>
                    @enderror
                </div>

            </div>{{-- /form-grid --}}

            <div class="btn-group" style="margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <span aria-hidden="true">💾</span> Guardar gasto
                </button>
                <a href="{{ route('admin.gastos.index') }}" class="btn btn-secundario">
                    Cancelar
                </a>
            </div>

        </form>
    </section>

</main>

<style>
.sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }
</style>
@endsection