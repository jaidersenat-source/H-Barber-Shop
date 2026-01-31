<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | H Barber Shop SAS</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@vite(['resources/css/Home/Contacto.css'])
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-logo">
                <a href="index.html" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <text x="20" y="28" font-family="Playfair Display" font-size="32" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                    </svg>
                    <span class="logo-text">H BARBER SHOP</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="{{ route('welcome') }}">Inicio</a>
                <a href="{{ route('servicios') }}">Servicios</a>
                <a href="{{ route('productos') }}">Productos</a>
                <a href="{{ route('nosotros') }}">Nosotros</a>
                <a href="{{ route('contacto') }}" class="active">Contacto</a>
                <a href="{{ route('fidelizacion') }}">Fidelizacion</a>
            </div>
       
            <div class="nav-buttons">
                <a href="{{ route('agendar') }}">
                <button class="btn-primary">Agendar Cita</button>
                </a>
            <a href="/login" class="nav-login" title="Acceso Staff">
                <i class="fas fa-user-lock"></i>
            </a>
            
            <button class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="page-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-badge">Estamos para ti</span>
            <h1 class="hero-title">Contacto</h1>
            <p class="hero-subtitle">Estamos aqui para atenderte. Visitanos, llamanos o escribenos.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                
                <!-- Contact Info -->
                <div class="contact-info">
                    <h2 class="section-title-sm">Informacion de Contacto</h2>
                    <p class="contact-intro">Ven a visitarnos o contactanos por cualquiera de nuestros canales. Estaremos encantados de atenderte.</p>
                    
                    <div class="contact-cards">
                        <!-- Ubicacion -->
                        <div class="contact-card">
                            <div class="contact-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Ubicacion</h3>
                                <p>Calle Principal #123</p>
                                <p>Centro Comercial Premium, Local 45</p>
                                <p>Bogota, Colombia</p>
                            </div>
                        </div>

                        <!-- Telefono -->
                        <div class="contact-card">
                            <div class="contact-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Telefono</h3>
                                <p><a href="tel:+573001234567">+57 300 123 4567</a></p>
                                <p><a href="tel:+5716012345">+57 (1) 601 2345</a></p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="contact-card">
                            <div class="contact-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Email</h3>
                                <p><a href="mailto:info@hbarbershop.com">info@hbarbershop.com</a></p>
                                <p><a href="mailto:reservas@hbarbershop.com">reservas@hbarbershop.com</a></p>
                            </div>
                        </div>

                        <!-- Horarios -->
                        <div class="contact-card">
                            <div class="contact-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div class="contact-card-content">
                                <h3>Horarios</h3>
                                <p>Lunes - Viernes: 9:00 AM - 8:00 PM</p>
                                <p>Sabados: 9:00 AM - 6:00 PM</p>
                                <p>Domingos: 10:00 AM - 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="social-section">
                        <h3>Siguenos</h3>
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link" aria-label="WhatsApp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-link" aria-label="TikTok">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2 class="section-title-sm">Enviar Mensaje</h2>
                    <p class="form-intro">Tienes alguna pregunta o deseas agendar una cita? Escribenos y te responderemos lo antes posible.</p>
                    
                    <form class="contact-form" id="contactForm">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required placeholder="tu@email.com">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="tel" id="telefono" name="telefono" placeholder="+57 300 000 0000">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <select id="asunto" name="asunto" required>
                                <option value="">Selecciona un asunto</option>
                                <option value="reserva">Reservar Cita</option>
                                <option value="informacion">Informacion General</option>
                                <option value="productos">Consulta de Productos</option>
                                <option value="sugerencia">Sugerencia</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="5" required placeholder="Escribe tu mensaje aqui..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary btn-submit">
                            <span>Enviar Mensaje</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    <section class="map-section">
        <div class="container">
            <h2 class="section-title">Encuentranos</h2>
            <p class="section-subtitle">Visitanos en nuestra ubicacion</p>
            <div class="map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8527096917527!2d-74.06331492536522!3d4.628674942206889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f99a7ebf0a0a1%3A0x3c7e1f1c0f5e1d0a!2sBogot%C3%A1%2C%20Colombia!5e0!3m2!1ses!2sco!4v1699999999999!5m2!1ses!2sco" 
                    width="100%" 
                    height="450" 
                    style="border:0; border-radius: 12px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <span class="logo-text">H</span>
                        <span class="logo-subtext">BARBER SHOP</span>
                    </div>
                    <p>La experiencia premium en barberia que mereces. Estilo, precision y elegancia en cada corte.</p>
                </div>
                <div class="footer-links">
                    <h4>Enlaces</h4>
                    <a href="index.html">Inicio</a>
                    <a href="servicios.html">Servicios</a>
                    <a href="productos.html">Productos</a>
                    <a href="nosotros.html">Nosotros</a>
                    <a href="contacto.html">Contacto</a>
                </div>
                <div class="footer-contact">
                    <h4>Contacto</h4>
                    <p>Calle Principal #123, Bogota</p>
                    <p>+57 300 123 4567</p>
                    <p>info@hbarbershop.com</p>
                </div>
                <div class="footer-hours">
                    <h4>Horarios</h4>
                    <p>Lun - Vie: 9:00 AM - 8:00 PM</p>
                    <p>Sabados: 9:00 AM - 6:00 PM</p>
                    <p>Domingos: 10:00 AM - 4:00 PM</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 H Barber Shop SAS. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('.btn-submit');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<span>Enviando...</span>';
            btn.disabled = true;
            
            // Simular envio
            setTimeout(() => {
                btn.innerHTML = '<span>Mensaje Enviado</span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                btn.style.background = 'linear-gradient(135deg, #2d5a3d 0%, #1a3d2a 100%)';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    btn.style.background = '';
                    this.reset();
                }, 3000);
            }, 1500);
        });
    </script>
</body>
</html>
