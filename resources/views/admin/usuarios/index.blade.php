@extends('admin.layout')

@section('content')

<div class="container" role="main" aria-label="Gestión de usuarios barberos">
    <h1 tabindex="0">Usuarios (Barberos)</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert" aria-live="assertive">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert" aria-live="assertive">{{ session('error') }}</div>
    @endif

    <table class="table" role="table" aria-label="Lista de barberos">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Usuario</th>
                <th scope="col">Cédula</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $u)
            <tr>
                <td>{{ $u->usuario_id }}</td>
                <td>{{ $u->usuario }}</td>
                <td>{{ $u->per_documento }}</td>
                <td>{{ $u->estado }}</td>
                <td>
                    @if($u->estado !== 'activo')
                    <form method="POST" action="{{ url('admin/usuarios/'.$u->usuario_id.'/activar') }}" aria-label="Activar usuario {{ $u->usuario }}">
                        @csrf
                        <button class="btn btn-sm btn-primary" type="submit" tabindex="0" aria-label="Activar usuario {{ $u->usuario }}">Activar</button>
                    </form>
                    @else
                        <span class="text-success" aria-label="Usuario activo">Activo</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
