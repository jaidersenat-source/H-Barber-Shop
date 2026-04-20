@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/productos/producto.css'])
<div class="productos-container" id="modulo-productos">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;flex-wrap:wrap;">
        <h2 tabindex="0" style="margin:0;">Productos y Kits</h2>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
            <a href="{{ route('productos.index', ['tipo' => 'todos']) }}" class="btn {{ ($tipo ?? 'todos') === 'todos' ? 'btn-primary' : 'btn-outline-primary' }}" tabindex="0" aria-label="Ver todos los productos y kits">Todos</a>
            <a href="{{ route('productos.index', ['tipo' => 'producto']) }}" class="btn {{ ($tipo ?? '') === 'producto' ? 'btn-primary' : 'btn-outline-primary' }}" tabindex="0" aria-label="Ver solo productos">Productos</a>
            <a href="{{ route('productos.index', ['tipo' => 'kit']) }}" class="btn {{ ($tipo ?? '') === 'kit' ? 'btn-success' : 'btn-outline-success' }}" tabindex="0" aria-label="Ver solo kits">Kits</a>
        </div>
        <div style="display:flex;gap:1rem;">
            <a href="{{ route('productos.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nuevo producto o kit">
                <span aria-hidden="true">&#43;</span> Crear producto/kit
            </a>
        </div>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif

    <!-- Lista vertical accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista detallada de productos y kits">
        @foreach($productos as $p)
        <li>
             @if($p->esKit() && !empty($p->pro_productos_kit))
                <strong>Productos incluidos:</strong> {{ count($p->pro_productos_kit) }} productos<br>
            @endif
            <strong>Tipo:</strong> {{ $p->esKit() ? 'Kit' : 'Producto' }}<br>
            <strong>Nombre:</strong> {{ $p->pro_nombre }}<br>
            <strong>Categoría:</strong> {{ ucfirst($p->pro_categoria) }}<br>
            <strong>Precio:</strong> {{ $p->pro_precio }} pesos colombianos<br>
            <strong>Stock:</strong> {{ $p->pro_stock }}<br>
            <strong>Estado:</strong> {{ $p->pro_estado }}<br>
           @if($p->pro_imagen)
            <strong>Imagen:</strong> Imagen de {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}<br>
             @else
            <strong>Imagen:</strong> Sin imagen<br>
           @endif
            @if($p->esKit() && !empty($p->pro_productos_kit))
                <strong>Productos incluidos:</strong> {{ count($p->pro_productos_kit) }} productos<br>
            @endif
            <strong>Acciones:</strong>
            <a href="{{ route('productos.edit', $p->pro_id) }}" class="btn-accion btn-editar" tabindex="0" aria-label="Editar {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}">Editar</a>
            <form action="{{ route('productos.destroy', $p->pro_id) }}" method="POST" style="display:inline;" aria-label="Eliminar {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}">
                @csrf @method('DELETE')
                <button type="button" class="btn-accion btn-eliminar btn-eliminar-producto" tabindex="0" aria-label="Eliminar {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}">Eliminar</button>
            </form>
        </li>
        @endforeach
    </ul>

    <!-- Tabla de productos y kits -->
    <table class="productos-tabla" role="table" aria-label="Lista de productos y kits">
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Categoría</th>
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
                <th scope="col">Estado</th>
                <th scope="col">Imagen</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($productos as $p)
        <tr>
            <td aria-label="Tipo">
                @if($p->esKit())
                    <span class="badge badge-kit" style="background:#28a745;color:#fff;padding:2px 8px;border-radius:4px;">Kit</span>
                @else
                    <span class="badge badge-producto" style="background:#007bff;color:#fff;padding:2px 8px;border-radius:4px;">Producto</span>
                @endif
            </td>
            <td aria-label="Nombre">
                {{ $p->pro_nombre }}
                @if($p->esKit() && !empty($p->pro_productos_kit))
                    <br>
                    <small style="color:#666;" aria-label="Este kit incluye {{ count($p->pro_productos_kit) }} productos">
                        ({{ count($p->pro_productos_kit) }} productos incluidos)
                    </small>
                @endif
            </td>
            <td aria-label="Categoría">{{ ucfirst($p->pro_categoria) }}</td>
            <td aria-label="Precio">${{ number_format($p->pro_precio, 2) }}</td>
            <td aria-label="Stock">{{ $p->pro_stock }}</td>
            <td aria-label="Estado">{{ $p->pro_estado }}</td>
            <td aria-label="Imagen">
                @if($p->pro_imagen)
                    <img src="{{ asset('storage/'.$p->pro_imagen) }}" width="80" height="80" alt="Imagen de {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}" aria-describedby="desc-img-{{ $p->pro_id }}" style="object-fit:cover; border-radius:8px;">
                    <span id="desc-img-{{ $p->pro_id }}" class="sr-only">Imagen de {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}.</span>
                @else
                    <span aria-label="Sin imagen">Sin imagen</span>
                @endif
            </td>
            <td aria-label="Acciones" class="acciones">
                <a href="{{ route('productos.edit', $p->pro_id) }}" class="btn-accion btn-editar" tabindex="0" aria-label="Editar {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}">Editar</a>
                <form action="{{ route('productos.destroy', $p->pro_id) }}" method="POST" aria-label="Eliminar {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-accion btn-eliminar btn-eliminar-producto" tabindex="0" aria-label="Eliminar {{ $p->esKit() ? 'kit' : 'producto' }} {{ $p->pro_nombre }}">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;">No hay productos ni kits registrados.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Modal de confirmación de eliminación -->
    <div id="modal-eliminar-producto" class="modal-eliminar-servicio" role="alertdialog" aria-modal="true" aria-labelledby="modal-eliminar-producto-titulo" aria-describedby="modal-eliminar-producto-desc" aria-hidden="true" tabindex="-1">
        <div style="outline:none;" tabindex="0">
            <button id="cerrar-modal-eliminar-producto" type="button" aria-label="Cerrar este diálogo de confirmación">&times;</button>
            <h2 id="modal-eliminar-producto-titulo" tabindex="0">¿Eliminar este elemento?</h2>
            <p id="modal-eliminar-producto-desc" aria-live="assertive">Esta acción no se puede deshacer. Confirma si deseas eliminar el producto o kit seleccionado.</p>
            <div>
                <button id="cancelar-eliminar-producto" type="button" aria-label="Cancelar y cerrar el diálogo">Cancelar</button>
                <button id="confirmar-eliminar-producto" type="button" aria-label="Confirmar eliminación de este elemento">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
    // Modal de confirmación de eliminación accesible
    document.addEventListener('DOMContentLoaded', function() {
        let formAEliminar = null;
        const modal = document.getElementById('modal-eliminar-producto');
        const btnCancelar = document.getElementById('cancelar-eliminar-producto');
        const btnConfirmar = document.getElementById('confirmar-eliminar-producto');
        const btnCerrar = document.getElementById('cerrar-modal-eliminar-producto');
        const modalContent = modal.querySelector('div');
        let lastFocusedElement = null;

        // Enfocar el modal y anunciarlo
        function abrirModal() {
            lastFocusedElement = document.activeElement;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            modal.focus();
            setTimeout(() => {
                // Foco en el título para que JAWS lo lea
                document.getElementById('modal-eliminar-producto-titulo').focus();
            }, 100);
        }

        // Mostrar modal al hacer click en Eliminar
        document.querySelectorAll('.btn-eliminar-producto').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                formAEliminar = btn.closest('form');
                abrirModal();
            });
        });

        // Cerrar y devolver foco
        function cerrarModal() {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            formAEliminar = null;
            if (lastFocusedElement) lastFocusedElement.focus();
        }
        btnCancelar.addEventListener('click', cerrarModal);
        btnCerrar.addEventListener('click', cerrarModal);

        // Confirmar
        btnConfirmar.addEventListener('click', function() {
            if(formAEliminar) formAEliminar.submit();
        });

        // Cerrar modal con Escape y tabulación cíclica
        modal.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') {
                cerrarModal();
            }
            // Tabulación cíclica dentro del modal
            if(e.key === 'Tab') {
                const focusables = modal.querySelectorAll('button, [tabindex]:not([tabindex="-1"])');
                const focusable = Array.prototype.slice.call(focusables);
                const first = focusable[0];
                const last = focusable[focusable.length - 1];
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
            }
        });
    });
    </script>
</div>
@endsection
