@extends('admin.layout')

@section('title', 'Configuracion de Perfil')

@vite(['resources/css/Admin/config/config.css'])

@section('content')

<!-- Sección de Configuración del Sistema QR -->
<section class="system-config-section" aria-label="Configuración del sistema de pagos">
    <div class="system-header">
        <div class="system-icon-wrapper">
            <span class="system-icon">⚙️</span>
        </div>
        <div class="system-header-content">
            <h2>Configuración del Sistema</h2>
            <p>Gestiona las configuraciones avanzadas de tu barbería</p>
        </div>
    </div>

    <div class="config-grid">
        
        <!-- QR Codes para Pagos -->
        <div class="config-card" onclick="window.location.href='{{ route('admin.qr.management') }}'">
            <div class="config-card-header">
                <div class="config-icon-wrapper qr">
                    <span class="config-icon">📱</span>
                </div>
                <h3>Implementar QR de Pagos</h3>
            </div>
            <p class="config-card-description">
                Configura los códigos QR reales de Nequi, DaviPlata y Bancolombia para que los clientes puedan pagar el anticipo de 10000 pesos de forma rápida y segura.
            </p>
            <div class="config-badges">
                @if(file_exists(public_path('img/qr/nequi-qr.png')))
                    <span class="badge active">✅ Nequi QR Activo</span>
                @else
                    <span class="badge inactive">⚠️ Sin Nequi QR</span>
                @endif
                
                @if(file_exists(public_path('img/qr/daviplata-qr.png')))
                    <span class="badge active">✅ DaviPlata QR Activo</span>
                @else
                    <span class="badge inactive">⚠️ Sin DaviPlata QR</span>
                @endif

                @if(file_exists(public_path('img/qr/bancolombia-qr.png')))
                    <span class="badge active">✅ Bancolombia QR Activo</span>
                @else
                    <span class="badge inactive">⚠️ Sin Bancolombia QR</span>
                @endif
            </div>
            <div class="config-card-footer">
                <span class="config-nav-arrow qr">Configurar QRs →</span>
            </div>
        </div>

        <!-- Redes Sociales y Contacto -->
        <div class="config-card" onclick="window.location.href='{{ route('admin.configuraciones.generales') }}'">
            <div class="config-card-header">
                <div class="config-icon-wrapper social">
                    <span class="config-icon">📱</span>
                </div>
                <h3>Redes Sociales y WhatsApp</h3>
            </div>
            <p class="config-card-description">
                Configura los enlaces de Instagram, Facebook, TikTok, YouTube y el número de WhatsApp para el sitio web.
            </p>
            <div class="config-badges">
                @if(config('site.redes_sociales.instagram'))
                    <span class="badge active">✅ Instagram</span>
                @else
                    <span class="badge inactive">⚠️ Sin Instagram</span>
                @endif
                
                @if(config('site.redes_sociales.facebook'))
                    <span class="badge active">✅ Facebook</span>
                @else
                    <span class="badge inactive">⚠️ Sin Facebook</span>
                @endif
                
                @if(config('site.contacto.whatsapp'))
                    <span class="badge active">✅ WhatsApp</span>
                @else
                    <span class="badge inactive">⚠️ Sin WhatsApp</span>
                @endif
            </div>
            <div class="config-card-footer">
                <span class="config-nav-arrow social">Configurar →</span>
            </div>
        </div>

        <!-- Configuraciones de Información Personal -->
        <div class="config-card" onclick="window.location.href='{{ route('admin.perfil.informacion') }}'">
            <div class="config-card-header">
                <div class="config-icon-wrapper profile">
                    <span class="config-icon">👤</span>
                </div>
                <h3>Información Personal</h3>
            </div>
            <p class="config-card-description">
                Actualiza tu información personal, cambia tu contraseña y gestiona la configuración de tu cuenta de administrador.
            </p>
            <div class="config-badges">
                <span class="badge feature password">🔒 Cambiar Contraseña</span>
                <span class="badge feature profile">📝 Editar Perfil</span>
            </div>
            <div class="config-card-footer">
                <span class="config-nav-arrow profile">Configurar Perfil →</span>
            </div>
        </div>

        <!-- Manual de Usuario Accesible -->
        <div class="config-card" onclick="window.location.href='{{ route('admin.manual.usuario') }}'">
            <div class="config-card-header">
                <div class="config-icon-wrapper profile">
                    <span class="config-icon">📖</span>
                </div>
                <h3>Manual de Usuario</h3>
            </div>
            <p class="config-card-description">
                Consulta el manual de usuario del sistema. Está diseñado para ser completamente accesible, compatible con lectores de pantalla e incluye lectura en voz alta.
            </p>
            <div class="config-badges">
                <span class="badge feature">♿ Accesible</span>
                <span class="badge feature">🔊 Lectura en voz alta</span>
            </div>
            <div class="config-card-footer">
                <span class="config-nav-arrow profile">Ver Manual →</span>
            </div>
        </div>

    </div>
</section>

{{-- Anuncio para lectores de pantalla --}}
<div id="sr-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

<script>
window.turnosAvailableRoute = "{{ route('turnos.available') }}";
window.turnosStoreRoute = "{{ route('turnos.store') }}";
</script>

@vite(['resources/js/Admin/perfil.js'])
@endsection