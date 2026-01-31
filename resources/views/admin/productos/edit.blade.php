@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/productos/edit.css'])
<div class="productos-container" id="modulo-productos-edit">
    <div class="productos-header">
        <h2 id="titulo-editar-producto" tabindex="0">Editar Producto</h2>
    </div>
    <form method="POST" action="{{ route('productos.update', $producto->pro_id) }}" enctype="multipart/form-data" aria-labelledby="titulo-editar-producto" role="form" class="producto-form">
        @csrf @method('PUT')

        <div class="form-grupo">
            <label id="label-nombre" for="pro_nombre">Nombre</label>
            <input id="pro_nombre" type="text" name="pro_nombre" value="{{ old('pro_nombre', $producto->pro_nombre) }}" required aria-required="true">
            @error('pro_nombre')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grupo">
            <label id="label-descripcion" for="pro_descripcion">Descripción</label>
            <textarea id="pro_descripcion" name="pro_descripcion" tabindex="2">{{ old('pro_descripcion', $producto->pro_descripcion) }}</textarea>
            @error('pro_descripcion')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-grupo">
            <label id="label-precio" for="pro_precio">Precio</label>
            <input id="pro_precio" type="number" step="0.01" name="pro_precio" value="{{ old('pro_precio', $producto->pro_precio) }}" required aria-required="true">
            @error('pro_precio')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grupo">
            <label id="label-descuento" for="pro_descuento">Descuento (%)</label>
            <input id="pro_descuento" type="number" name="pro_descuento" min="0" max="100" step="0.01" value="{{ old('pro_descuento', $producto->pro_descuento ?? 0) }}" placeholder="Ej: 10 para 10%" aria-label="Descuento en porcentaje">
            @error('pro_descuento')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-grupo">
            <label id="label-stock" for="pro_stock">Stock</label>
            <input id="pro_stock" type="number" name="pro_stock" value="{{ old('pro_stock', $producto->pro_stock) }}" required aria-required="true">
            @error('pro_stock')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-grupo">
            <label id="label-estado" for="pro_estado">Estado</label>
            <select id="pro_estado" name="pro_estado" aria-required="true">
                <option value="activo" {{ old('pro_estado', $producto->pro_estado)=='activo'?'selected':'' }}>Activo</option>
                <option value="inactivo" {{ old('pro_estado', $producto->pro_estado)=='inactivo'?'selected':'' }}>Inactivo</option>
            </select>
            @error('pro_estado')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-grupo">
            <label id="label-imagen" for="pro_imagen">Imagen (opcional)</label>
            <input id="pro_imagen" type="file" name="pro_imagen" aria-describedby="imagen-actual">
            @error('pro_imagen')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror

            @if($producto->pro_imagen)
                <p id="imagen-actual">Imagen actual:</p>
                <img src="{{ asset('storage/'.$producto->pro_imagen) }}" width="80" alt="Imagen del producto {{ $producto->pro_nombre }}" aria-describedby="desc-img-edit">
                <span id="desc-img-edit" class="sr-only">Imagen del producto {{ $producto->pro_nombre }}. Si la imagen no es descriptiva, consulte el nombre o descripción del producto.</span>
            @endif
        </div>

        <div class="form-acciones">
            <button type="submit" class="btn-guardar" aria-label="Actualizar producto">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn-cancelar" aria-label="Volver al listado de productos">Cancelar</a>
        </div>
    </form>
<script>
// Navegación accesible con flechas y Tab para el formulario Editar Producto
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-productos-edit');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;
    let current = 0;
    focusables[0].focus();
    modulo.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Focus trap
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.shiftKey) {
                if (document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                if (document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            }
        } else if (["ArrowDown", "ArrowRight"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let next = (current + 1) % focusables.length;
                focusables[next].focus();
            }
        } else if (["ArrowUp", "ArrowLeft"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let prev = (current - 1 + focusables.length) % focusables.length;
                focusables[prev].focus();
            }
        } else if (e.key === 'Escape') {
            const menu = document.querySelector('.sidebar a');
            if (menu) menu.focus();
        }
    });
});
</script>
</div>
@endsection
