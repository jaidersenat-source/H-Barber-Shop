@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/gastos.css'])

<main class="reportes-container" role="main" aria-labelledby="cat-editar-titulo">

    <div class="modulo-header">
        <h2 id="cat-editar-titulo">Editar Categoría</h2>
        <a href="{{ route('admin.categorias-gastos.index') }}" class="btn btn-secundario">← Volver</a>
    </div>

    <section class="reporte-seccion">
        <form method="POST" action="{{ route('admin.categorias-gastos.update', $categoria) }}">
            @csrf @method('PUT')
            <div class="form-grid">

                <div class="form-group form-group--full">
                    <label for="nombre">Nombre <span class="requerido">*</span></label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre', $categoria->nombre) }}"
                           required maxlength="100">
                    @error('nombre')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group form-group--full">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="activo">Estado</label>
                    <select name="activo" id="activo">
                        <option value="1" {{ old('activo', $categoria->activo) ? 'selected' : '' }}>Activa</option>
                        <option value="0" {{ !old('activo', $categoria->activo) ? 'selected' : '' }}>Inactiva</option>
                    </select>
                </div>

            </div>
            <div class="btn-group" style="margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">💾 Actualizar</button>
                <a href="{{ route('admin.categorias-gastos.index') }}" class="btn btn-secundario">Cancelar</a>
            </div>
        </form>
    </section>
</main>
@endsection