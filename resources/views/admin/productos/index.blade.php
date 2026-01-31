@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/productos/producto.css'])
<div class="productos-container" id="modulo-productos">

    <div class="productos-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;">
        <h2 tabindex="0" style="margin:0;">Productos</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nuevo producto">
            <span aria-hidden="true">&#43;</span> Crear producto
        </a>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif

    <!-- Lista vertical accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista de productos detallada">
        @foreach($productos as $p)
        <li>
            <strong>Nombre:</strong> {{ $p->pro_nombre }}<br>
            <strong>Precio:</strong> ${{ $p->pro_precio }}<br>
            <strong>Descuento:</strong> {{ $p->pro_descuento ?? 0 }}%<br>
            <strong>Precio final:</strong> ${{ number_format($p->pro_precio * (1 - ($p->pro_descuento ?? 0)/100), 2) }}<br>
            <strong>Stock:</strong> {{ $p->pro_stock }}<br>
            <strong>Imagen:</strong> @if($p->pro_imagen) Imagen disponible @else Sin imagen @endif<br>
            <strong>Estado:</strong> {{ $p->pro_estado }}<br>
            <strong>Acciones:</strong> Editar producto / Eliminar producto
        </li>
        @endforeach
    </ul>

    <!-- Tabla visual solo para usuarios videntes -->
    <table class="productos-tabla" role="table" aria-label="Lista de productos" aria-hidden="true">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Descuento (%)</th>
                <th scope="col">Precio final</th>
                <th scope="col">Stock</th>
                <th scope="col">Imagen</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($productos as $p)
        <tr>
            <td aria-label="Nombre">{{ $p->pro_nombre }}</td>
            <td aria-label="Precio">${{ $p->pro_precio }}</td>
            <td aria-label="Descuento">{{ $p->pro_descuento ?? 0 }}%</td>
            <td aria-label="Precio final">
                ${{ number_format($p->pro_precio * (1 - ($p->pro_descuento ?? 0)/100), 2) }}
            </td>
            <td aria-label="Stock">{{ $p->pro_stock }}</td>
            <td aria-label="Imagen">
                @if($p->pro_imagen)
                    <img src="{{ asset('storage/'.$p->pro_imagen) }}" width="80" height="80" alt="Imagen del producto {{ $p->pro_nombre }}" aria-describedby="desc-img-{{ $p->pro_id }}" style="object-fit:cover; border-radius:8px;">
                    <span id="desc-img-{{ $p->pro_id }}" class="sr-only">Imagen del producto {{ $p->pro_nombre }}. Si la imagen no es descriptiva, por favor consulte el nombre o descripción del producto.</span>
                @else
                    <span aria-label="Sin imagen">Sin imagen</span>
                @endif
            </td>
            <td aria-label="Estado">{{ $p->pro_estado }}</td>
            <td aria-label="Acciones">
                <div class="acciones">
                    <a href="{{ route('productos.edit', $p->pro_id) }}" class="btn-accion btn-editar" tabindex="0" aria-label="Editar producto {{ $p->pro_nombre }}">Editar</a>
                    <form action="{{ route('productos.destroy', $p->pro_id) }}" method="POST" style="display:inline;" aria-label="Eliminar producto {{ $p->pro_nombre }}">
                        @csrf @method('DELETE')
                        <button type="button" class="btn-accion btn-eliminar-producto" tabindex="0" aria-label="Eliminar producto {{ $p->pro_nombre }}">Eliminar</button>
                    </tbody>
                        </table>

                    <!-- Modal de confirmación de eliminación con estilo personalizado -->
                    <div id="modal-eliminar-producto" class="modal-eliminar-producto" role="dialog" aria-modal="true" aria-labelledby="modal-eliminar-producto-titulo" aria-hidden="true" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;">
                        <div style="background:#fff;padding:2.5rem 2rem 2rem 2rem;border-radius:24px;max-width:90vw;width:400px;box-shadow:0 2px 16px #0002;outline:0;position:relative;display:flex;flex-direction:column;align-items:center;">
                            <button id="cerrar-modal-eliminar-producto" type="button" aria-label="Cerrar" style="position:absolute;top:18px;right:18px;background:transparent;border:none;font-size:1.7rem;color:#22304a;cursor:pointer;line-height:1;">&times;</button>
                            <h2 id="modal-eliminar-producto-titulo" style="margin:0 0 0.5rem 0;font-size:1.6rem;font-weight:700;color:#22304a;text-align:center;">¿Eliminar producto?</h2>
                            <p style="margin:0 0 2rem 0;font-size:1.1rem;color:#22304a;text-align:center;">Esta acción no se puede deshacer.</p>
                            <div style="display:flex;gap:1.5rem;justify-content:center;width:100%;">
                                <button id="cancelar-eliminar-producto" type="button" style="background:#fff;color:#22304a;border:2px solid #22304a;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Cancelar</button>
                                <button id="confirmar-eliminar-producto" type="button" style="background:#22304a;color:#fff;border:none;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Eliminar</button>
                            </div>
                        </div>
                    </div>

                    <script>
                    // Modal de confirmación de eliminación para productos
                    document.addEventListener('DOMContentLoaded', function() {
                        let formAEliminar = null;
                        const modal = document.getElementById('modal-eliminar-producto');
                        const btnCancelar = document.getElementById('cancelar-eliminar-producto');
                        const btnConfirmar = document.getElementById('confirmar-eliminar-producto');
                        const btnCerrar = document.getElementById('cerrar-modal-eliminar-producto');
                        // Mostrar modal al hacer click en Eliminar
                        document.querySelectorAll('.btn-eliminar-producto').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                formAEliminar = btn.closest('form');
                                modal.style.display = 'flex';
                                modal.setAttribute('aria-hidden', 'false');
                                btnConfirmar.focus();
                            });
                        });
                        // Cancelar y cerrar (botón o X)
                        function cerrarModal() {
                            modal.style.display = 'none';
                            modal.setAttribute('aria-hidden', 'true');
                            formAEliminar = null;
                        }
                        btnCancelar.addEventListener('click', cerrarModal);
                        btnCerrar.addEventListener('click', cerrarModal);
                        // Confirmar
                        btnConfirmar.addEventListener('click', function() {
                            if(formAEliminar) formAEliminar.submit();
                        });
                        // Cerrar modal con Escape
                        modal.addEventListener('keydown', function(e) {
                            if(e.key === 'Escape') {
                                cerrarModal();
                            }
                        });
                    });
                    </script>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
<script>
// Navegación accesible con flechas y Tab para todo el módulo Productos
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-productos');
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
