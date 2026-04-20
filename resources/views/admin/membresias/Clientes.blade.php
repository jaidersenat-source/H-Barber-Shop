@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/membresias/clientes.css'])

<div class="membresias-container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1rem;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:1rem;">
            
            <h2 tabindex="0" style="margin:0;">Clientes con membresías</h2>
        </div>
        <button type="button" class="btn btn-outline-primary" id="btn-mostrar-form-asignar">
            &#43; Asignar membresía a cliente
        </button>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p style="color:#DC2626" role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    {{-- Formulario de asignación (colapsable) --}}
    <div id="form-asignar" style="display:none;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:1.5rem;margin-bottom:2rem;">
        <h3 style="margin-top:0;">Asignar membresía</h3>
        <form action="{{ route('membresias.clientes.asignar') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:1rem;align-items:end;flex-wrap:wrap;">
                <div class="form-group" style="margin:0;">
                    <label for="cliente_cedula">Cédula del cliente <span aria-hidden="true">*</span></label>
                    <input type="text" id="cliente_cedula" name="cliente_cedula"
                           value="{{ old('cliente_cedula') }}"
                           class="form-control @error('cliente_cedula') is-invalid @enderror"
                           required maxlength="20" placeholder="Ej: 1234567890"
                           aria-required="true">
                    @error('cliente_cedula')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin:0;">
                    <label for="membresia_id">Membresía <span aria-hidden="true">*</span></label>
                    <select id="membresia_id" name="membresia_id"
                            class="form-control @error('membresia_id') is-invalid @enderror"
                            required aria-required="true">
                        <option value="">Seleccionar...</option>
                        @foreach($membresias as $mem)
                            <option value="{{ $mem->id }}" {{ old('membresia_id') == $mem->id ? 'selected' : '' }}>
                                {{ $mem->nombre }} — {{ $mem->etiquetaDuracion() }} — ${{ number_format($mem->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('membresia_id')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin:0;">
                    <label for="fecha_inicio">Fecha de inicio <span aria-hidden="true">*</span></label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                           value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                           class="form-control @error('fecha_inicio') is-invalid @enderror"
                           required aria-required="true">
                    @error('fecha_inicio')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Asignar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('membresias.clientes') }}" style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;">
            <label for="filtro-estado">Estado</label>
            <select id="filtro-estado" name="estado" class="form-control" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="activa"    {{ request('estado') === 'activa'    ? 'selected' : '' }}>Activa</option>
                <option value="vencida"   {{ request('estado') === 'vencida'   ? 'selected' : '' }}>Vencida</option>
                <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>
        <div class="form-group" style="margin:0;">
            <label for="filtro-membresia">Membresía</label>
            <select id="filtro-membresia" name="membresia_id" class="form-control" onchange="this.form.submit()">
                <option value="">Todas</option>
                @foreach($membresias as $mem)
                    <option value="{{ $mem->id }}" {{ request('membresia_id') == $mem->id ? 'selected' : '' }}>
                        {{ $mem->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('membresias.clientes') }}" class="btn btn-outline-secondary">Limpiar filtros</a>
    </form>

    {{-- Tabla --}}
    <table border="1" width="100%" role="table" aria-label="Clientes con membresías">
        <thead>
            <tr>
                <th scope="col">Cédula</th>
                <th scope="col">Membresía</th>
                <th scope="col">Fecha inicio</th>
                <th scope="col">Fecha fin</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($clientes as $cm)
        <tr>
            <td>{{ $cm->cliente_cedula }}</td>
            <td>{{ $cm->membresia?->nombre ?? '—' }}</td>
            <td>{{ $cm->fecha_inicio?->format('d/m/Y') }}</td>
            <td>{{ $cm->fecha_fin?->format('d/m/Y') }}</td>
            <td>
                @php
                    $colorEstado = match($cm->estado) {
                        'activa'    => 'estado-activo',
                        'vencida'   => 'estado-inactivo',
                        'cancelada' => 'estado-cancelado',
                        default     => ''
                    };
                @endphp
                <span class="{{ $colorEstado }}">{{ ucfirst($cm->estado) }}</span>
            </td>
            <td>
                @if($cm->estado === 'activa')
                    <button type="button"
                            class="btn-desactivar btn-cancelar-membresia"
                            data-action="{{ route('membresias.clientes.cancelar', $cm->id) }}"
                            data-cedula="{{ $cm->cliente_cedula }}"
                            data-nombre="{{ $cm->membresia?->nombre ?? 'membresía' }}"
                            aria-label="Cancelar membresía del cliente {{ $cm->cliente_cedula }}">
                        Cancelar
                    </button>
                @else
                    <span style="color:#aaa;font-size:0.85rem;">Sin acciones</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:2rem;">No hay registros de membresías de clientes.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:1rem;">
        {{ $clientes->withQueryString()->links() }}
    </div>
</div>

{{-- Modal de confirmación: cancelar membresía --}}
<div id="modal-cancelar" role="dialog" aria-modal="true" aria-labelledby="modal-cancelar-titulo">
    <div class="modal-box">

        <div class="modal-body">
            {{-- Icono advertencia --}}
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            <h3 id="modal-cancelar-titulo">¿Cancelar membresía?</h3>
            <p id="modal-cancelar-texto"></p>
        </div>

        <div class="modal-divider"></div>

        <div class="modal-actions">
            <button type="button" id="modal-cancelar-no"
                    aria-label="Volver, no cancelar">
                No, volver
            </button>
            <form id="modal-cancelar-form" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-danger"
                        aria-label="Confirmar cancelación">
                    Sí, cancelar
                </button>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('btn-mostrar-form-asignar');
    const form = document.getElementById('form-asignar');
    let abierto = false;

    // Si hay errores de validación, mostrar el formulario automáticamente
    @if($errors->any())
        form.style.display = 'block';
        abierto = true;
    @endif

    btn.addEventListener('click', function () {
        abierto = !abierto;
        form.style.display = abierto ? 'block' : 'none';
        btn.textContent = abierto ? '✕ Cerrar formulario' : '＋ Asignar membresía a cliente';
    });

    // --- Modal cancelar membresía ---
    const modal       = document.getElementById('modal-cancelar');
    const modalTexto  = document.getElementById('modal-cancelar-texto');
    const modalForm   = document.getElementById('modal-cancelar-form');
    const btnNo       = document.getElementById('modal-cancelar-no');

    function abrirModal(action, cedula, nombre) {
        modalTexto.textContent =
            `Estás a punto de cancelar la membresía "${nombre}" del cliente con cédula ${cedula}. Esta acción no se puede deshacer.`;
        modalForm.action = action;
        modal.style.display = 'flex';
        btnNo.focus();
    }

    function cerrarModal() {
        modal.style.display = 'none';
    }

    document.querySelectorAll('.btn-cancelar-membresia').forEach(function (btn) {
        btn.addEventListener('click', function () {
            abrirModal(btn.dataset.action, btn.dataset.cedula, btn.dataset.nombre);
        });
    });

    btnNo.addEventListener('click', cerrarModal);

    // Cerrar al hacer clic en el fondo oscuro
    modal.addEventListener('click', function (e) {
        if (e.target === modal) cerrarModal();
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') cerrarModal();
    });
});
</script>
@endsection
@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/membresias/clientes.css'])

<div class="membresias-container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;gap:1rem;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:1rem;">
            
            <h2 tabindex="0" style="margin:0;">Clientes con membresías</h2>
        </div>
        <button type="button" class="btn btn-outline-primary" id="btn-mostrar-form-asignar">
            &#43; Asignar membresía a cliente
        </button>
    </div>

    @if(session('ok'))
        <p style="color:green" role="alert" aria-live="assertive">{{ session('ok') }}</p>
    @endif
    @if(session('error'))
        <p style="color:#DC2626" role="alert" aria-live="assertive">{{ session('error') }}</p>
    @endif

    {{-- Formulario de asignación (colapsable) --}}
    <div id="form-asignar" style="display:none;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:1.5rem;margin-bottom:2rem;">
        <h3 style="margin-top:0;">Asignar membresía</h3>
        <form action="{{ route('membresias.clientes.asignar') }}" method="POST">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:1rem;align-items:end;flex-wrap:wrap;">
                <div class="form-group" style="margin:0;">
                    <label for="cliente_cedula">Cédula del cliente <span aria-hidden="true">*</span></label>
                    <input type="text" id="cliente_cedula" name="cliente_cedula"
                           value="{{ old('cliente_cedula') }}"
                           class="form-control @error('cliente_cedula') is-invalid @enderror"
                           required maxlength="20" placeholder="Ej: 1234567890"
                           aria-required="true">
                    @error('cliente_cedula')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin:0;">
                    <label for="membresia_id">Membresía <span aria-hidden="true">*</span></label>
                    <select id="membresia_id" name="membresia_id"
                            class="form-control @error('membresia_id') is-invalid @enderror"
                            required aria-required="true">
                        <option value="">Seleccionar...</option>
                        @foreach($membresias as $mem)
                            <option value="{{ $mem->id }}" {{ old('membresia_id') == $mem->id ? 'selected' : '' }}>
                                {{ $mem->nombre }} — {{ $mem->etiquetaDuracion() }} — ${{ number_format($mem->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('membresia_id')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin:0;">
                    <label for="fecha_inicio">Fecha de inicio <span aria-hidden="true">*</span></label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                           value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                           class="form-control @error('fecha_inicio') is-invalid @enderror"
                           required aria-required="true">
                    @error('fecha_inicio')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Asignar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('membresias.clientes') }}" style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;">
            <label for="filtro-estado">Estado</label>
            <select id="filtro-estado" name="estado" class="form-control" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="activa"    {{ request('estado') === 'activa'    ? 'selected' : '' }}>Activa</option>
                <option value="vencida"   {{ request('estado') === 'vencida'   ? 'selected' : '' }}>Vencida</option>
                <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>
        <div class="form-group" style="margin:0;">
            <label for="filtro-membresia">Membresía</label>
            <select id="filtro-membresia" name="membresia_id" class="form-control" onchange="this.form.submit()">
                <option value="">Todas</option>
                @foreach($membresias as $mem)
                    <option value="{{ $mem->id }}" {{ request('membresia_id') == $mem->id ? 'selected' : '' }}>
                        {{ $mem->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('membresias.clientes') }}" class="btn btn-outline-secondary">Limpiar filtros</a>
    </form>

    {{-- Tabla --}}
    <table border="1" width="100%" role="table" aria-label="Clientes con membresías">
        <thead>
            <tr>
                <th scope="col">Cédula</th>
                <th scope="col">Membresía</th>
                <th scope="col">Fecha inicio</th>
                <th scope="col">Fecha fin</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse($clientes as $cm)
        <tr>
            <td>{{ $cm->cliente_cedula }}</td>
            <td>{{ $cm->membresia?->nombre ?? '—' }}</td>
            <td>{{ $cm->fecha_inicio?->format('d/m/Y') }}</td>
            <td>{{ $cm->fecha_fin?->format('d/m/Y') }}</td>
            <td>
                @php
                    $colorEstado = match($cm->estado) {
                        'activa'    => 'estado-activo',
                        'vencida'   => 'estado-inactivo',
                        'cancelada' => 'estado-cancelado',
                        default     => ''
                    };
                @endphp
                <span class="{{ $colorEstado }}">{{ ucfirst($cm->estado) }}</span>
            </td>
            <td>
                @if($cm->estado === 'activa')
                    <button type="button"
                            class="btn-desactivar btn-cancelar-membresia"
                            data-action="{{ route('membresias.clientes.cancelar', $cm->id) }}"
                            data-cedula="{{ $cm->cliente_cedula }}"
                            data-nombre="{{ $cm->membresia?->nombre ?? 'membresía' }}"
                            aria-label="Cancelar membresía del cliente {{ $cm->cliente_cedula }}">
                        Cancelar
                    </button>
                @else
                    <span style="color:#aaa;font-size:0.85rem;">Sin acciones</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:2rem;">No hay registros de membresías de clientes.</td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:1rem;">
        {{ $clientes->withQueryString()->links() }}
    </div>
</div>

{{-- Modal de confirmación: cancelar membresía --}}
<div id="modal-cancelar" role="dialog" aria-modal="true" aria-labelledby="modal-cancelar-titulo">
    <div class="modal-box">

        <div class="modal-body">
            {{-- Icono advertencia --}}
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>

            <h3 id="modal-cancelar-titulo">¿Cancelar membresía?</h3>
            <p id="modal-cancelar-texto"></p>
        </div>

        <div class="modal-divider"></div>

        <div class="modal-actions">
            <button type="button" id="modal-cancelar-no"
                    aria-label="Volver, no cancelar">
                No, volver
            </button>
            <form id="modal-cancelar-form" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="btn-danger"
                        aria-label="Confirmar cancelación">
                    Sí, cancelar
                </button>
            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('btn-mostrar-form-asignar');
    const form = document.getElementById('form-asignar');
    let abierto = false;

    // Si hay errores de validación, mostrar el formulario automáticamente
    @if($errors->any())
        form.style.display = 'block';
        abierto = true;
    @endif

    btn.addEventListener('click', function () {
        abierto = !abierto;
        form.style.display = abierto ? 'block' : 'none';
        btn.textContent = abierto ? '✕ Cerrar formulario' : '＋ Asignar membresía a cliente';
    });

    // --- Modal cancelar membresía ---
    const modal       = document.getElementById('modal-cancelar');
    const modalTexto  = document.getElementById('modal-cancelar-texto');
    const modalForm   = document.getElementById('modal-cancelar-form');
    const btnNo       = document.getElementById('modal-cancelar-no');

    function abrirModal(action, cedula, nombre) {
        modalTexto.textContent =
            `Estás a punto de cancelar la membresía "${nombre}" del cliente con cédula ${cedula}. Esta acción no se puede deshacer.`;
        modalForm.action = action;
        modal.style.display = 'flex';
        btnNo.focus();
    }

    function cerrarModal() {
        modal.style.display = 'none';
    }

    document.querySelectorAll('.btn-cancelar-membresia').forEach(function (btn) {
        btn.addEventListener('click', function () {
            abrirModal(btn.dataset.action, btn.dataset.cedula, btn.dataset.nombre);
        });
    });

    btnNo.addEventListener('click', cerrarModal);

    // Cerrar al hacer clic en el fondo oscuro
    modal.addEventListener('click', function (e) {
        if (e.target === modal) cerrarModal();
    });

    // Cerrar con Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') cerrarModal();
    });
});
</script>
@endsection