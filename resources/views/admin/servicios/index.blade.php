@extends('admin.layout')


@section('content')
@vite(['resources/css/Admin/servicio/servicio.css'])
<div class="servicios-container" id="modulo-servicios">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;">
        <h2 tabindex="0" style="margin:0;">Servicios</h2>
        <a href="{{ route('servicios.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nuevo servicio">
            <span aria-hidden="true">&#43;</span> Crear servicio
        </a>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif

    <!-- Lista vertical accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista de servicios detallada">
        @foreach($servicios as $s)
        <li>
            <strong>Nombre:</strong> {{ $s->serv_nombre }}<br>
            <strong>Precio:</strong> ${{ $s->serv_precio }}<br>
            <strong>Descuento:</strong> {{ $s->serv_descuento ?? 0 }}%<br>
            <strong>Precio final:</strong> ${{ number_format($s->serv_precio * (1 - ($s->serv_descuento ?? 0)/100), 2) }}<br>
            <strong>Duración:</strong> {{ $s->serv_duracion }} min<br>
            <strong>Estado:</strong> {{ $s->serv_estado }}<br>
            <strong>Acciones:</strong> Editar servicio / Eliminar servicio
        </li>
        @endforeach
    </ul>

    <!-- Tabla visual solo para usuarios videntes -->
    <table border="1" width="100%" role="table" aria-label="Lista de servicios" aria-hidden="true">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Descuento (%)</th>
                <th scope="col">Precio final</th>
                <th scope="col">Duración</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($servicios as $s)
        <tr>
            <td aria-label="Nombre">{{ $s->serv_nombre }}</td>
            <td aria-label="Precio">${{ $s->serv_precio }}</td>
            <td aria-label="Descuento">{{ $s->serv_descuento ?? 0 }}%</td>
            <td aria-label="Precio final">
                ${{ number_format($s->serv_precio * (1 - ($s->serv_descuento ?? 0)/100), 2) }}
            </td>
            <td aria-label="Duración">{{ $s->serv_duracion }} min</td>
            <td aria-label="Estado">{{ $s->serv_estado }}</td>
            <td aria-label="Acciones">
                <a href="{{ route('servicios.edit', $s->serv_id) }}" class="btn-editar" tabindex="0" aria-label="Editar servicio {{ $s->serv_nombre }}">Editar</a>
                <form action="{{ route('servicios.destroy', $s->serv_id) }}" method="POST" aria-label="Eliminar servicio {{ $s->serv_nombre }}" style="display:inline; margin:0; padding:0; border:none; background:none; box-shadow:none;">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-eliminar btn-eliminar-servicio" tabindex="0" aria-label="Eliminar servicio {{ $s->serv_nombre }}" style="margin:0;">Eliminar</button>
                </tbody>
                    </table>

                <!-- Modal de confirmación de eliminación con estilo personalizado -->
                <div id="modal-eliminar-servicio" class="modal-eliminar-servicio" role="dialog" aria-modal="true" aria-labelledby="modal-eliminar-servicio-titulo" aria-hidden="true" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;">
                    <div style="background:#fff;padding:2.5rem 2rem 2rem 2rem;border-radius:24px;max-width:90vw;width:400px;box-shadow:0 2px 16px #0002;outline:0;position:relative;display:flex;flex-direction:column;align-items:center;">
                        <button id="cerrar-modal-eliminar-servicio" type="button" aria-label="Cerrar" style="position:absolute;top:18px;right:18px;background:transparent;border:none;font-size:1.7rem;color:#22304a;cursor:pointer;line-height:1;">&times;</button>
                        <h2 id="modal-eliminar-servicio-titulo" style="margin:0 0 0.5rem 0;font-size:1.6rem;font-weight:700;color:#22304a;text-align:center;">¿Eliminar servicio?</h2>
                        <p style="margin:0 0 2rem 0;font-size:1.1rem;color:#22304a;text-align:center;">Esta acción no se puede deshacer.</p>
                        <div style="display:flex;gap:1.5rem;justify-content:center;width:100%;">
                            <button id="cancelar-eliminar-servicio" type="button" style="background:#fff;color:#22304a;border:2px solid #22304a;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Cancelar</button>
                            <button id="confirmar-eliminar-servicio" type="button" style="background:#22304a;color:#fff;border:none;border-radius:10px;padding:0.7rem 2.2rem;font-size:1.1rem;font-weight:600;cursor:pointer;">Eliminar</button>
                        </div>
                    </div>
                </div>

                <script>
                // Modal de confirmación de eliminación para servicios
                document.addEventListener('DOMContentLoaded', function() {
                    let formAEliminar = null;
                    const modal = document.getElementById('modal-eliminar-servicio');
                    const btnCancelar = document.getElementById('cancelar-eliminar-servicio');
                    const btnConfirmar = document.getElementById('confirmar-eliminar-servicio');
                    const btnCerrar = document.getElementById('cerrar-modal-eliminar-servicio');
                    // Mostrar modal al hacer click en Eliminar
                    document.querySelectorAll('.btn-eliminar-servicio').forEach(btn => {
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
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
<script>
// Navegación accesible con flechas y Tab para todo el módulo Servicios
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-servicios');
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
