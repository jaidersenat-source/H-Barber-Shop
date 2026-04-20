@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | H Barber Shop SAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@vite(['resources/css/Home/Contacto.css'])
<style>
/* ── Consent toggle ──────────────────────────────────── */
.contacto-consent-label {
    display: flex;
    align-items: flex-start;
    gap: .55rem;
    cursor: pointer;
    font-weight: normal;
    color: #ccc;
    font-size: .88rem;
    line-height: 1.4;
}
.contacto-consent-cb {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
}
/* La caja visual del checkbox */
.contacto-consent-box {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    border-radius: 5px;
    border: 2px solid #6b7280;
    background: transparent;
    margin-top: 1px;
    transition: border-color .15s, background .15s, box-shadow .15s;
    position: relative;
    display: inline-block;
}
/* Tick via pseudo-elemento */
.contacto-consent-box::after {
    content: '';
    position: absolute;
    display: none;
    left: 3px;
    top: 0px;
    width: 5px;
    height: 10px;
    border: 2px solid #fff;
    border-top: none;
    border-left: none;
    transform: rotate(45deg);
}
/* Estado: presionado / checked */
.contacto-consent-box.is-checked {
    background: #DC2626;
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,.2);
}
.contacto-consent-box.is-checked::after { display: block; }
/* Hover sobre el label */
.contacto-consent-label:hover .contacto-consent-box {
    border-color: #DC2626;
}
/* Foco accesible */
.contacto-consent-cb:focus + .contacto-consent-box {
    outline: 2px solid #D4AF37;
    outline-offset: 2px;
}
.contacto-consent-text a {
    color: #D4AF37;
    text-decoration: underline;
}
.contacto-consent-error {
    color: #fca5a5;
    font-size: .84rem;
    margin-top: .35rem;
    display: flex;
    align-items: center;
    gap: .3rem;
}
.contacto-consent-error::before { content: '⚠ '; }
.contacto-consent-hint {
    color: #6b7280;
    display: block;
    margin-top: .3rem;
    font-size: .82rem;
}
</style>
<body>
    <!-- Skip Link -->
    <a href="#contacto-content" class="skip-link" style="position:absolute;top:-40px;left:0;background:#D4AF37;color:#000;padding:8px;text-decoration:none;z-index:9999;font-weight:bold;" onfocus="this.style.top='0'" onblur="this.style.top='-40px'">Saltar al contenido principal</a>
   
    <!-- Hero Section -->
    <section class="page-hero" role="banner" aria-label="Encabezado de la página de contacto" style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('img/10.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-content">
            <span class="hero-badge">Estamos para ti</span>
            <h1 class="hero-title">Contacto</h1>
            <p class="hero-subtitle">Estamos aquí para atenderte. Visítanos, llámanos o escríbenos.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <main id="contacto-content">
    <section class="contact-section" role="region" aria-label="Información de contacto y formulario">
        <div class="container">
            <div class="contact-grid">
                
                <!-- Contact Info -->
                <div class="contact-info">
                    <h2 class="section-title-sm">Información de Contacto</h2>
                    <p class="contact-intro">Ven a visitarnos o contáctanos por cualquiera de nuestros canales. Estaremos encantados de atenderte.</p>
                    
                    <div class="contact-cards" role="list" aria-label="Canales de contacto">
                        <!-- Ubicacion -->
                        <div class="contact-card" role="listitem">
                            <div class="contact-card-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Ubicación</h3>
                                <p>Calle 50 #21A-05</p>
                                <p>Neiva, Colombia</p>
                            </div>
                        </div>

                        <!-- Telefono -->
                        <div class="contact-card" role="listitem">
                            <div class="contact-card-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Teléfono</h3>
                                <p><a href="tel:+573118104544" aria-label="Llamar al teléfono +57 311 810 4544">+57 311 810 4544</a></p>
                                <p><a href="tel:+573118104544" aria-label="Llamar al teléfono +57 311 810 4544">+57 311 810 4544</a></p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="contact-card" role="listitem">
                            <div class="contact-card-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Email</h3>
                                <p><a href="mailto:hbarbershopsas@gmail.com" aria-label="Enviar correo a hbarbershopsas@gmail.com"> hbarbershopsas@gmail.com</a></p>
                                <p><a href="mailto:hbarbershopsas@gmail.com" aria-label="Enviar correo a hbarbershopsas@gmail.com"> hbarbershopsas@gmail.com</a></p>
                            </div>
                        </div>

                        <!-- Horarios -->
                        <div class="contact-card" role="listitem">
                            <div class="contact-card-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Horarios</h3>
                                <p>Lunes - Viernes: 9:00 AM - 8:30 PM</p>
                                <p>Sabados: 9:00 AM - 8:30 PM</p>
                                <p>Domingos: Cerrado</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="social-section">
                        <h3>Síguenos</h3>
                        <div class="social-links" role="group" aria-label="Redes sociales">
                            @if(config('site.redes_sociales.instagram'))
                    <a href="{{ config('site.redes_sociales.instagram') }}" class="social-link" aria-label="Instagram" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                                </svg>
                            </a>
                    @endif
                             @if(config('site.redes_sociales.facebook'))
                     <a href="{{ config('site.redes_sociales.facebook') }}" class="social-link" aria-label="Facebook" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                                </svg>
                            </a>
                    @endif
                            @if(config('site.contacto.whatsapp'))
                     <a href="https://wa.me/{{ config('site.contacto.whatsapp') }}" class="social-link" aria-label="WhatsApp" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                    @endif
                             @if(config('site.redes_sociales.tiktok'))
                    <a href="{{ config('site.redes_sociales.tiktok') }}" class="social-link" aria-label="TikTok" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                    @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2 class="section-title-sm">Enviar Mensaje</h2>
                    <p class="form-intro">Tienes alguna pregunta o deseas agendar una cita? Escríbenos y te responderemos lo antes posible.</p>

                    @if(session('ok'))
                        <div style="background-color: #2d5a3d; color: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #10b981;">
                            <strong>✓ {{ session('ok') }}</strong>
                        </div>
                    @endif

                    <form class="contact-form" id="contactForm" method="POST" action="{{ route('contacto.enviar') }}" aria-label="Formulario de contacto">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre Completo <span aria-hidden="true">*</span></label>
                            <input type="text" id="nombre" name="nombre" required aria-required="true" placeholder="Tu nombre">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email <span aria-hidden="true">*</span></label>
                                <input type="email" id="email" name="email" required aria-required="true"
                                       placeholder="tu@correo.com"
                                       pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                                       title="Ingresa un correo válido, ej: nombre@dominio.com">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" placeholder="300 000 0000"
                                       inputmode="numeric" maxlength="10" pattern="[0-9]{7,10}"
                                       oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                       title="Solo números, entre 7 y 10 dígitos">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="asunto">Asunto <span aria-hidden="true">*</span></label>
                            <select id="asunto" name="asunto" required aria-required="true">
                                <option value="">Selecciona un asunto</option>
                                <option value="reserva">Reservar Cita</option>
                                <option value="informacion">Información General</option>
                                <option value="productos">Consulta de Productos</option>
                                <option value="sugerencia">Sugerencia</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="mensaje">Mensaje <span aria-hidden="true">*</span></label>
                            <textarea id="mensaje" name="mensaje" rows="5" required aria-required="true" placeholder="Escribe tu mensaje aquí..."></textarea>
                        </div>

                        <!-- Consentimiento de datos — Ley 1581 de 2012 (obligatorio) -->
                        <div class="form-group contacto-consent-wrap" style="margin-top:.75rem;">
                            <label class="contacto-consent-label" for="contacto-accept-terms">
                                <input type="checkbox" id="contacto-accept-terms" name="accept_terms"
                                       aria-required="true" required
                                       class="contacto-consent-cb">
                                <span class="contacto-consent-box" aria-hidden="true"></span>
                                <span class="contacto-consent-text">
                                    He leído y acepto la
                                    <a href="{{ route('politicas') }}#datos-personales" target="_blank" rel="noopener">
                                        Política de Tratamiento de Datos Personales
                                    </a>
                                    de H Barber Shop SAS (Ley 1581 de 2012).
                                </span>
                            </label>
                            <p id="contactConsentError" class="contacto-consent-error" role="alert" style="display:none;">
                                Debes aceptar la política para poder enviar el formulario.
                            </p>
                            <small class="contacto-consent-hint">
                                Tus datos serán tratados exclusivamente para responder tu consulta.
                            </small>
                        </div>

                        <button type="submit" class="btn-primary btn-submit" id="btnContacto" aria-label="Enviar el mensaje de contacto">
                            <span id="btnContactoText">Enviar Mensaje</span>
                            <svg id="btnContactoIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"/>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
<section class="map-section" role="region" aria-label="Ubicación en el mapa">
    <div class="container">
        <h2 class="section-title">Encuéntranos</h2>
        <p class="section-subtitle">Visítanos en nuestra ubicación</p>
        
        @forelse($sedes as $sede)
        <div class="map-wrapper">
            <h3>{{ $sede->sede_nombre ?? 'Sede' }}</h3>
            <iframe 
                src="{{ $sede->map_url }}" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Mapa de ubicación de {{ $sede->sede_nombre ?? 'la sede' }}"
                aria-label="Mapa mostrando la ubicación de {{ $sede->sede_nombre ?? 'la sede' }}">
            </iframe>
            <p>{{ $sede->sede_direccion }}</p>
        </div>
        @empty
            <p style="color: #fff; text-align: center;">No hay sedes registradas.</p>
        @endforelse
    </div>
</section>
    </main>

</body>
 
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const btn = document.getElementById('btnContacto');
    const btnText = document.getElementById('btnContactoText');
    const btnIcon = document.getElementById('btnContactoIcon');

    const consentCb = document.getElementById('contacto-accept-terms');
    const consentBox = document.querySelector('.contacto-consent-box');
    const consentError = document.getElementById('contactConsentError');

    // Sincronizar apariencia visual del toggle
    function updateConsentVisual() {
        if (!consentBox) return;
        if (consentCb && consentCb.checked) {
            consentBox.classList.add('is-checked');
        } else {
            consentBox.classList.remove('is-checked');
        }
    }
    if (consentCb) {
        consentCb.addEventListener('change', function () {
            updateConsentVisual();
            if (consentCb.checked && consentError) consentError.style.display = 'none';
        });
        updateConsentVisual();
    }

    if (form && btn) {
        form.addEventListener('submit', function (e) {
            // Validar consentimiento antes de enviar
            if (consentCb && !consentCb.checked) {
                e.preventDefault();
                if (consentError) consentError.style.display = 'block';
                consentCb.focus();
                return false;
            }
            // Animación de envío
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'not-allowed';
            btnText.textContent = 'Enviando...';
            btnIcon.innerHTML = '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="31.4" stroke-dashoffset="10"><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="0.8s" repeatCount="indefinite"/></circle>';
        });
    }
});
</script>
@endpush