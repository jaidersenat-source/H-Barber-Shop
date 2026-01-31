@extends('admin.layout')
@vite(['resources/css/Admin/productos/create.css'])
@section('content')
<div class="productos-container" id="modulo-productos-create">
    <div class="productos-header">
        <h2 tabindex="0">Crear Producto</h2>
    </div>
    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data" aria-label="Formulario para crear producto" class="producto-form">
        @csrf


        <div class="form-grupo">
            <label for="pro_nombre">Nombre</label>
            <input type="text" name="pro_nombre" id="pro_nombre" required aria-label="Nombre del producto">
        </div>

        <div class="form-grupo">
            <label for="pro_descripcion">Descripción</label>
            <textarea name="pro_descripcion" id="pro_descripcion" tabindex="0" aria-label="Descripción del producto"></textarea>
        </div>


        <div class="form-grupo">
            <label for="pro_precio">Precio</label>
            <input type="number" step="0.01" name="pro_precio" id="pro_precio" required aria-label="Precio del producto">
        </div>

        <div class="form-grupo">
            <label for="pro_descuento">Descuento (%)</label>
            <input type="number" name="pro_descuento" min="0" max="100" step="0.01" value="{{ old('pro_descuento', 0) }}" placeholder="Ej: 10 para 10%" aria-label="Descuento en porcentaje">
        </div>


        <div class="form-grupo">
            <label for="pro_stock">Stock</label>
            <input type="number" name="pro_stock" id="pro_stock" required aria-label="Stock disponible">
        </div>


        <div class="form-grupo">
            <label for="pro_imagen">Imagen (opcional)</label>
            <input type="file" name="pro_imagen" id="pro_imagen" aria-label="Imagen del producto">
        </div>

        <div class="form-acciones">
            <button type="submit" class="btn-guardar" aria-label="Guardar producto">Guardar</button>
            <a href="{{ route('productos.index') }}" class="btn-cancelar" aria-label="Volver al listado de productos">Cancelar</a>
        </div>
    </form>
<script>
// Navegación accesible con flechas y Tab para el formulario Crear Producto
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-productos-create');
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
