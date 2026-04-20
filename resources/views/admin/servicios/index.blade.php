@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/servicios/servicio.css'])

<div class="servicios-container" id="modulo-servicios">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;flex-wrap:wrap;">
        <h2 tabindex="0" style="margin:0;">Servicios y Combos</h2>
        <a href="{{ route('servicios.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nuevo servicio o combo">
            <span aria-hidden="true">&#43;</span> Crear servicio / combo
        </a>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p style="color:#DC2626" role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    {{-- Lista accesible para lectores de pantalla --}}
    <ul class="sr-only" aria-label="Lista completa de servicios y combos">
        @foreach($servicios as $s)
        <li>
            <strong>Nombre:</strong> {{ $s->serv_nombre }}
            <strong>Tipo:</strong> {{ $s->serv_categoria === 'combos' ? 'Combo' : 'Servicio' }}
            <strong>Categoría:</strong> {{ ucfirst($s->serv_categoria) }}
            <strong>Precio:</strong> {{ $s->serv_precio }} pesos colombianos
            <strong>Descuento:</strong> {{ $s->serv_descuento ?? 0 }}%
            <strong>Precio final:</strong> {{ $s->serv_precio * (1 - ($s->serv_descuento ?? 0)/100) }} pesos colombianos
            <strong>Duración:</strong> {{ $s->serv_duracion }} min
            <strong>Estado:</strong> {{ $s->serv_estado }}
            <strong>Incluye:</strong>
             @if($s->serv_categoria === 'combos' && !empty($s->serv_servicios_incluidos))
                @php
                    $nombresIncluidos = collect($s->serv_servicios_incluidos)->map(fn($id) => $servicioNombres[$id] ?? null)->filter()->implode(', ');
                @endphp
                {{ $nombresIncluidos }}
            @else
                Ningún servicio incluido
            @endif
            <strong>Acciones:</strong>
            <a href="{{ route('servicios.edit', $s->serv_id) }}" aria-label="Editar {{ $s->serv_categoria === 'combos' ? 'combo' : 'servicio' }} {{ $s->serv_nombre }}">Editar</a>
            <form action="{{ route('servicios.destroy', $s->serv_id) }}" method="POST" style="display:inline;margin:0;padding:0;border:none;background:none;box-shadow:none;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-eliminar btn-eliminar-servicio" style="background:none;border:none;color:#DC2626;cursor:pointer;padding:0;margin:0;" aria-label="Eliminar {{ $s->serv_categoria === 'combos' ? 'combo' : 'servicio' }} {{ $s->serv_nombre }}">Eliminar</button>
            </form>
        </li>
        @endforeach
    </ul>

    {{-- Tabla visual --}}
    <table border="1" width="100%" role="table" aria-label="Lista de servicios y combos" aria-hidden="true">
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Categoría</th>
                <th scope="col">Precio</th>
                <th scope="col">Descuento (%)</th>
                <th scope="col">Precio final</th>
                <th scope="col">Duración</th>
                <th scope="col">Estado</th>
                <th scope="col">Incluye</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($servicios as $s)
        <tr class="{{ $s->serv_categoria === 'combos' ? 'fila-combo' : '' }}">
            <td aria-label="Tipo">
                @if($s->serv_categoria === 'combos')
                    <span class="badge-combo" title="Combo">Combo</span>
                @else
                    <span class="badge-servicio" title="Servicio">Servicio</span>
                @endif
            </td>
            <td aria-label="Nombre">{{ $s->serv_nombre }}</td>
            <td aria-label="Categoría">{{ ucfirst($s->serv_categoria) }}</td>
            <td aria-label="Precio">${{ number_format($s->serv_precio, 2) }}</td>
            <td aria-label="Descuento">{{ $s->serv_descuento ?? 0 }}%</td>
            <td aria-label="Precio final">
                ${{ number_format($s->serv_precio * (1 - ($s->serv_descuento ?? 0)/100), 2) }}
            </td>
            <td aria-label="Duración">{{ $s->serv_duracion }} min</td>
            <td aria-label="Estado">
                <span class="{{ $s->serv_estado === 'activo' ? 'estado-activo' : 'estado-inactivo' }}">
                    {{ ucfirst($s->serv_estado) }}
                </span>
            </td>
            <td aria-label="Servicios incluidos">
                @if($s->serv_categoria === 'combos' && !empty($s->serv_servicios_incluidos))
                    @php
                        $incluidos = collect($s->serv_servicios_incluidos)->map(fn($id) => isset($servicioNombres[$id]) ? (object)['serv_nombre' => $servicioNombres[$id]] : null)->filter();
                    @endphp
                    <ul style="margin:0;padding-left:1rem;list-style:disc;">
                        @foreach($incluidos as $inc)
                            <li>{{ $inc->serv_nombre }}</li>
                        @endforeach
                    </ul>
                @else
                    —
                @endif
            </td>
            <td aria-label="Acciones">
                <a href="{{ route('servicios.edit', $s->serv_id) }}" class="btn-editar" tabindex="0" aria-label="Editar {{ $s->serv_categoria === 'combos' ? 'combo' : 'servicio' }} {{ $s->serv_nombre }}">Editar</a>
                <form action="{{ route('servicios.destroy', $s->serv_id) }}" method="POST" aria-label="Eliminar {{ $s->serv_categoria === 'combos' ? 'combo' : 'servicio' }} {{ $s->serv_nombre }}" style="display:inline;margin:0;padding:0;border:none;background:none;box-shadow:none;">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-eliminar btn-eliminar-servicio" tabindex="0" aria-label="Eliminar {{ $s->serv_categoria === 'combos' ? 'combo' : 'servicio' }} {{ $s->serv_nombre }}" style="margin:0;">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" style="text-align:center;padding:2rem;">No hay servicios ni combos registrados.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    {{-- Modal de confirmación de eliminación --}}
    <div id="modal-eliminar-servicio" class="modal-eliminar-servicio" role="dialog" aria-modal="true" aria-labelledby="modal-eliminar-servicio-titulo" aria-describedby="modal-eliminar-servicio-desc" tabindex="-1">
        <div>
            <button id="cerrar-modal-eliminar-servicio" type="button" aria-label="Cerrar modal">&times;</button>
            <h2 id="modal-eliminar-servicio-titulo" tabindex="0">¿Eliminar este elemento?</h2>
            <p id="modal-eliminar-servicio-desc" aria-live="assertive">Esta acción no se puede deshacer. Si confirmas, el servicio o combo será eliminado permanentemente.</p>
            <div>
                <button id="cancelar-eliminar-servicio" type="button" aria-label="Cancelar y cerrar el modal">Cancelar</button>
                <button id="confirmar-eliminar-servicio" type="button" aria-label="Confirmar eliminación del servicio o combo">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let formAEliminar = null;
        const modal = document.getElementById('modal-eliminar-servicio');
        const btnCancelar = document.getElementById('cancelar-eliminar-servicio');
        const btnConfirmar = document.getElementById('confirmar-eliminar-servicio');
        const btnCerrar = document.getElementById('cerrar-modal-eliminar-servicio');

        document.querySelectorAll('.btn-eliminar-servicio').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                formAEliminar = btn.closest('form');
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
                btnConfirmar.focus();
            });
        });

        function cerrarModal() {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            formAEliminar = null;
        }

        btnCancelar.addEventListener('click', cerrarModal);
        btnCerrar.addEventListener('click', cerrarModal);
        btnConfirmar.addEventListener('click', function() {
            if (formAEliminar) formAEliminar.submit();
        });
        modal.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') cerrarModal();
        });
    });
    </script>
</div>
@endsection
