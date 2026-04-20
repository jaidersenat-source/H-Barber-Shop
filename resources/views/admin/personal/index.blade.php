@extends('admin.layout')

@section('content')
<div class="card" role="main" aria-label="Gestión de barberos registrados" id="modulo-personal">
    <div class="sr-only" aria-hidden="true">Estás en el módulo de Personal. Barberos registrados.</div>
    <div>
        <h1 tabindex="0">Barberos registrados</h1>
        <a href="{{ route('personal.create') }}" class="btn btn-outline-primary crear-btn" tabindex="0" aria-label="Registrar nuevo barbero">
            <span  aria-hidden="true">&#43;</span> Registrar nuevo barbero
        </a>
    </div>

    @vite(['resources/css/Admin/personal/personal.css'])

    <ul class="sr-only">
        @foreach($personal as $p)
            <li>
                {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }},
                @if($p->persona->usuario && $p->persona->usuario->estado === 'activo')
                    activo
                @elseif($p->persona->usuario && $p->persona->usuario->estado !== 'activo')
                    inactivo
                @else
                    no registrado
                @endif
            </li>
        @endforeach
    </ul>

    <!-- Lista vertical accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista de barberos detallada">
        @foreach($personal as $p)
        <li>
            <strong>Documento:</strong> {{ $p->persona->per_documento }}<br>
            <strong>Nombre:</strong> {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}<br>
            <strong>Sede:</strong> {{ $p->sede->sede_nombre }}<br>
            <strong>Estado:</strong> {{ $p->persede_estado }}<br>
            <strong>Usuario:</strong>
            @if($p->persona->usuario)
                {{ $p->persona->usuario->usuario }} ({{ $p->persona->usuario->estado }})
            @else
                No registrado
            @endif<br>
            <strong>Acciones:</strong>
            @if($p->persona->usuario && $p->persona->usuario->estado !== 'activo')
                <span>El usuario está inactivo. 
                    <form method="POST" action="{{ route('admin.usuarios.activar', $p->persona->usuario->usuario_id) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" aria-label="Activar usuario {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}">Activar usuario</button>
                    </form>
                </span>
            @elseif(!$p->persona->usuario)
                <span>No tiene usuario registrado. 
                    <a href="{{ route('register.form') }}?per_documento={{ $p->persona->per_documento }}" class="btn btn-link p-0 m-0 align-baseline" aria-label="Registrar usuario para {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}">Registrar usuario</a>
                </span>
            @else
                <span>El usuario está activo. 
                    <form method="POST" action="{{ route('admin.usuarios.desactivar', $p->persona->usuario->usuario_id) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" aria-label="Desactivar usuario {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}">Desactivar usuario</button>
                    </form>
                </span>
            @endif
        </li>
        @endforeach
    </ul>

    <!-- Tabla visual solo para usuarios videntes -->
    @php
    $headers = ['Documento', 'Nombre', 'Sede', 'Estado', 'Usuario', 'Acciones'];
    @endphp
    <table class="table" role="table" aria-label="Lista de barberos" aria-hidden="true">
        <thead>
        <tr>
            @foreach($headers as $header)
                <th scope="col">{{ $header }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($personal as $p)
        <tr>
            <td data-label="Documento">{{ $p->persona->per_documento }}</td>
            <td data-label="Nombre">{{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}</td>
            <td data-label="Sede">{{ $p->sede->sede_nombre }}</td>
            <td data-label="Estado">{{ $p->persede_estado }}</td>
            <td data-label="Usuario">
                @if($p->persona->usuario)
                    <span>{{ $p->persona->usuario->usuario }} ({{ $p->persona->usuario->estado }})</span>
                @else
                    <em>No registrado</em>
                @endif
            </td>
            <td data-label="Acciones">
                @if($p->persona->usuario && $p->persona->usuario->estado !== 'activo')
                    <form method="POST" action="{{ route('admin.usuarios.activar', $p->persona->usuario->usuario_id) }}">
                        @csrf
                        <button class="btn btn-sm btn-primary" type="submit" tabindex="0" aria-label="Activar usuario {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}">Activar</button>
                    </form>
                @elseif(!$p->persona->usuario)
                    <a href="{{ route('register.form') }}?per_documento={{ $p->persona->per_documento }}" class="btn btn-sm" tabindex="0">Registrar usuario</a>
                @else
                    <span class="text-success">Activo</span>
                    <form method="POST" action="{{ route('admin.usuarios.desactivar', $p->persona->usuario->usuario_id) }}" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-danger" type="submit" tabindex="0" aria-label="Desactivar usuario {{ $p->persona->per_nombre }} {{ $p->persona->per_apellido }}">Desactivar</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
