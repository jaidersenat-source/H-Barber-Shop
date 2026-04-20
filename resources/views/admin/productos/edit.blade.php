@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/productos/edit.css'])
<div class="productos-container" id="modulo-productos-edit">
    <div class="productos-header">
        <h2 id="titulo-editar-producto" tabindex="0">Editar {{ $producto->esKit() ? 'Kit' : 'Producto' }}</h2>
    </div>
    <form method="POST" action="{{ route('productos.update', $producto->pro_id) }}" enctype="multipart/form-data" aria-labelledby="titulo-editar-producto" role="form" class="producto-form">
        @csrf @method('PUT')


        <div class="form-grupo">
            <label id="label-categoria" for="pro_categoria">Categoría</label>
            <select id="pro_categoria" name="pro_categoria" required aria-label="Categoría del producto. Selecciona kit para crear un kit con productos incluidos">
                <option value="">Selecciona una categoría</option>
                <option value="cabello" {{ old('pro_categoria', $producto->pro_categoria)=='cabello'?'selected':'' }}>Cabello</option>
                <option value="barba" {{ old('pro_categoria', $producto->pro_categoria)=='barba'?'selected':'' }}>Barba</option>
                <option value="styling" {{ old('pro_categoria', $producto->pro_categoria)=='styling'?'selected':'' }}>Styling</option>
                <option value="accesorios" {{ old('pro_categoria', $producto->pro_categoria)=='accesorios'?'selected':'' }}>Accesorios</option>
                <option value="kit" {{ old('pro_categoria', $producto->pro_categoria)=='kit'?'selected':'' }}>Kit</option>
            </select>
            @error('pro_categoria')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <!-- Sección de productos incluidos en el kit (visible solo cuando categoría = kit) -->
        @php
            $productosSeleccionados = old('pro_productos_kit', $producto->pro_productos_kit ?? []);
            if (!is_array($productosSeleccionados)) {
                $productosSeleccionados = [];
            }
        @endphp
        <div class="form-grupo" id="seccion-productos-kit" style="display: {{ old('pro_categoria', $producto->pro_categoria) === 'kit' ? 'block' : 'none' }};" aria-live="polite">
            <fieldset>
                <legend id="legend-productos-kit">Productos incluidos en el kit</legend>
                <p class="help-text" id="help-productos-kit">Selecciona los productos que formarán parte de este kit. Puedes seleccionar varios productos.</p>
                
                <div class="productos-kit-lista" role="group" aria-labelledby="legend-productos-kit" aria-describedby="help-productos-kit">
                    @forelse($productosDisponibles as $prod)
                        <div class="producto-kit-item">
                            <input 
                                type="checkbox" 
                                name="pro_productos_kit[]" 
                                id="prod_kit_{{ $prod->pro_id }}" 
                                value="{{ $prod->pro_id }}"
                                {{ in_array($prod->pro_id, $productosSeleccionados) ? 'checked' : '' }}
                                aria-describedby="prod_desc_{{ $prod->pro_id }}"
                            >
                            <label for="prod_kit_{{ $prod->pro_id }}">
                                {{ $prod->pro_nombre }} - ${{ number_format($prod->pro_precio, 2) }}
                            </label>
                            <span id="prod_desc_{{ $prod->pro_id }}" class="sr-only">
                                Producto: {{ $prod->pro_nombre }}, Categoría: {{ ucfirst($prod->pro_categoria) }}, Precio: ${{ number_format($prod->pro_precio, 2) }}
                            </span>
                        </div>
                    @empty
                        <p>No hay productos disponibles para incluir en el kit.</p>
                    @endforelse
                </div>
                
                @error('pro_productos_kit')
                    <span role="alert" style="color:red">{{ $message }}</span>
                @enderror
            </fieldset>
        </div>

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

        <div class="form-grupo">
            <label id="label-stock" for="pro_stock">Stock</label>
            <input id="pro_stock" type="number" name="pro_stock" value="{{ old('pro_stock', $producto->pro_stock) }}" required aria-required="true">
            @error('pro_stock')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

       

        <!-- Sección de productos incluidos en el kit (visible solo cuando categoría = kit) -->
        @php
            $productosSeleccionados = old('pro_productos_kit', $producto->pro_productos_kit ?? []);
            if (!is_array($productosSeleccionados)) {
                $productosSeleccionados = [];
            }
        @endphp
        


        <div class="form-grupo">
            <label id="label-imagen" for="pro_imagen">Imagen (opcional)</label>
            <input id="pro_imagen" type="file" name="pro_imagen" aria-describedby="imagen-actual">
            @error('pro_imagen')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror

            @if($producto->pro_imagen)
                <p id="imagen-actual">Imagen actual:</p>
                <img src="{{ asset('storage/'.$producto->pro_imagen) }}" width="80" alt="Imagen del {{ $producto->esKit() ? 'kit' : 'producto' }} {{ $producto->pro_nombre }}" aria-describedby="desc-img-edit">
                <span id="desc-img-edit" class="sr-only">Imagen del {{ $producto->esKit() ? 'kit' : 'producto' }} {{ $producto->pro_nombre }}. Si la imagen no es descriptiva, consulte el nombre o descripción.</span>
            @endif
        </div>

        <div class="form-acciones">
            <button type="submit" class="btn-guardar" aria-label="Actualizar {{ $producto->esKit() ? 'kit' : 'producto' }}">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn-cancelar" aria-label="Volver al listado de productos">Cancelar</a>
        </div>
    </form>
<script>
// Mostrar/ocultar sección de productos del kit según la categoría seleccionada
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('pro_categoria');
    const seccionKit = document.getElementById('seccion-productos-kit');
    
    function toggleSeccionKit() {
        const esKit = categoriaSelect.value === 'kit';
        seccionKit.style.display = esKit ? 'block' : 'none';
        
        // Anunciar cambio para lectores de pantalla
        if (esKit) {
            seccionKit.setAttribute('aria-hidden', 'false');
        } else {
            seccionKit.setAttribute('aria-hidden', 'true');
        }
    }
    
    categoriaSelect.addEventListener('change', toggleSeccionKit);
});

</script>
</div>
@endsection
