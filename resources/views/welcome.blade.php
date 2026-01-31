<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H Barber Shop SAS - Estilo, Precisión y Experiencia Premium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>
    @vite(['resources/css/Home/inicio.css'])
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-logo">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <text x="20" y="28" font-family="Playfair Display" font-size="32" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                </svg>
                <span class="logo-text">H BARBER SHOP</span>
            </div>
            <div class="nav-links">
                <a href="{{ route('welcome') }}">Inicio</a>
                <a href="{{ route('servicios') }}">Servicios</a>
                <a href="{{ route('productos') }}">Productos</a>
                <a href="{{ route('nosotros') }}">Nosotros</a>
                <a href="{{ route('contacto') }}">Contacto</a>
                <a href="{{ route('fidelizacion') }}">Fidelizacion</a>
        
            </div>
            <div class="nav-buttons">
                <a href="{{ route('agendar') }}">
            <button class="btn-primary">Agendar Cita</button>
            </a>
            <a href="/login" class="nav-login" title="Acceso de Usuario">
                <i class="fas fa-user-lock"></i>
            </a>



            <button class="mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        </div>
    </nav>

    <!-- Hero Section -->
   <section class="hero">
    <!-- Video de fondo -->
    <video id="hero-video" autoplay muted loop playsinline>
    <source src="{{ asset('video/4.mp4') }}" type="video/mp4">
</video>

    
    <div class="hero-overlay"></div>
    <!-- Overlay oscuro sobre el video -->
    <div class="video-overlay"></div>
    
    <!-- Canvas para partículas decorativas (opcional) -->
    <canvas id="particles-canvas"></canvas>
    
    <div class="hero-content">
        <h1 class="hero-title">Estilo, Precisión y Experiencia Premium</h1>
        <p class="hero-subtitle">El arte de la barbería llevado a su máxima expresión</p>
        <div class="hero-buttons">
            <a href="{{ route('agendar') }}">
            <button class="btn-3d btn-primary-3d">Agendar Cita</button>
            </a>

            <a href="{{ route('servicios') }}">
             <button class="btn-3d btn-secondary-3d">Ver Servicios</button>
            </a>
        </div>
    </div>
    <div class="scroll-indicator">
        <span>Desliza</span>
        <div class="scroll-line"></div>
    </div>
</section>

    <!-- Experiencia Section -->
    <section class="experience">
        <div class="container">
            <div class="experience-grid">
                <div class="experience-card" data-aos="fade-up" data-delay="0">
                    <div class="card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="28" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <path d="M30 15 L30 45 M15 30 L45 30" stroke="#D4AF37" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3>Atención Personalizada</h3>
                    <p>Cada cliente es único. Diseñamos tu estilo perfecto.</p>
                </div>
                <div class="experience-card" data-aos="fade-up" data-delay="100">
                    <div class="card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <rect x="15" y="15" width="30" height="30" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <circle cx="30" cy="30" r="8" fill="#D4AF37"/>
                        </svg>
                    </div>
                    <h3>Barberos Profesionales</h3>
                    <p>Expertos certificados con años de experiencia.</p>
                </div>
                <div class="experience-card" data-aos="fade-up" data-delay="200">
                    <div class="card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <polygon points="30,10 50,50 10,50" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <circle cx="30" cy="35" r="5" fill="#D4AF37"/>
                        </svg>
                    </div>
                    <h3>Ambiente Premium</h3>
                    <p>Instalaciones exclusivas y confortables.</p>
                </div>
                <div class="experience-card" data-aos="fade-up" data-delay="300">
                    <div class="card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <path d="M20 25 L40 25 L40 40 L20 40 Z" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <circle cx="30" cy="20" r="4" fill="#D4AF37"/>
                        </svg>
                    </div>
                    <h3>Tecnología y Comodidad</h3>
                    <p>Equipamiento de última generación.</p>
                </div>
            </div>
        </div>
    </section>

<style>
@media (max-width: 768px) {
  .hero {
    background-image: url('{{ asset('img/ka.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
}
</style>




    <!-- Servicios Section -->
    <section class="services" id="servicios">
        <div class="container">
            <h2 class="section-title">Servicios Destacados</h2>
            <div class="services-grid">
                <div class="service-card" data-aos="zoom-in">
                    <div class="service-3d">
                        <div class="service-image">
                            <img src="/placeholder.svg?height=300&width=400" alt="Corte de Cabello">
                        </div>
                    </div>
                    <div class="service-info">
                        <h3>Corte Premium</h3>
                        <p class="service-price">Desde $45.000</p>
                        <p>Corte personalizado con técnicas profesionales</p>
                        <button class="btn-service">Reservar</button>
                    </div>
                </div>
                <div class="service-card" data-aos="zoom-in" data-delay="100">
                    <div class="service-3d">
                        <div class="service-image">
                            <img src="/placeholder.svg?height=300&width=400" alt="Afeitado de Barba">
                        </div>
                    </div>
                    <div class="service-info">
                        <h3>Arreglo de Barba</h3>
                        <p class="service-price">Desde $35.000</p>
                        <p>Perfilado y arreglo con navaja tradicional</p>
                        <button class="btn-service">Reservar</button>
                    </div>
                </div>
                <div class="service-card" data-aos="zoom-in" data-delay="200">
                    <div class="service-3d">
                        <div class="service-image">
                            <img src="/placeholder.svg?height=300&width=400" alt="Combo Premium">
                        </div>
                    </div>
                    <div class="service-info">
                        <h3>Combo Premium</h3>
                        <p class="service-price">Desde $70.000</p>
                        <p>Corte + Barba + Tratamiento facial</p>
                        <button class="btn-service">Reservar</button>
                    </div>
                </div>
                <div class="service-card" data-aos="zoom-in" data-delay="300">
                    <div class="service-3d">
                        <div class="service-image">
                            <img src="/placeholder.svg?height=300&width=400" alt="Tratamientos">
                        </div>
                    </div>
                    <div class="service-info">
                        <h3>Tratamientos</h3>
                        <p class="service-price">Desde $50.000</p>
                        <p>Cuidado capilar y facial especializado</p>
                        <button class="btn-service">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <section class="loyalty">
    <div class="container">
        <h2 class="section-title">Programa de Fidelización</h2>
        
        <div class="loyalty-content-wrapper">
            <!-- Texto Explicativo -->
            <div class="loyalty-info" data-aos="fade-right">
                <div class="info-badge">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                        <path d="M15 2L18.5 12H29L20.5 18.5L24 28.5L15 22L6 28.5L9.5 18.5L1 12H11.5L15 2Z" fill="#D4AF37" opacity="0.3"/>
                        <path d="M15 2L18.5 12H29L20.5 18.5L24 28.5L15 22L6 28.5L9.5 18.5L1 12H11.5L15 2Z" stroke="#D4AF37" stroke-width="1.5"/>
                    </svg>
                    <span>Exclusivo para Clientes</span>
                </div>
                
                <h3 class="info-title">Membresía Premium</h3>
                <p class="info-description">
                    Nuestro programa de fidelización fue creado para recompensar tu lealtad. 
                    Cada visita te acerca más a beneficios exclusivos y experiencias únicas.
                </p>
                
                <div class="info-benefits">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="#D4AF37" stroke-width="2"/>
                                <path d="M8 12L11 15L16 9" stroke="#D4AF37" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h4>Acumula Puntos</h4>
                            <p>Por cada servicio realizado</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L15 8.5L22 9.5L17 14.5L18 21.5L12 18.5L6 21.5L7 14.5L2 9.5L9 8.5L12 2Z" stroke="#D4AF37" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h4>Corte Gratis</h4>
                            <p>Al completar 8 visitas</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="6" width="18" height="14" rx="2" stroke="#D4AF37" stroke-width="2"/>
                                <path d="M3 10H21" stroke="#D4AF37" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h4>Descuentos Exclusivos</h4>
                            <p>En productos y servicios</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4" stroke="#D4AF37" stroke-width="2"/>
                                <path d="M6 21C6 17 9 14 12 14C15 14 18 17 18 21" stroke="#D4AF37" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="benefit-text">
                            <h4>Atención Prioritaria</h4>
                            <p>Reservas y agendamiento</p>
                        </div>
                    </div>
                </div>
                
                <div class="info-cta">
                    <p class="cta-text">¿Por qué lo creamos?</p>
                    <p class="cta-description">
                        Porque valoramos tu confianza y queremos que cada visita a H Barber Shop 
                        sea más que un servicio: una experiencia premium que reconoce tu lealtad 
                        y te hace parte de nuestra exclusiva comunidad.
                    </p>
                </div>
            </div>
            
            <!-- Tarjeta de Fidelización -->
            <div class="loyalty-card-wrapper" data-aos="fade-left">
                <div class="loyalty-card">
                    <div class="card-shine"></div>
                    <div class="card-header">
                        <div class="card-logo">
                            <svg width="50" height="50" viewBox="0 0 50 50">
                                <text x="25" y="35" font-family="Playfair Display" font-size="40" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                            </svg>
                        </div>
                        <div class="card-chip">
                            <div class="chip-line"></div>
                            <div class="chip-line"></div>
                            <div class="chip-line"></div>
                            <div class="chip-line"></div>
                        </div>
                    </div>
                    <div class="card-name">Cliente Premium</div>
                    <div class="progress-section">
                        <p class="progress-text">Acumula cortes y gana uno gratis</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 62.5%"></div>
                        </div>
                        <div class="progress-dots">
                            <span class="dot completed"></span>
                            <span class="dot completed"></span>
                            <span class="dot completed"></span>
                            <span class="dot completed"></span>
                            <span class="dot completed"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                        <p class="progress-count">5 de 8 cortes</p>
                    </div>
                    <div class="card-number">•••• •••• •••• 4829</div>
                </div>
                
                <div class="card-stats">
                     <div class="hero-buttons">
                        <a href="{{ route('fidelizacion') }}">
                <button class="btn-3d btn-primary-3d">Consultar</button>
                </a>
            </div>
                    <div class="stat-divider"></div>
                    
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Productos Section -->
    <section class="products" id="productos">
        <div class="container">
            <h2 class="section-title">Productos Premium</h2>
            <div class="products-carousel">
                <button class="carousel-btn prev">&lt;</button>
                <div class="products-track">
                    <div class="product-card">
                        <div class="product-3d">
                            <img src="/placeholder.svg?height=300&width=250" alt="Cera Premium">
                        </div>
                        <h4>Cera Premium</h4>
                        <p class="product-price">$35.000</p>
                        <button class="btn-product">Ver Producto</button>
                    </div>
                    <div class="product-card">
                        <div class="product-3d">
                            <img src="/placeholder.svg?height=300&width=250" alt="Aceite de Barba">
                        </div>
                        <h4>Aceite de Barba</h4>
                        <p class="product-price">$42.000</p>
                        <button class="btn-product">Ver Producto</button>
                    </div>
                    <div class="product-card">
                        <div class="product-3d">
                            <img src="/placeholder.svg?height=300&width=250" alt="Shampoo Premium">
                        </div>
                        <h4>Shampoo Premium</h4>
                        <p class="product-price">$38.000</p>
                        <button class="btn-product">Ver Producto</button>
                    </div>
                    <div class="product-card">
                        <div class="product-3d">
                            <img src="/placeholder.svg?height=300&width=250" alt="Pomada">
                        </div>
                        <h4>Pomada Texturizante</h4>
                        <p class="product-price">$40.000</p>
                        <button class="btn-product">Ver Producto</button>
                    </div>
                    <div class="product-card">
                        <div class="product-3d">
                            <img src="/placeholder.svg?height=300&width=250" alt="Aftershave">
                        </div>
                        <h4>Bálsamo After Shave</h4>
                        <p class="product-price">$45.000</p>
                        <button class="btn-product">Ver Producto</button>
                    </div>
                </div>
                <button class="carousel-btn next">&gt;</button>
            </div>
        </div>
    </section>

    <!-- Marca Section -->
    <section class="brand" id="nosotros">
        <div class="container">
            <h2 class="section-title">La Experiencia H Barber Shop</h2>
            <div class="brand-grid">
                <div class="brand-image large" data-aos="fade-right">
                    <img src="/placeholder.svg?height=500&width=600" alt="Interior de la Barbería">
                    <div class="image-overlay">
                        <h3>Exclusividad</h3>
                        <p>Un espacio diseñado para ti</p>
                    </div>
                </div>
                <div class="brand-content" data-aos="fade-left">
                    <h3>Profesionalismo</h3>
                    <p>Más de 15 años de experiencia en el arte de la barbería. Nuestro equipo está certificado y en constante capacitación para brindarte el mejor servicio.</p>
                </div>
                <div class="brand-content" data-aos="fade-right">
                    <h3>Estilo de Vida</h3>
                    <p>No es solo un corte, es una experiencia. Ambiente masculino, sofisticado y relajante donde cada detalle está pensado para tu comodidad.</p>
                </div>
                <div class="brand-image" data-aos="fade-left">
                    <img src="/placeholder.svg?height=350&width=400" alt="Barbero Profesional">
                    <div class="image-overlay">
                        <h3>Maestros del Estilo</h3>
                        <p>Expertos en su arte</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-final">
        <div class="cta-background"></div>
        <div class="container">
            <h2 class="cta-title">Reserva tu cita y vive la experiencia H Barber Shop</h2>
            <p class="cta-subtitle">Donde el estilo se encuentra con la perfección</p>
            <a href="{{ route('agendar') }}">
            <button class="btn-cta-3d">Agendar Ahora</button>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contacto">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <svg width="50" height="50" viewBox="0 0 50 50">
                            <text x="25" y="35" font-family="Playfair Display" font-size="40" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                        </svg>
                        <span>H BARBER SHOP SAS</span>
                    </div>
                    <p>Estilo, precisión y experiencia premium desde 2008</p>
                </div>
                <div class="footer-col">
                    <h4>Servicios</h4>
                    <ul>
                        <li><a href="#servicios">Corte Premium</a></li>
                        <li><a href="#servicios">Arreglo de Barba</a></li>
                        <li><a href="#servicios">Combo Premium</a></li>
                        <li><a href="#servicios">Tratamientos</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contacto</h4>
                    <ul>
                        <li>Calle 123 #45-67</li>
                        <li>Bogotá, Colombia</li>
                        <li>Tel: +57 310 123 4567</li>
                        <li>info@hbarbershop.com</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Horarios</h4>
                    <ul>
                        <li>Lun - Vie: 9:00 - 20:00</li>
                        <li>Sábados: 9:00 - 18:00</li>
                        <li>Domingos: 10:00 - 16:00</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 H Barber Shop SAS. Todos los derechos reservados.</p>
                <div class="social-links">
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Facebook">FB</a>
                    <a href="#" aria-label="WhatsApp">WA</a>
                </div>
            </div>
        </div>
    </footer>

   <script>
window.turnosAvailableRoute = "{{ route('turnos.available') }}";
window.turnosStoreRoute = "{{ route('turnos.store') }}";
</script>
@vite(['resources/js/Home/inicio.js'])
</body>
</html>
