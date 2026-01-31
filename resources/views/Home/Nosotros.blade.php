<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - H Barber Shop SAS</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@vite(['resources/css/Home/Nosotros.css'])
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
                <a href="{{ route('nosotros') }}" class="active">Nosotros</a>
                <a href="{{ route('contacto') }}">Contacto</a>
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
            <h1 class="hero-title">Nuestra Historia</h1>
            <p class="hero-subtitle">Mas que una barberia, una experiencia de estilo y tradicion</p>
        </div>
    </section>

    <!-- Nuestra Historia -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <span class="section-badge">Desde 2015</span>
                    <h2 class="section-title">Quienes Somos</h2>
                    <p class="about-text">
                        <strong>H Barber Shop SAS</strong> nacio de la pasion por el arte de la barberia y el deseo de ofrecer 
                        una experiencia unica a cada cliente. Fundada en 2015, hemos crecido hasta convertirnos en 
                        un referente de estilo y calidad en nuestra comunidad.
                    </p>
                    <p class="about-text">
                        Nuestro equipo esta conformado por barberos profesionales altamente capacitados, 
                        comprometidos con la excelencia y la satisfaccion del cliente. Cada corte, cada 
                        afeitado, es una obra de arte personalizada.
                    </p>
                    <p class="about-text">
                        Creemos que visitar la barberia debe ser mas que un simple corte de cabello. 
                        Es un momento para relajarse, desconectar y salir sintiendose renovado y con confianza.
                    </p>
                </div>
                <div class="about-image">
                    <div class="image-frame">
                        <div class="image-placeholder">
                            <i class="fas fa-store"></i>
                            <span>H Barber Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mision, Vision, Valores -->
    <section class="values-section">
        <div class="container">
            <div class="values-grid">
                <!-- Mision -->
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="value-title">Mision</h3>
                    <p class="value-text">
                        Brindar servicios de barberia de la mas alta calidad, combinando tecnicas tradicionales 
                        con tendencias modernas, en un ambiente acogedor y profesional que supere las expectativas 
                        de nuestros clientes.
                    </p>
                </div>

                <!-- Vision -->
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="value-title">Vision</h3>
                    <p class="value-text">
                        Ser reconocidos como la barberia lider en innovacion y calidad, expandiendo nuestra 
                        presencia y manteniendo los mas altos estandares de servicio, formando barberos 
                        de excelencia.
                    </p>
                </div>

                <!-- Valores -->
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3 class="value-title">Valores</h3>
                    <p class="value-text">
                        Excelencia en cada detalle, respeto por nuestros clientes y equipo, innovacion constante, 
                        compromiso con la calidad, honestidad y pasion por nuestro oficio.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestro Equipo -->
    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Profesionales</span>
                <h2 class="section-title">Nuestro Equipo</h2>
                <p class="section-subtitle">Conoce a los expertos detras de cada corte perfecto</p>
            </div>

            <div class="team-grid">
                <!-- Barbero 1 -->
                <div class="team-card">
                    <div class="team-image">
                        <div class="image-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="team-social">
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Carlos Hernandez</h3>
                        <span class="team-role">Fundador & Master Barber</span>
                        <p class="team-bio">
                            Con mas de 15 anos de experiencia, Carlos es el alma de H Barber Shop. 
                            Especialista en cortes clasicos y fades de precision.
                        </p>
                        <div class="team-specialties">
                            <span class="specialty-tag">Fades</span>
                            <span class="specialty-tag">Clasicos</span>
                            <span class="specialty-tag">Disenos</span>
                        </div>
                    </div>
                </div>

                <!-- Barbero 2 -->
                <div class="team-card">
                    <div class="team-image">
                        <div class="image-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="team-social">
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Miguel Torres</h3>
                        <span class="team-role">Senior Barber</span>
                        <p class="team-bio">
                            Experto en tendencias modernas y tecnicas de coloracion. 
                            Miguel transforma tu estilo con creatividad y precision.
                        </p>
                        <div class="team-specialties">
                            <span class="specialty-tag">Coloracion</span>
                            <span class="specialty-tag">Moderno</span>
                            <span class="specialty-tag">Texturas</span>
                        </div>
                    </div>
                </div>

                <!-- Barbero 3 -->
                <div class="team-card">
                    <div class="team-image">
                        <div class="image-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="team-social">
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Andres Lopez</h3>
                        <span class="team-role">Barber & Beard Specialist</span>
                        <p class="team-bio">
                            Maestro del afeitado clasico con navaja. Andres es el especialista 
                            en cuidado y diseno de barba con atencion al detalle.
                        </p>
                        <div class="team-specialties">
                            <span class="specialty-tag">Barba</span>
                            <span class="specialty-tag">Navaja</span>
                            <span class="specialty-tag">Clasico</span>
                        </div>
                    </div>
                </div>

                <!-- Barbero 4 -->
                <div class="team-card">
                    <div class="team-image">
                        <div class="image-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="team-social">
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Sebastian Rios</h3>
                        <span class="team-role">Junior Barber</span>
                        <p class="team-bio">
                            Talento joven con gran pasion por la barberia. Sebastian combina 
                            energia fresca con tecnicas solidas aprendidas de los maestros.
                        </p>
                        <div class="team-specialties">
                            <span class="specialty-tag">Juvenil</span>
                            <span class="specialty-tag">Fades</span>
                            <span class="specialty-tag">Tendencias</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadisticas -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number" data-count="10">10+</div>
                    <div class="stat-label">Anos de Experiencia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="15000">15,000+</div>
                    <div class="stat-label">Clientes Satisfechos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="4">4</div>
                    <div class="stat-label">Barberos Expertos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="50000">50,000+</div>
                    <div class="stat-label">Cortes Realizados</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Por que Elegirnos -->
    <section class="why-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Diferencia</span>
                <h2 class="section-title">Por Que Elegirnos</h2>
                <p class="section-subtitle">Lo que nos hace unicos en cada visita</p>
            </div>

            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="why-title">Calidad Garantizada</h3>
                    <p class="why-text">
                        Utilizamos productos premium y tecnicas profesionales para asegurar 
                        resultados excepcionales en cada servicio.
                    </p>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="why-title">Puntualidad</h3>
                    <p class="why-text">
                        Respetamos tu tiempo. Sistema de citas organizado para minimizar 
                        la espera y maximizar tu experiencia.
                    </p>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="why-title">Higiene Impecable</h3>
                    <p class="why-text">
                        Protocolos estrictos de limpieza y desinfeccion. Tu salud y 
                        seguridad son nuestra prioridad.
                    </p>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h3 class="why-title">Ambiente Premium</h3>
                    <p class="why-text">
                        Espacio disenado para tu comodidad con ambiente masculino, 
                        moderno y relajante.
                    </p>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="why-title">Formacion Continua</h3>
                    <p class="why-text">
                        Nuestro equipo se capacita constantemente en las ultimas 
                        tendencias y tecnicas de barberia mundial.
                    </p>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="why-title">Atencion Personalizada</h3>
                    <p class="why-text">
                        Cada cliente es unico. Escuchamos tus preferencias y 
                        asesoramos para lograr tu mejor version.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Opiniones</span>
                <h2 class="section-title">Lo Que Dicen Nuestros Clientes</h2>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "La mejor barberia de la ciudad sin duda. El ambiente es increible y 
                        los barberos son verdaderos profesionales. Siempre salgo satisfecho."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <span class="author-name">Juan Perez</span>
                            <span class="author-time">Cliente hace 3 anos</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Encontre mi barberia de por vida. La atencion es de primera, 
                        los productos que usan son excelentes y el resultado siempre supera mis expectativas."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <span class="author-name">Roberto Garcia</span>
                            <span class="author-time">Cliente hace 2 anos</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "El afeitado con navaja es una experiencia unica. Andres es un maestro 
                        en lo que hace. El programa de fidelidad es un gran plus."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <span class="author-name">David Martinez</span>
                            <span class="author-time">Cliente hace 1 ano</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Forma Parte de la Experiencia H Barber Shop</h2>
                <p class="cta-text">
                    Reserva tu cita hoy y descubre por que miles de clientes confian en nosotros 
                    para lucir su mejor version.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('servicios') }}" class="btn btn-primary">
                        <i class="fas fa-cut"></i>
                        Ver Servicios
                    </a>
                    <a href="{{ route('agendar') }}" class="btn btn-secondary">
                        <i class="fas fa-calendar-alt"></i>
                        Reservar Cita
                    </a>
                </div>
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
                    <p class="footer-description">
                        Tu destino para el cuidado masculino de primera clase. 
                        Tradicion, estilo y excelencia desde 2015.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <div class="footer-links">
                    <h4 class="footer-title">Enlaces</h4>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="servicios.html">Servicios</a></li>
                        <li><a href="productos.html">Productos</a></li>
                        <li><a href="nosotros.html">Nosotros</a></li>
                        <li><a href="contacto.html">Contacto</a></li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h4 class="footer-title">Contacto</h4>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Calle Principal #123, Ciudad</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+57 300 123 4567</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>info@hbarbershop.com</span>
                        </li>
                    </ul>
                </div>

                <div class="footer-hours">
                    <h4 class="footer-title">Horario</h4>
                    <ul>
                        <li>
                            <span>Lunes - Viernes</span>
                            <span>9:00 AM - 8:00 PM</span>
                        </li>
                        <li>
                            <span>Sabados</span>
                            <span>8:00 AM - 6:00 PM</span>
                        </li>
                        <li>
                            <span>Domingos</span>
                            <span>9:00 AM - 2:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 H Barber Shop SAS. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
