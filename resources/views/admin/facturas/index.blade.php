@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/factura/facturas.css'])
<div class="facturas-container" id="modulo-facturas">
    @if(session('success'))
        <div class="alert alert-success" role="alert" tabindex="0">
            {{ session('success') }}
        </div>
    @endif
   @if(session('error'))
    <div class="alert alert-danger" role="alert" tabindex="0">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" role="alert" tabindex="0">
        {{ $errors->first() }}
    </div>
@endif
    <h2>Listado de Facturas</h2>
    <form method="GET" action="" class="facturas-filtros" aria-label="Filtrar facturas">
        <div class="filtro-grupo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}" class="form-control" placeholder="Filtrar por fecha">
        </div>
        <div class="filtro-grupo">
            <label for="buscar">Buscar</label>
            <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por cliente, sede o ID">
        </div>
        <button type="submit" class="btn btn-primary" aria-label="Buscar facturas" style="display:none;">Buscar</button>
        <a href="{{ route('factura.index') }}" class="btn btn-secondary" aria-label="Limpiar filtros">Limpiar</a>
    </form>
    <div class="facturas-table-wrapper">
        <!-- Lista vertical accesible para lectores de pantalla -->
        <ul class="sr-only" aria-label="Listado de facturas detallado">
            @foreach($facturas as $factura)
            @php
                $subtotal = $factura->turno->servicio->serv_precio ?? 0; // suma de precios originales de servicios
                $totalDescuento = ($factura->turno->servicio->serv_precio ?? 0) * (($factura->turno->servicio->serv_descuento ?? 0)/100);
                $porcentajeTotal = $factura->turno->servicio->serv_descuento ?? 0;
                $serviciosConDescuento = ($factura->turno->servicio->serv_descuento ?? 0) > 0 ? 1 : 0;

                $productosOriginales = 0; // suma de precios originales de productos (antes de descuento por ítem)

                foreach($factura->detalles as $detalle) {
                    if($detalle->serv_id && $detalle->serv_id != $factura->turno->serv_id) {
                        $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                        $descuento = $detalle->serv_descuento ?? ($detalle->servicios->serv_descuento ?? 0);
                        $subtotal += $precioOriginal;
                        $totalDescuento += ($precioOriginal - $detalle->serv_precio);
                        if($descuento > 0) {
                            $porcentajeTotal += $descuento;
                            $serviciosConDescuento++;
                        }
                    }
                    // Productos: calcular precio original por unidad (precio_original) si existe, sino usar precio unitario guardado
                    if($detalle->pro_id) {
                        $precioOrigProd = (float)($detalle->precio_original ?? $detalle->facdet_precio_unitario);
                        $cantidadProd = (int)($detalle->facdet_cantidad ?? 1);
                        $productosOriginales += $precioOrigProd * $cantidadProd;
                    }
                }
                $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
                $totalProductos = $factura->detalles->whereNotNull('pro_id')->sum('facdet_subtotal');
                $totalFinal = ($subtotal - $totalDescuento) + $totalProductos;
                $totalOriginal = $subtotal + $productosOriginales; // total sin descuentos
            @endphp
            <li>
                <strong>ID:</strong> {{ $factura->fac_id }}<br>
                <strong>Fecha:</strong>
                    <span class="sr-only">{{ \Carbon\Carbon::parse($factura->fac_fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}</span><br>
                <strong>Sede:</strong> {{ $factura->sede->sede_nombre ?? '' }}<br>
                <strong>Turno:</strong> {{ $factura->turno->tur_id ?? '' }}<br>
                <strong>Total (sin descuento):</strong> ${{ number_format($totalOriginal, 2) }} pesos colombianos<br>
                <strong>Abono:</strong> {{ $factura->fac_abono }} pesos colombianos<br>
                <strong>Descuento promedio:</strong> {{ number_format($porcentajePromedio,2) }}%<br>
                <strong>Total con descuento:</strong>
                <span aria-hidden="true">{{ $totalFinal }} pesos colombianos</span>
                <span class="sr-only">{{ number_format($totalFinal, 0, ',', '.') }} pesos colombianos</span><br>
                <strong>Acciones:</strong>
                <a href="{{ route('facturas.show', $factura->fac_id) }}" class="btn btn-info btn-sm" aria-label="Ver factura {{ $factura->fac_id }}">Ver factura</a> /
                <a href="{{ route('facturas.pdf', $factura->fac_id) }}" class="btn btn-secondary btn-sm" target="_blank" aria-label="Descargar PDF de la factura {{ $factura->fac_id }}">Descargar PDF</a> /
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-factura" aria-label="Eliminar factura {{ $factura->fac_id }}" data-id="{{ $factura->fac_id }}">Eliminar factura</button>
            </li>
            @endforeach
        </ul>

        <!-- Tabla visual solo para usuarios videntes -->
        <table class="facturas-table" role="table" aria-label="Listado de facturas">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Total</th>
                    <th scope="col">Abono</th>
                    <th scope="col">Descuento (%)</th>
                    <th scope="col">Total con descuento</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturas as $factura)
                @php
                    $subtotal = $factura->turno->servicio->serv_precio ?? 0; // suma de precios originales de servicios
                    $totalDescuento = ($factura->turno->servicio->serv_precio ?? 0) * (($factura->turno->servicio->serv_descuento ?? 0)/100);
                    $porcentajeTotal = $factura->turno->servicio->serv_descuento ?? 0;
                    $serviciosConDescuento = ($factura->turno->servicio->serv_descuento ?? 0) > 0 ? 1 : 0;

                    $productosOriginales = 0;

                    foreach($factura->detalles as $detalle) {
                        if($detalle->serv_id && $detalle->serv_id != $factura->turno->serv_id) {
                            $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                            $descuento = $detalle->servicios->serv_descuento ?? 0;
                            $subtotal += $precioOriginal;
                            $totalDescuento += ($precioOriginal - $detalle->serv_precio);
                            if($descuento > 0) {
                                $porcentajeTotal += $descuento;
                                $serviciosConDescuento++;
                            }
                        }
                        if($detalle->pro_id) {
                            $precioOrigProd = (float)($detalle->precio_original ?? $detalle->facdet_precio_unitario);
                            $cantidadProd = (int)($detalle->facdet_cantidad ?? 1);
                            $productosOriginales += $precioOrigProd * $cantidadProd;
                        }
                    }
                    $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
                    $totalProductos = $factura->detalles->whereNotNull('pro_id')->sum('facdet_subtotal');
                    $totalFinal = ($subtotal - $totalDescuento) + $totalProductos;
                    $totalOriginal = $subtotal + $productosOriginales;
                @endphp
                <tr>
                    <td data-label="ID">{{ $factura->fac_id }}</td>
                    <td data-label="Fecha">
                        {{ \Carbon\Carbon::parse($factura->fac_fecha)->format('d/m/Y H:i') }}
                        <span class="sr-only">{{ \Carbon\Carbon::parse($factura->fac_fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}</span>
                    </td>
                    <td data-label="Sede">{{ $factura->sede->sede_nombre ?? '' }}</td>
                    <td data-label="Turno">{{ $factura->turno->tur_id ?? '' }}</td>
                    <td data-label="Total">${{ number_format($totalOriginal, 2) }}</td>
                    <td data-label="Abono">${{ number_format($factura->fac_abono, 2) }}</td>
                    <td data-label="Descuento (%)">{{ number_format($porcentajePromedio, 2) }}%</td>
                    <td data-label="Total con descuento">
                        ${{ number_format($totalFinal, 2) }}
                        @if($totalProductos > 0)
                            <small style="display:block; color:#666; font-size:0.8em;">
                                Servicios: ${{ number_format($subtotal - $totalDescuento, 2) }} +
                                Productos: ${{ number_format($totalProductos, 2) }}
                            </small>
                        @endif
                    </td>
                    <td class="acciones" data-label="Acciones">
                        <a href="{{ route('facturas.show', $factura->fac_id) }}" class="btn btn-info btn-sm" aria-label="Ver factura {{ $factura->fac_id }}">Ver</a>
                        <a href="{{ route('facturas.pdf', $factura->fac_id) }}" class="btn btn-secondary btn-sm" target="_blank" aria-label="Descargar PDF de la factura {{ $factura->fac_id }}">Descargar PDF</a>
                        <button type="button" class="btn btn-danger btn-sm" aria-label="Eliminar factura {{ $factura->fac_id }}" onclick="confirmarEliminacionFactura({{ $factura->fac_id }})">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para contraseña de administrador -->
<div id="modal-admin-pass" class="modal-admin" style="display:none;" role="alertdialog" aria-modal="true" aria-labelledby="modal-admin-titulo" aria-describedby="modal-admin-msg" tabindex="-1">
    <div class="modal-admin-content" tabindex="0">
        <button type="button" class="modal-admin-close" aria-label="Cerrar este diálogo de confirmación" tabindex="0">&times;</button>
        <h3 id="modal-admin-titulo" tabindex="0">Eliminar factura</h3>
        <p id="modal-admin-msg" aria-live="assertive">Para eliminar la factura, introduce tu contraseña de administrador:</p>
        <div id="modal-error-msg" class="modal-error-msg" style="display:none;" role="alert" aria-live="assertive"></div>
        <input type="password" id="modal-admin-input" class="modal-admin-input" placeholder="Contraseña" autocomplete="current-password" tabindex="0" aria-label="Contraseña de administrador para eliminar factura">
        <div class="modal-admin-actions">
            <button type="button" class="modal-admin-accept" aria-label="Aceptar y eliminar factura">Aceptar</button>
            <button type="button" class="modal-admin-cancel" aria-label="Cancelar y cerrar el diálogo">Cancelar</button>
        </div>
    </div>
</div>

<!-- Toast de confirmación de eliminación -->
<div id="toast-success" class="toast-success" style="display:none;" role="alert" aria-live="polite">
    <div class="toast-content">
        <div class="toast-icon">✓</div>
        <div class="toast-message">
            <strong>¡Factura eliminada!</strong>
            <p>La factura se eliminó correctamente.</p>
        </div>
    </div>
</div>

<script>
function showAdminPasswordModal(msg, callback) {
    const modal = document.getElementById('modal-admin-pass');
    const input = document.getElementById('modal-admin-input');
    const errorMsg = document.getElementById('modal-error-msg');
    const closeBtn = modal.querySelector('.modal-admin-close');
    const acceptBtn = modal.querySelector('.modal-admin-accept');
    const cancelBtn = modal.querySelector('.modal-admin-cancel');
    let lastFocusedElement = document.activeElement;
    
    document.getElementById('modal-admin-msg').textContent = msg;
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
    modal.focus();
    
    setTimeout(() => { document.getElementById('modal-admin-titulo').focus(); }, 100);
    
    input.value = '';
    errorMsg.style.display = 'none';
    errorMsg.classList.remove('shake');
    
    function closeModal() {
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        errorMsg.style.display = 'none';
        acceptBtn.onclick = cancelBtn.onclick = closeBtn.onclick = null;
        input.onkeydown = null;
        if (lastFocusedElement) lastFocusedElement.focus();
    }
    
    function showError(message) {
        errorMsg.textContent = message;
        errorMsg.style.display = 'flex';
        errorMsg.classList.add('shake');
        setTimeout(() => errorMsg.classList.remove('shake'), 500);
        input.focus();
        input.select();
    }
    
    acceptBtn.onclick = function() {
        const password = input.value;
        if (!password) { showError('Por favor, ingresa tu contraseña'); return; }
        closeModal();
        callback(input.value);
    };
    
    cancelBtn.onclick = closeBtn.onclick = function() { closeModal(); callback(null); };
    
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeModal(); }
        if (e.key === 'Tab') {
            const focusables = Array.from(modal.querySelectorAll('button, input, [tabindex]:not([tabindex="-1"])'));
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.shiftKey) { if (document.activeElement === first) { e.preventDefault(); last.focus(); } }
            else { if (document.activeElement === last) { e.preventDefault(); first.focus(); } }
        }
    });
    
    input.onkeydown = function(e) { if (e.key === 'Enter') acceptBtn.click(); };
    modal.showError = showError;
}

function confirmarEliminacionFactura(id) {
    showAdminPasswordModal('Para eliminar la factura #' + id + ' introduce tu contraseña de administrador:', function(pass) {
        if (pass) {
            const modal = document.getElementById('modal-admin-pass');
            const acceptBtn = modal.querySelector('.modal-admin-accept');
            const originalText = acceptBtn.textContent;
            acceptBtn.textContent = 'Verificando...';
            acceptBtn.disabled = true;
            
            fetch('/admin/facturas/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ password: pass })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => { throw new Error(data.message || 'Contraseña incorrecta.'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    acceptBtn.textContent = '✓ Eliminado';
                    acceptBtn.style.background = '#28a745';
                    showSuccessToast(data.message || 'Factura eliminada correctamente');
                    setTimeout(() => location.reload(), 1500);
                }
            })
            .catch(error => {
                acceptBtn.textContent = originalText;
                acceptBtn.disabled = false;
                acceptBtn.style.background = '';
                setTimeout(() => {
                    confirmarEliminacionFactura(id);
                    setTimeout(() => {
                        const m = document.getElementById('modal-admin-pass');
                        if (m.showError) m.showError(error.message || 'Contraseña incorrecta. Intenta de nuevo.');
                    }, 200);
                }, 100);
            });
        }
    });
}

function showSuccessToast(message) {
    const toast = document.getElementById('toast-success');
    const messageP = toast.querySelector('.toast-message p');
    if (message) messageP.textContent = message;
    toast.style.display = 'block';
    toast.classList.remove('hiding');
    setTimeout(() => {
        toast.classList.add('hiding');
        setTimeout(() => { toast.style.display = 'none'; }, 400);
    }, 1500);
}

// Accesibilidad: botones de eliminar en la lista sr-only
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-eliminar-factura').forEach(btn => {
        btn.addEventListener('click', function() {
            confirmarEliminacionFactura(btn.getAttribute('data-id'));
        });
    });

    // Búsqueda automática
    const form = document.querySelector('.facturas-filtros');
    const buscarInput = document.getElementById('buscar');
    const fechaInput = document.getElementById('fecha');
    let debounceTimer;

    buscarInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() { form.submit(); }, 400);
    });

    fechaInput.addEventListener('change', function() { form.submit(); });
});
</script>
</div>
@endsection