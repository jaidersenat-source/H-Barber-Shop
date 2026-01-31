<!DOCTYPE html>
<html lang="es">
<head>
    <!DOCTYPE html>
    <html lang="es">
    <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inicio de Sesión | H Barber Shop</title>
            @vite(['resources/css/auth/login.css'])
             <link rel="icon" type="image/png" href="/img/1.png">
    </head>

    <body>
            <div class="login-container">
                
                    <!-- Sección de branding con accesibilidad -->
                                        <aside class="brand-section" aria-label="Información de la marca" style="position:relative; display:flex; align-items:center; justify-content:center; min-height:100%;">
                                                <!-- Video de fondo -->
                                                <video 
                                                        class="bg-video" 
                                                        autoplay 
                                                        muted 
                                                        loop 
                                                        playsinline 
                                                        aria-hidden="true"
                                                        style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; z-index:1;"
                                                >
                                                        <source src="{{ asset('video/1.mp4') }}" type="video/mp4">
                                                </video>
                                                <!-- Overlay oscuro -->
                                                <div class="video-overlay" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(40,12,30,0.65); z-index:2;"></div>
                                                <!-- Contenido centrado -->
                                                <div class="brand-content" style="position:relative; z-index:3; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; width:100%;">
                                                        <div class="brand-logo" aria-hidden="true" style="width:110px; height:110px; background:rgba(255,255,255,0.18); border-radius:20px; display:flex; align-items:center; justify-content:center; margin-bottom:2rem; border:2.5px solid rgba(255,255,255,0.25); backdrop-filter:blur(12px);">
                                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:60px; height:60px; fill:white;">
                                                                        <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm6 10v8H6v-8h12zm-9-5c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7z"/>
                                                                </svg>
                                                        </div>
                                                        <h1 style="font-size:2.2rem; font-weight:800; color:#fff; margin-bottom:0.7rem; letter-spacing:-1px; text-shadow:0 2px 12px rgba(0,0,0,0.25);">H Barber Shop</h1>
                                                        <p style="font-size:1.05rem; color:rgba(255,255,255,0.97); line-height:1.5; max-width:320px; text-shadow:0 1px 8px rgba(0,0,0,0.18);">Sistema de gestión profesional para barbería. Accede a tu cuenta para gestionar turnos, clientes y más.</p>
                                                </div>
                                        </aside>

                    <!-- Sección del formulario con ARIA completo -->
                    <main class="form-section">
                            <div class="login-box">
                                    <header class="login-header">
                                            <h2 id="tituloLogin">Inicio de sesión</h2>
                                            <p>Ingresa tus credenciales para acceder al sistema</p>
                                    </header>

                                    @if ($errors->has('login'))
                                            <div class="alert-error" role="alert" aria-live="assertive">
                                                    <span>{{ $errors->first('login') }}</span>
                                            </div>
                                    @endif

                                    <form method="POST" action="{{ route('login.process') }}" aria-labelledby="tituloLogin">
                                            @csrf

                                            <div class="form-group">
                                                    <label for="usuario">
                                                            Usuario
                                                            <span class="sr-only">(requerido)</span>
                                                    </label>
                                                    <input 
                                                            id="usuario" 
                                                            name="usuario" 
                                                            type="text" 
                                                            required 
                                                            autocomplete="username"
                                                            aria-required="true"
                                                            aria-describedby="usuario-help"
                                                            placeholder="Ingresa tu usuario"
                                                    >
                                                    <span id="usuario-help" class="sr-only">Ingresa el nombre de usuario asignado por el administrador</span>
                                            </div>

                                            <div class="form-group">
                                                    <label for="password">
                                                            Contraseña
                                                            <span class="sr-only">(requerido)</span>
                                                    </label>
                                                    <input 
                                                            id="password" 
                                                            name="password" 
                                                            type="password" 
                                                            required 
                                                            autocomplete="current-password"
                                                            aria-required="true"
                                                            aria-describedby="password-help"
                                                            placeholder="Ingresa tu contraseña"
                                                    >
                                                    <span id="password-help" class="sr-only">Ingresa tu contraseña de acceso al sistema</span>
                                            </div>

                                            <button type="submit" class="btn-primary" aria-label="Iniciar sesión en el sistema">
                                                    Ingresar
                                            </button>
                                    </form>

                                    <div class="divider" aria-hidden="true">
                                            <span>O</span>
                                    </div>

                                    <nav class="form-links" aria-label="Enlaces adicionales">
                                            <a href="{{ route('register.form') }}" class="btn-link btn-secondary" aria-label="Ir a la página de registro">
                                                    Crear cuenta nueva
                                            </a>
                                            <a href="{{ route('password.request') }}" class="btn-link btn-text" aria-label="Recuperar contraseña olvidada">
                                                    ¿Olvidaste tu contraseña?
                                            </a>
                                    </nav>
                            </div>
                    </main>
            </div>
    </body>
    </html>
                       