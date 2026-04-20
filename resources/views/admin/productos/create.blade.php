@extends('admin.layout')
@vite(['resources/css/Admin/productos/create.css'])
@section('content')
<div class="productos-container" id="modulo-productos-create">
    <div class="productos-header">
        <h2 tabindex="0">Crear Producto o Kit</h2>
    </div>
    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data" aria-label="Formulario para crear producto o kit" class="producto-form">
        @csrf



        <div class="form-grupo">
            <label for="pro_categoria">Categoría</label>
            <select name="pro_categoria" id="pro_categoria" required aria-label="Categoría del producto. Selecciona kit para crear un kit con productos incluidos">
                <option value="">Selecciona una categoría</option>
                <option value="cabello" {{ old('pro_categoria') == 'cabello' ? 'selected' : '' }}>Cabello</option>
                <option value="barba" {{ old('pro_categoria') == 'barba' ? 'selected' : '' }}>Barba</option>
                <option value="styling" {{ old('pro_categoria') == 'styling' ? 'selected' : '' }}>Styling</option>
                <option value="accesorios" {{ old('pro_categoria') == 'accesorios' ? 'selected' : '' }}>Accesorios</option>
                <option value="kit" {{ old('pro_categoria') == 'kit' ? 'selected' : '' }}>Kit</option>
            </select>
            @error('pro_categoria')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <!-- Sección de productos incluidos en el kit (visible solo cuando categoría = kit) -->
        <div class="form-grupo" id="seccion-productos-kit" style="display: none;" aria-live="polite">
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
                                {{ in_array($prod->pro_id, old('pro_productos_kit', [])) ? 'checked' : '' }}
                                aria-describedby="prod_desc_{{ $prod->pro_id }}"
                            >
                            <label for="prod_kit_{{ $prod->pro_id }}">
                                {{ $prod->pro_nombre }} - {{ (float) $prod->pro_precio }} pesos colombianos
                            </label>
                            <span id="prod_desc_{{ $prod->pro_id }}" class="sr-only">
                                Producto: {{ $prod->pro_nombre }}, Categoría: {{ ucfirst($prod->pro_categoria) }}, Precio: {{ (float) $prod->pro_precio }} pesos colombianos
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
            <label for="pro_nombre">Nombre</label>
            <input type="text" name="pro_nombre" id="pro_nombre" required aria-label="Nombre del producto o kit" value="{{ old('pro_nombre') }}">
            @error('pro_nombre')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grupo">
            <label for="pro_descripcion">Descripción</label>
            <textarea name="pro_descripcion" id="pro_descripcion" tabindex="0" aria-label="Descripción del producto o kit">{{ old('pro_descripcion') }}</textarea>
            @error('pro_descripcion')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-grupo">
            <label for="pro_precio">Precio</label>
            <input type="number" step="0.01" name="pro_precio" id="pro_precio" required aria-label="Precio del producto o kit" value="{{ old('pro_precio') }}">
            @error('pro_precio')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grupo">
            <label for="pro_descuento">Descuento (%)</label>
            <input type="number" name="pro_descuento" id="pro_descuento" min="0" max="100" step="0.01" value="{{ old('pro_descuento', 0) }}" placeholder="Ej: 10 para 10%" aria-label="Descuento en porcentaje">
            @error('pro_descuento')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>


        <div class="form-grupo">

        <div class="form-grupo">
            <label for="pro_stock">Stock</label>
            <input type="number" name="pro_stock" id="pro_stock" required aria-label="Stock disponible" value="{{ old('pro_stock') }}">
            @error('pro_stock')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grupo">
            <label for="pro_imagen">Imagen (opcional)</label>
            <input type="file" name="pro_imagen" id="pro_imagen" aria-label="Imagen del producto o kit">
            @error('pro_imagen')
                <span role="alert" style="color:red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-acciones">
            <button type="submit" class="btn-guardar" aria-label="Guardar producto o kit">Guardar</button>
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
            // Mover foco al fieldset para usuarios de lectores de pantalla
            setTimeout(() => {
                const firstCheckbox = seccionKit.querySelector('input[type="checkbox"]');
                if (firstCheckbox) {
                    firstCheckbox.focus();
                }
            }, 100);
        } else {
            seccionKit.setAttribute('aria-hidden', 'true');
        }
    }
    
    categoriaSelect.addEventListener('change', toggleSeccionKit);
    toggleSeccionKit(); // Inicializar estado
});

</script>
</div>
@endsection
