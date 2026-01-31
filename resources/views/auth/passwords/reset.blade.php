@extends('layouts.app')

@section('content')
@vite(['resources/css/auth/reset.css'])

<div class="reset-container">
    <!-- Sección de branding -->
    <div class="brand-section">
        <div class="brand-content">
            <div class="brand-logo">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                </svg>
            </div>
            <h1>Nueva Contraseña</h1>
            <p>Elija una contraseña segura y única para proteger su cuenta. Asegúrese de cumplir con todos los requisitos de seguridad.</p>
        </div>
    </div>

    <!-- Sección del formulario -->
    <div class="form-section">
        <div class="reset-box">
            <div class="reset-header">
                <h2>Restablecer contraseña</h2>
                <p>Ingrese su nueva contraseña para completar el proceso</p>
            </div>

            <div class="password-requirements">
                <h4>Requisitos de la contraseña:</h4>
                <ul>
                    <li>Mínimo 8 caracteres</li>
                    <li>Al menos una letra mayúscula</li>
                    <li>Al menos una letra minúscula</li>
                    <li>Al menos un número</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ $email ?? old('email') }}" 
                        required 
                        autofocus
                        placeholder="tu@email.com"
                        aria-describedby="email-error"
                    >
                    @error('email')
                        <span class="error-message" id="email-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Nueva contraseña</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        placeholder="••••••••"
                        aria-describedby="password-error"
                    >
                    <button 
                        type="button" 
                        class="password-toggle" 
                        onclick="togglePassword('password')"
                        aria-label="Mostrar contraseña"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                    @error('password')
                        <span class="error-message" id="password-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirmar contraseña</label>
                    <input 
                        id="password-confirm" 
                        type="password" 
                        name="password_confirmation" 
                        required
                        placeholder="••••••••"
                    >
                    <button 
                        type="button" 
                        class="password-toggle" 
                        onclick="togglePassword('password-confirm')"
                        aria-label="Mostrar confirmación de contraseña"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>

                <button type="submit" class="btn-primary">
                    Restablecer contraseña
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    
    if (field.type === 'password') {
        field.type = 'text';
        button.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            </svg>
        `;
        button.setAttribute('aria-label', 'Ocultar contraseña');
    } else {
        field.type = 'password';
        button.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        `;
        button.setAttribute('aria-label', 'Mostrar contraseña');
    }
}
</script>
@endsection