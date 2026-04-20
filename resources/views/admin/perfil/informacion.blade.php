@extends('admin.layout')

@section('title', 'Configuracion de Perfil')

@vite(['resources/css/Admin/config/informacion.css'])

@section('content')
<main class="configuracion-container" role="main" aria-labelledby="page-title" id="modulo-configuracion-perfil">
    {{-- Skip link para saltar al formulario --}}
    <a href="#perfil-form" class="skip-link">Saltar al formulario</a>
    
    <header class="page-header">
        <h1 id="page-title">Configuracion de Perfil</h1>
        <p class="page-description" id="form-description">
            Actualice su informacion personal y credenciales de acceso.
        </p>
    </header>

    {{-- Mensajes de exito/error accesibles --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert" aria-live="polite">
            <span class="alert-icon" aria-hidden="true">&#10003;</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error" role="alert" aria-live="assertive">
            <span class="alert-icon" aria-hidden="true">&#9888;</span>
            <div>
                <strong>Por favor corrija los siguientes errores:</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- =====================================================
         SECCIÓN: FOTO DE PERFIL (formulario independiente)
         ===================================================== --}}
    <section class="form-section foto-perfil-section" aria-labelledby="foto-titulo">
        <h2 id="foto-titulo" class="legend-like">
            <span class="legend-icon" aria-hidden="true">&#128247;</span>
            Foto de Perfil
        </h2>

        {{-- Vista previa de la foto actual --}}
        <div class="foto-preview-wrapper" aria-label="Foto de perfil actual">
            @if(Auth::user()->foto_perfil)
                <img
                    id="foto-preview"
                    src="{{ asset('storage/' . Auth::user()->foto_perfil) }}"
                    alt="Foto de perfil de {{ Auth::user()->usuario }}"
                    class="foto-preview"
                >
            @else
                <div id="foto-preview-placeholder" class="foto-placeholder" aria-hidden="true">
                    <span class="foto-placeholder-icon">&#128100;</span>
                </div>
                <img id="foto-preview" src="" alt="" class="foto-preview" style="display:none;">
            @endif
        </div>

        <form
            method="POST"
            action="{{ route('perfil.guardarFoto') }}"
            enctype="multipart/form-data"
            id="foto-form"
            aria-describedby="foto-hint"
        >
            @csrf
            <div class="form-group">
                <label for="foto_perfil" class="btn btn-secondary" style="cursor:pointer;" aria-describedby="foto-hint">
                    <span aria-hidden="true">&#128247;</span> Seleccionar foto
                    <input
                        type="file"
                        name="foto_perfil"
                        id="foto_perfil"
                        accept="image/jpeg,image/png,image/webp"
                        class="sr-only"
                        aria-label="Seleccionar imagen de perfil"
                    >
                </label>
                <span id="foto-hint" class="form-hint">
                    Formatos aceptados: JPG, PNG, WEBP. Tamaño máximo: 2 MB.
                </span>
                {{-- Nombre del archivo seleccionado --}}
                <span id="foto-nombre-archivo" class="form-hint" aria-live="polite" style="display:block;margin-top:4px;"></span>
                @error('foto_perfil')
                    <span class="form-error" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" id="btn-guardar-foto" style="display:none;">
                <span class="btn-icon" aria-hidden="true">&#10003;</span>
                Guardar foto
            </button>
        </form>
    </section>

    {{-- =====================================================
         FORMULARIO: INFORMACIÓN PERSONAL Y CONTRASEÑA
         ===================================================== --}}
    <form 
        method="POST" 
        action="{{ route('perfil.update') }}" 
        class="configuracion-form" 
        id="perfil-form"
        aria-describedby="form-description"
        novalidate
    >
        @csrf
        @method('PUT')

        {{-- Seccion: Informacion Personal --}}
        <fieldset class="form-section">
            <legend>
                <span class="legend-icon" aria-hidden="true">&#128100;</span>
                Información Personal
            </legend>

            <div class="form-group">
                <label for="username" class="form-label">
                    Nombre de usuario
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(campo requerido)</span>
                </label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-control @error('username') is-invalid @enderror" 
                    value="{{ old('username', Auth::user()->usuario) }}" 
                    required
                    aria-required="true"
                    aria-describedby="username-hint @error('username') username-error @enderror"
                    autocomplete="username"
                >
                <span id="username-hint" class="form-hint">Este será tu nombre de usuario para ingresar al sistema.</span>
                @error('username')
                    <span id="username-error" class="form-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="documento" class="form-label">
                    Documento
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(campo requerido)</span>
                </label>
                <input 
                    type="text" 
                    name="documento" 
                    id="documento" 
                    class="form-control @error('documento') is-invalid @enderror" 
                    value="{{ old('documento', Auth::user()->per_documento) }}" 
                    required
                    aria-required="true"
                    aria-describedby="documento-hint @error('documento') documento-error @enderror"
                    autocomplete="off"
                >
                <span id="documento-hint" class="form-hint">Tu número de documento de identidad.</span>
                @error('documento')
                    <span id="documento-error" class="form-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    Correo electronico
                    <span class="required" aria-hidden="true">*</span>
                    <span class="sr-only">(campo requerido)</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', isset($persona) ? $persona->per_correo : '') }}" 
                    required
                    aria-required="true"
                    aria-describedby="email-hint @error('email') email-error @enderror"
                    autocomplete="email"
                >
                <span id="email-hint" class="form-hint">Se usara para recibir notificaciones.</span>
                @error('email')
                    <span id="email-error" class="form-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <span class="btn-icon" aria-hidden="true">&#10003;</span>
                Guardar cambios
            </button>
        </fieldset>

        {{-- Seccion: Cambio de Contraseña --}}
        <fieldset class="form-section">
            <legend>
                <span class="legend-icon" aria-hidden="true">&#128274;</span>
                Cambiar Contraseña
            </legend>
            <p class="section-description" id="password-section-desc">
                Deje estos campos vacíos si no desea cambiar su contraseña.
            </p>

            <div class="form-group">
                <label for="current_password" class="form-label">Contraseña actual</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        class="form-control @error('current_password') is-invalid @enderror"
                        autocomplete="current-password"
                        aria-describedby="current-password-hint @error('current_password') current-password-error @enderror"
                    >
                    <button type="button" class="toggle-password" aria-label="Mostrar contraseña actual" data-target="current_password">
                        <span class="eye-icon" aria-hidden="true">&#128065;</span>
                    </button>
                </div>
                <span id="current-password-hint" class="form-hint">Ingrese su contraseña actual para verificar su identidad.</span>
                @error('current_password')
                    <span id="current-password-error" class="form-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Nueva contraseña</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="new-password"
                        aria-describedby="password-requirements @error('password') password-error @enderror"
                    >
                    <button type="button" class="toggle-password" aria-label="Mostrar nueva contraseña" data-target="password">
                        <span class="eye-icon" aria-hidden="true">&#128065;</span>
                    </button>
                </div>
                <div id="password-requirements" class="form-hint">
                    <strong>Requisitos de contraseña:</strong>
                    <ul class="requirements-list">
                        <li>Minimo 8 caracteres</li>
                        <li>Al menos una mayuscula</li>
                        <li>Al menos un numero</li>
                    </ul>
                </div>
                @error('password')
                    <span id="password-error" class="form-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="form-control"
                        autocomplete="new-password"
                        aria-describedby="password-confirm-hint"
                    >
                    <button type="button" class="toggle-password" aria-label="Mostrar confirmación de contraseña" data-target="password_confirmation">
                        <span class="eye-icon" aria-hidden="true">&#128065;</span>
                    </button>
                </div>
                <span id="password-confirm-hint" class="form-hint">Repita la nueva contraseña para confirmar.</span>
            </div>
        </fieldset>

        {{-- Botones de accion --}}
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <span class="btn-icon" aria-hidden="true">&#10003;</span>
                Guardar cambios
            </button>
            <a href="{{ route('perfil.show') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <div id="sr-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>
</main>

<script>
window.turnosAvailableRoute = "{{ route('turnos.available') }}";
window.turnosStoreRoute     = "{{ route('turnos.store') }}";

// ── Foto de perfil: preview en tiempo real ──────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const input       = document.getElementById('foto_perfil');
    const preview     = document.getElementById('foto-preview');
    const placeholder = document.getElementById('foto-preview-placeholder');
    const nombreSpan  = document.getElementById('foto-nombre-archivo');
    const btnGuardar  = document.getElementById('btn-guardar-foto');

    if (!input) return;

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Validar tamaño en el cliente (2 MB)
        if (file.size > 2 * 1024 * 1024) {
            nombreSpan.textContent = '⚠️ El archivo supera los 2 MB permitidos.';
            nombreSpan.style.color = '#dc2626';
            btnGuardar.style.display = 'none';
            return;
        }

        // Mostrar nombre del archivo
        nombreSpan.textContent = '📎 ' + file.name;
        nombreSpan.style.color = '';

        // Preview con FileReader
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.alt = 'Vista previa de la nueva foto de perfil';
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);

        // Mostrar botón guardar
        btnGuardar.style.display = 'inline-flex';
    });
});
</script>

@vite(['resources/js/Admin/perfil.js'])
@endsection