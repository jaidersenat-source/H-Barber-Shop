@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/membresias/membresia.css'])

<div class="membresias-container" id="modulo-membresias">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1.5rem;flex-wrap:wrap;">
        <h2 tabindex="0" style="margin:0;">Membresías</h2>
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
            <a href="{{ route('membresias.clientes') }}" class="btn btn-outline-secondary" tabindex="0" aria-label="Ver clientes con membresías">
                👥 Clientes con membresías
            </a>
            <a href="{{ route('membresias.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Crear nueva membresía">
                <span aria-hidden="true">&#43;</span> Crear membresía
            </a>
        </div>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p style="color:#DC2626" role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    {{-- Lista accesible para lectores de pantalla --}}
    <ul class="sr-only" aria-label="Lista completa de membresías">
        @foreach($membresias as $m)
        <li>
            <strong>Nombre:</strong> {{ $m->nombre }}
            <strong>Precio:</strong> {{ $m->precio }} pesos colombianos
            <strong>Duración:</strong> {{ $m->etiquetaDuracion() }}
            <strong>Estado:</strong> {{ $m->activo ? 'Activa' : 'Inactiva' }}
            <strong>Beneficios:</strong> {{ implode(', ', $m->beneficiosLista()) ?: '—' }}
        </li>
        @endforeach
    </ul>

    {{-- Tabla visual --}}
    <table border="1" width="100%" role="table" aria-label="Lista de membresías" aria-hidden="true">
        <thead>
            <tr>
                <th scope="col">Imagen</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Duración</th>
                <th scope="col">Beneficios</th>
                <th scope="col">Orden</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($membresias as $m)
        <tr>
            <td aria-label="Imagen" style="text-align:center;">
                @if($m->imagen)
                    <img src="{{ asset('storage/' . $m->imagen) }}"
                         alt="Imagen de {{ $m->nombre }}"
                         style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                @else
                    <span style="color:#aaa;font-size:0.85rem;">Sin imagen</span>
                @endif
            </td>
            <td aria-label="Nombre">
                <strong>{{ $m->nombre }}</strong>
                @if($m->descripcion)
                    <br><small style="color:#666;">{{ Str::limit($m->descripcion, 60) }}</small>
                @endif
            </td>
            <td aria-label="Precio">${{ number_format($m->precio, 2) }}</td>
            <td aria-label="Duración">{{ $m->etiquetaDuracion() }}</td>
            <td aria-label="Beneficios">
                @if(!empty($m->beneficiosLista()))
                    <ul style="margin:0;padding-left:1rem;list-style:disc;">
                        @foreach($m->beneficiosLista() as $b)
                            <li style="font-size:0.85rem;">{{ $b }}</li>
                        @endforeach
                    </ul>
                @else
                    <span style="color:#aaa;">—</span>
                @endif
            </td>
            <td aria-label="Orden" style="text-align:center;">{{ $m->orden }}</td>
            <td aria-label="Estado">
                <span class="{{ $m->activo ? 'estado-activo' : 'estado-inactivo' }}">
                    {{ $m->activo ? 'Activa' : 'Inactiva' }}
                </span>
            </td>
            <td aria-label="Acciones" style="white-space:nowrap;">
                {{-- Editar --}}
                <a href="{{ route('membresias.edit', $m->id) }}"
                   class="btn-editar"
                   tabindex="0"
                   aria-label="Editar membresía {{ $m->nombre }}">Editar</a>

                {{-- Toggle activo --}}
                <form action="{{ route('membresias.toggle-activo', $m->id) }}" method="POST" style="display:inline;margin:0;">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="{{ $m->activo ? 'btn-desactivar' : 'btn-activar' }}"
                            aria-label="{{ $m->activo ? 'Desactivar' : 'Activar' }} membresía {{ $m->nombre }}">
                        {{ $m->activo ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>

                {{-- Eliminar --}}
                <form action="{{ route('membresias.destroy', $m->id) }}" method="POST"
                      style="display:inline;margin:0;padding:0;border:none;background:none;box-shadow:none;">
                    @csrf @method('DELETE')
                    <button type="button"
                            class="btn-eliminar btn-eliminar-membresia"
                            aria-label="Eliminar membresía {{ $m->nombre }}"
                            style="margin:0;">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;padding:2rem;">No hay membresías registradas.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    {{-- Modal de confirmación de eliminación --}}
    <div id="modal-eliminar-membresia" class="modal-eliminar-membresia"
         role="dialog" aria-modal="true"
         aria-labelledby="modal-eliminar-membresia-titulo"
         aria-describedby="modal-eliminar-membresia-desc"
         tabindex="-1">
        <div>
            <button id="cerrar-modal-eliminar-membresia" type="button" aria-label="Cerrar modal">&times;</button>
            <h2 id="modal-eliminar-membresia-titulo" tabindex="0">¿Eliminar esta membresía?</h2>
            <p id="modal-eliminar-membresia-desc" aria-live="assertive">
                Esta acción no se puede deshacer. Si confirmas, la membresía será eliminada permanentemente.
                Solo se puede eliminar si no tiene clientes activos.
            </p>
            <div>
                <button id="cancelar-eliminar-membresia" type="button" aria-label="Cancelar">Cancelar</button>
                <button id="confirmar-eliminar-membresia" type="button" aria-label="Confirmar eliminación">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let formAEliminar = null;
        const modal     = document.getElementById('modal-eliminar-membresia');
        const btnCancel = document.getElementById('cancelar-eliminar-membresia');
        const btnOk     = document.getElementById('confirmar-eliminar-membresia');
        const btnClose  = document.getElementById('cerrar-modal-eliminar-membresia');

        document.querySelectorAll('.btn-eliminar-membresia').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                formAEliminar = btn.closest('form');
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
                btnOk.focus();
            });
        });

        function cerrarModal() {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            formAEliminar = null;
        }

        btnCancel.addEventListener('click', cerrarModal);
        btnClose.addEventListener('click', cerrarModal);
        btnOk.addEventListener('click', function () {
            if (formAEliminar) formAEliminar.submit();
        });
        modal.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') cerrarModal();
        });
    });
    </script>
</div>
@endsection