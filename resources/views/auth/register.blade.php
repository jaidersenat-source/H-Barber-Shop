<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - H Barber Shop</title>
     <link rel="icon" type="image/png" href="/img/1.png">
    @vite(['resources/css/auth/register.css'])
    <style>
        .password-requirements { margin-top: 0.5rem; padding: .5rem; border-radius: 6px; background:#f8f9fb; font-size: .95rem }
        .password-requirements ul { list-style: none; padding: 0; margin: 0 }
        .password-requirements li { display:flex; gap:.5rem; align-items:center; padding:.15rem 0 }
        .password-requirements .icon { width:1.2rem; text-align:center; display:inline-block }
        .password-requirements .met { color: #16a34a }
        .password-requirements .unmet { color: #b91c1c }
        .password-requirements .sr-only { position: static; width: auto; height: auto; overflow: visible }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Sección de branding -->
        <aside class="branding-section" role="complementary" aria-label="Información de la marca" style="background-image: url('{{ asset('img/6.jpg') }}')">
            <div class="branding-content">
                <h1 class="logo-text" aria-label="H Barber Shop">H Barber Shop</h1>
                <p class="tagline">Únete a nuestro equipo profesional</p>
                
                <ul class="feature-list" aria-label="Características del sistema">
                    <li class="feature-item">
                        <svg class="feature-icon" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Gestión eficiente de turnos</span>
                    </li>
                    <li class="feature-item">
                        <svg class="feature-icon" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Control de clientes y servicios</span>
                    </li>
                    <li class="feature-item">
                        <svg class="feature-icon" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Reportes y estadísticas</span>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Sección del formulario -->
        <main class="form-section" role="main" aria-label="Formulario de registro">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Crear cuenta</h2>
                    <p class="form-subtitle">Complete el formulario para registrarse en el sistema</p>
                </div>

                @if ($errors->any())
                    <div class="error-message" role="alert" aria-live="polite">
                        <strong>Error:</strong> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" aria-label="Formulario de registro de usuario">
                    @csrf

                    <div class="form-group">
                        <label for="per_documento" class="form-label">
                            Documento de identidad
                            <span class="required" aria-label="Campo obligatorio">*</span>
                        </label>
                        <input 
                            id="per_documento" 
                            name="per_documento" 
                            type="text" 
                            class="form-input"
                            value="{{ request()->get('per_documento') ?? '' }}" 
                            required 
                            aria-required="true"
                            aria-describedby="documento-help"
                            placeholder="Ingrese su número de documento"
                        >
                        <span id="documento-help" class="sr-only">Ingrese su número de documento de identidad sin puntos ni guiones</span>
                    </div>

                    <div class="form-group">
                        <label for="usuario" class="form-label">
                            Nombre de usuario
                            <span class="required" aria-label="Campo obligatorio">*</span>
                        </label>
                        <input 
                            id="usuario" 
                            name="usuario" 
                            type="text" 
                            class="form-input"
                            required 
                            aria-required="true"
                            aria-describedby="usuario-help"
                            placeholder="Elija un nombre de usuario"
                        >
                        <span id="usuario-help" class="sr-only">Elija un nombre de usuario único para acceder al sistema</span>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            Contraseña
                            <span class="required" aria-label="Campo obligatorio">*</span>
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            class="form-input"
                            required 
                            aria-required="true"
                            aria-describedby="password-help"
                            placeholder="Cree una contraseña segura"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[!@#$%^&*()_+\\-={}:;<>.,?]).{8,}$"
                            title="Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo."
                        >
                        <span id="password-help" class="sr-only">Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.</span>

                        <div id="password-requirements" class="password-requirements" aria-live="polite">
                            <strong>Requisitos de la contraseña</strong>
                            <ul>
                                <li id="req-length" class="unmet" aria-checked="false" role="status"><span class="icon">✗</span><span>Al menos 8 caracteres</span></li>
                                <li id="req-lower" class="unmet" aria-checked="false" role="status"><span class="icon">✗</span><span>Una letra minúscula</span></li>
                                <li id="req-upper" class="unmet" aria-checked="false" role="status"><span class="icon">✗</span><span>Una letra mayúscula</span></li>
                                <li id="req-digit" class="unmet" aria-checked="false" role="status"><span class="icon">✗</span><span>Un número</span></li>
                                <li id="req-special" class="unmet" aria-checked="false" role="status"><span class="icon">✗</span><span>Un símbolo (ej. !@#$%)</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        @auth
                            <label for="rol" class="form-label">
                                Rol en el sistema
                                <span class="required" aria-label="Campo obligatorio">*</span>
                            </label>
                            <select 
                                id="rol" 
                                name="rol" 
                                class="form-select"
                                required 
                                aria-required="true"
                                aria-describedby="rol-help"
                            >
                                <option value="">Seleccione un rol</option>
                                <option value="barbero">Barbero</option>
                                <option value="admin">Administrador</option>
                            </select>
                            <span id="rol-help" class="sr-only">Seleccione el rol que tendrá el usuario en el sistema</span>
                        @else
                            <input type="hidden" name="rol" value="barbero">
                            <div class="role-display" role="status">
                                <span>Registrando como<strong>Barbero</strong></span>
                            </div>
                        @endauth
                    </div>

                    <button type="submit" class="submit-button" aria-label="Crear cuenta de usuario">
                        Crear cuenta
                    </button>
                </form>

                <div class="form-footer">
                    <p class="form-footer-text">
                        ¿Ya tiene una cuenta? 
                        <a href="{{ route('login') }}" class="form-footer-link">Iniciar sesión</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
    <script>
        (function(){
            var pwd = document.getElementById('password');
            if(!pwd) return;
            var btn = document.querySelector('button[type="submit"]');
            var reqs = [
                {id:'req-length', test: function(v){ return v.length >= 8 }},
                {id:'req-lower', test: function(v){ return /[a-z]/.test(v) }},
                {id:'req-upper', test: function(v){ return /[A-Z]/.test(v) }},
                {id:'req-digit', test: function(v){ return /\d/.test(v) }},
                {id:'req-special', test: function(v){ return /[^A-Za-z0-9]/.test(v) }}
            ];
            function update(){
                var v = pwd.value || '';
                var all = true;
                reqs.forEach(function(r){
                    var el = document.getElementById(r.id);
                    var ok = r.test(v);
                    if(ok){
                        el.classList.remove('unmet'); el.classList.add('met'); el.querySelector('.icon').textContent = '✓'; el.setAttribute('aria-checked','true');
                    } else {
                        el.classList.remove('met'); el.classList.add('unmet'); el.querySelector('.icon').textContent = '✗'; el.setAttribute('aria-checked','false');
                        all = false;
                    }
                });
                if(btn) btn.disabled = !all;
            }
            pwd.addEventListener('input', update);
            update();
        })();
    </script>
</body>
</html>
