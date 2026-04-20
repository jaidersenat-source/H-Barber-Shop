@extends('layouts.app')

@section('content')
@vite(['resources/css/auth/email.css'])

<div class="recovery-container" aria-label="Recuperación de contraseña">
    <!-- Sección de branding -->
    <div class="brand-section" role="complementary" aria-label="Información de la marca">
        <div class="brand-content">
            <div class="brand-logo" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.18-.92-6-4.42-6-8V8.3l6-3.27 6 3.27V12c0 3.58-2.82 7.08-6 8z"/>
                    <path d="M10.5 13l-2.12-2.12-1.42 1.42L10.5 16l6-6-1.42-1.42z"/>
                </svg>
            </div>
            <h1>Recuperar Contraseña</h1>
            <p>Ingrese su correo electrónico y le enviaremos instrucciones para restablecer su contraseña de forma segura.</p>
        </div>
    </div>

    <!-- Sección del formulario -->
    <main class="form-section" role="main" aria-label="Formulario de recuperación de contraseña">
        <div class="recovery-box">
            <div class="recovery-header">
                <h2 id="tituloRecuperar">Restablecer contraseña</h2>
                <p>Le enviaremos un enlace seguro a su correo electrónico</p>
            </div>

            @if (session('status'))
                <div class="alert-success" role="alert" aria-live="polite">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" aria-labelledby="tituloRecuperar" aria-label="Formulario para recuperar contraseña">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico <span aria-hidden="true">*</span></label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="tu@email.com"
                        aria-describedby="email-error"
                        aria-label="Correo electrónico"
                        aria-required="true"
                    >
                    @error('email')
                        <span class="error-message" id="email-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" aria-label="Enviar enlace de recuperación de contraseña">
                    Enviar enlace de recuperación
                </button>
            </form>
        </div>
    </main>
</div>
@endsection