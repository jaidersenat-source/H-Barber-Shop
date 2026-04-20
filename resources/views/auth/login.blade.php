<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión | H Barber Shop</title>
    <link rel="icon" type="image/png" href="/img/1.png">
    @vite(['resources/css/auth/login.css'])
</head>
<body>

<div class="login-wrapper" role="main">

    <!-- LADO IZQUIERDO: Video completo -->
    <div class="video-panel" aria-hidden="true">
         
        
            <img class="bg-image" src="{{ asset('img/login.png') }}" alt="Fondo barbería">
       
        <!-- Overlay gradiente que se desvanece hacia la derecha -->
        <div class="video-fade-overlay"></div>
        <!-- Branding flotante sobre el video -->
        <div class="video-brand">
            <div class="brand-badge">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.859 0-7 3.141-7 7v1h17z"/>
                </svg>
            </div>
            <h1 class="brand-name">H Barber Shop</h1>
            <p class="brand-tagline">Estilo. Precisión. Profesionalismo.</p>
        </div>
    </div>

    <!-- LADO DERECHO: Formulario con glass effect -->
    <main class="form-panel" aria-label="Formulario de inicio de sesión">

        <!-- Panel glass que conecta con el video -->
        <div class="glass-bridge" aria-hidden="true"></div>

        <div class="form-container">

            <header class="form-header">
                <!-- Logo visible solo en mobile -->
                <div class="mobile-logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.859 0-7 3.141-7 7v1h17z"/>
                    </svg>
                </div>
                <h2 id="tituloLogin">Bienvenido de vuelta</h2>
                <p>Ingresa tus credenciales para continuar</p>
            </header>

            <form
                method="POST"
                action="{{ route('login.process') }}"
                aria-labelledby="tituloLogin"
                aria-label="Formulario de inicio de sesión"
                novalidate
            >
                @csrf

                @if ($errors->any())
                    <div class="alert-error" role="alert" aria-live="assertive">
                        <svg viewBox="0 0 24 24" aria-hidden="true" width="18" height="18" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="form-group">
                    <label for="usuario">
                        Usuario
                        <span aria-hidden="true" class="required-dot"></span>
                    </label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                        <input
                            id="usuario"
                            name="usuario"
                            type="text"
                            required
                            autocomplete="username"
                            aria-required="true"
                            aria-describedby="{{ $errors->has('usuario') ? 'usuario-error' : 'usuario-help' }}"
                            placeholder="Tu nombre de usuario"
                            aria-label="Usuario"
                            value="{{ old('usuario') }}"
                            class="{{ $errors->has('usuario') ? 'input-error' : '' }}"
                        >
                    </div>
                    @if ($errors->has('usuario'))
                        <span id="usuario-error" class="error-message" role="alert" aria-live="assertive">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            {{ $errors->first('usuario') }}
                        </span>
                    @else
                        <span id="usuario-help" class="sr-only">Ingresa el nombre de usuario asignado por el administrador</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">
                        Contraseña
                        <span aria-hidden="true" class="required-dot"></span>
                    </label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            aria-required="true"
                            aria-describedby="{{ $errors->has('password') ? 'password-error' : 'password-help' }}"
                            placeholder="Tu contraseña"
                            aria-label="Contraseña"
                            class="{{ $errors->has('password') ? 'input-error' : '' }}"
                        >
                        <button
                            type="button"
                            class="toggle-password"
                            aria-label="Mostrar u ocultar contraseña"
                            onclick="togglePassword()"
                        >
                            <svg id="eye-icon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                        </button>
                    </div>
                    @if ($errors->has('password'))
                        <span id="password-error" class="error-message" role="alert" aria-live="assertive">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            {{ $errors->first('password') }}
                        </span>
                    @else
                        <span id="password-help" class="sr-only">Ingresa tu contraseña de acceso al sistema</span>
                    @endif
                </div>

                <button type="submit" class="btn-submit" aria-label="Iniciar sesión en el sistema">
                    <span>Ingresar al sistema</span>
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </button>

            </form>

            <div class="form-footer">
                <a
                    href="{{ route('password.request') }}"
                    class="forgot-link"
                    aria-label="Recuperar contraseña olvidada"
                >
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

        </div>
    </main>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    const btn = document.querySelector('.toggle-password');
    
    if (input.type === 'password') {
        input.type = 'text';
        btn.setAttribute('aria-label', 'Ocultar contraseña');
        icon.innerHTML = '<path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>';
    } else {
        input.type = 'password';
        btn.setAttribute('aria-label', 'Mostrar contraseña');
        icon.innerHTML = '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>';
    }
}
</script>



</body>
</html>