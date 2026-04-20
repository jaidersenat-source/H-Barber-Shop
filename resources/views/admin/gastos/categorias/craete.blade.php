@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/gastos.css'])

<main class="reportes-container" role="main" aria-labelledby="cat-crear-titulo">

    <div class="modulo-header">
        <h2 id="cat-crear-titulo">Nueva Categoría</h2>
        <a href="{{ route('admin.categorias-gastos.index') }}" class="btn btn-secundario">← Volver</a>
    </div>

    @if($errors->any())
    <div class="alerta alerta-error" role="alert">
        <strong>❌</strong>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <section class="reporte-seccion">
        <form method="POST" action="{{ route('admin.categorias-gastos.store') }}">
            @csrf
            <div class="form-grid">

                <div class="form-group form-group--full">
                    <label for="nombre">Nombre <span class="requerido">*</span></label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre') }}" required maxlength="100"
                           class="{{ $errors->has('nombre') ? 'input-error' : '' }}">
                    @error('nombre')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

                <div class="form-group form-group--full">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion"
                              rows="3" maxlength="500">{{ old('descripcion') }}</textarea>
                    @error('descripcion')<span class="error-msg">{{ $message }}</span>@enderror
                </div>

            </div>
            <div class="btn-group" style="margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">💾 Guardar</button>
                <a href="{{ route('admin.categorias-gastos.index') }}" class="btn btn-secundario">Cancelar</a>
            </div>
        </form>
    </section>
</main>
@endsection