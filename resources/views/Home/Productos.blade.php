<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | H Barber Shop SAS</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/Home/Productos.css'])
</head>
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
                <a href="{{ route('productos') }}" class="active">Productos</a>
                <a href="{{ route('nosotros') }}">Nosotros</a>
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

    <!-- Hero Productos -->
    <section class="page-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Nuestros Productos</h1>
            <p class="hero-subtitle">Productos premium para el cuidado masculino. Calidad profesional para usar en casa.</p>
        </div>
    </section>

    <!-- Filtros -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-container">
                <button class="filter-btn active" data-filter="todos">Todos</button>
                <button class="filter-btn" data-filter="cabello">Cabello</button>
                <button class="filter-btn" data-filter="barba">Barba</button>
                <button class="filter-btn" data-filter="styling">Styling</button>
                <button class="filter-btn" data-filter="accesorios">Accesorios</button>
            </div>
        </div>
    </section>

    <!-- Productos Cabello -->
    <section class="products-section" data-category="cabello">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cuidado del Cabello</h2>
                <div class="section-line"></div>
            </div>
            <div class="products-grid">
                <!-- Producto 1 -->
                <div class="product-card" data-category="cabello">
                    <div class="product-badge">Bestseller</div>
                    <div class="product-image">
                        <i class="fas fa-pump-soap"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Shampoo Anticaída</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Fórmula profesional con biotina y keratina para fortalecer el cabello y prevenir la caída.</p>
                        <div class="product-volume">350ml</div>
                        <div class="product-footer">
                            <span class="product-price">$45.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 2 -->
                <div class="product-card" data-category="cabello">
                    <div class="product-image">
                        <i class="fas fa-bottle-droplet"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Acondicionador Hidratante</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Acondicionador con aceite de argán que hidrata profundamente y da brillo natural.</p>
                        <div class="product-volume">350ml</div>
                        <div class="product-footer">
                            <span class="product-price">$42.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 3 -->
                <div class="product-card" data-category="cabello">
                    <div class="product-image">
                        <i class="fas fa-spray-can-sparkles"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Tónico Capilar</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Tónico revitalizante que estimula el crecimiento y fortalece el folículo piloso.</p>
                        <div class="product-volume">200ml</div>
                        <div class="product-footer">
                            <span class="product-price">$55.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 4 -->
                <div class="product-card" data-category="cabello">
                    <div class="product-badge new">Nuevo</div>
                    <div class="product-image">
                        <i class="fas fa-droplet"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Sérum Reparador</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Sérum con vitamina E y proteínas que repara puntas dañadas y aporta suavidad.</p>
                        <div class="product-volume">100ml</div>
                        <div class="product-footer">
                            <span class="product-price">$38.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Barba -->
    <section class="products-section" data-category="barba">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cuidado de Barba</h2>
                <div class="section-line"></div>
            </div>
            <div class="products-grid">
                <!-- Producto 1 -->
                <div class="product-card" data-category="barba">
                    <div class="product-badge">Bestseller</div>
                    <div class="product-image">
                        <i class="fas fa-oil-can"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Aceite para Barba Premium</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Mezcla exclusiva de aceites naturales que suaviza, hidrata y da brillo a tu barba.</p>
                        <div class="product-volume">50ml</div>
                        <div class="product-footer">
                            <span class="product-price">$48.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 2 -->
                <div class="product-card" data-category="barba">
                    <div class="product-image">
                        <i class="fas fa-jar"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Bálsamo para Barba</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Bálsamo con manteca de karité que hidrata la piel y da forma a tu barba.</p>
                        <div class="product-volume">60g</div>
                        <div class="product-footer">
                            <span class="product-price">$42.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 3 -->
                <div class="product-card" data-category="barba">
                    <div class="product-image">
                        <i class="fas fa-pump-soap"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Shampoo para Barba</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Limpia suavemente sin resecar, dejando tu barba fresca y manejable.</p>
                        <div class="product-volume">200ml</div>
                        <div class="product-footer">
                            <span class="product-price">$35.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 4 -->
                <div class="product-card" data-category="barba">
                    <div class="product-badge new">Nuevo</div>
                    <div class="product-image">
                        <i class="fas fa-wind"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Cera Moldeadora Barba</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Cera de fijación media para dar forma y definir tu bigote y barba.</p>
                        <div class="product-volume">30g</div>
                        <div class="product-footer">
                            <span class="product-price">$32.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Styling -->
    <section class="products-section" data-category="styling">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Styling & Fijación</h2>
                <div class="section-line"></div>
            </div>
            <div class="products-grid">
                <!-- Producto 1 -->
                <div class="product-card" data-category="styling">
                    <div class="product-badge">Bestseller</div>
                    <div class="product-image">
                        <i class="fas fa-circle-dot"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Pomada Mate</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Fijación fuerte con acabado mate natural. Fácil de lavar, no deja residuos.</p>
                        <div class="product-volume">100g</div>
                        <div class="product-footer">
                            <span class="product-price">$38.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 2 -->
                <div class="product-card" data-category="styling">
                    <div class="product-image">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Pomada con Brillo</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Fijación media con brillo elegante. Ideal para looks clásicos y formales.</p>
                        <div class="product-volume">100g</div>
                        <div class="product-footer">
                            <span class="product-price">$38.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 3 -->
                <div class="product-card" data-category="styling">
                    <div class="product-image">
                        <i class="fas fa-spray-can"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Spray Fijador</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Fijación extra fuerte que dura todo el día. No deja el cabello rígido.</p>
                        <div class="product-volume">250ml</div>
                        <div class="product-footer">
                            <span class="product-price">$28.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 4 -->
                <div class="product-card" data-category="styling">
                    <div class="product-image">
                        <i class="fas fa-wind"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Cera Texturizadora</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Da textura y volumen al cabello con un acabado natural y flexible.</p>
                        <div class="product-volume">85g</div>
                        <div class="product-footer">
                            <span class="product-price">$35.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 5 -->
                <div class="product-card" data-category="styling">
                    <div class="product-badge new">Nuevo</div>
                    <div class="product-image">
                        <i class="fas fa-feather"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Polvo Voluminizador</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Polvo matificante que aporta volumen instantáneo y textura al cabello fino.</p>
                        <div class="product-volume">20g</div>
                        <div class="product-footer">
                            <span class="product-price">$32.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 6 -->
                <div class="product-card" data-category="styling">
                    <div class="product-image">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gel Fijación Extrema</h3>
                        <p class="product-brand">H Barber Pro</p>
                        <p class="product-description">Gel de fijación máxima para peinados que requieren control total.</p>
                        <div class="product-volume">300ml</div>
                        <div class="product-footer">
                            <span class="product-price">$25.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Accesorios -->
    <section class="products-section" data-category="accesorios">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Accesorios</h2>
                <div class="section-line"></div>
            </div>
            <div class="products-grid">
                <!-- Producto 1 -->
                <div class="product-card" data-category="accesorios">
                    <div class="product-badge">Bestseller</div>
                    <div class="product-image">
                        <i class="fas fa-brush"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Cepillo para Barba</h3>
                        <p class="product-brand">H Barber Tools</p>
                        <p class="product-description">Cepillo de cerdas naturales de jabalí que desenreda y da forma a tu barba.</p>
                        <div class="product-volume">Madera de bambú</div>
                        <div class="product-footer">
                            <span class="product-price">$45.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 2 -->
                <div class="product-card" data-category="accesorios">
                    <div class="product-image">
                        <i class="fas fa-comb"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Peine de Madera</h3>
                        <p class="product-brand">H Barber Tools</p>
                        <p class="product-description">Peine artesanal de madera de sándalo, antiestático y suave con el cabello.</p>
                        <div class="product-volume">15cm</div>
                        <div class="product-footer">
                            <span class="product-price">$28.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 3 -->
                <div class="product-card" data-category="accesorios">
                    <div class="product-image">
                        <i class="fas fa-scissors"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Tijeras para Barba</h3>
                        <p class="product-brand">H Barber Tools</p>
                        <p class="product-description">Tijeras de acero inoxidable de precisión para recortar y mantener tu barba.</p>
                        <div class="product-volume">Acero japonés</div>
                        <div class="product-footer">
                            <span class="product-price">$55.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 4 -->
                <div class="product-card" data-category="accesorios">
                    <div class="product-badge new">Nuevo</div>
                    <div class="product-image">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Kit Viajero</h3>
                        <p class="product-brand">H Barber Tools</p>
                        <p class="product-description">Estuche de cuero con mini aceite, bálsamo, peine y tijeras. Perfecto para viajes.</p>
                        <div class="product-volume">Estuche completo</div>
                        <div class="product-footer">
                            <span class="product-price">$120.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 5 -->
                <div class="product-card" data-category="accesorios">
                    <div class="product-image">
                        <i class="fas fa-shirt"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Delantal de Afeitado</h3>
                        <p class="product-brand">H Barber Tools</p>
                        <p class="product-description">Delantal con ventosas que se adhiere al espejo. Recoge todos los recortes de barba.</p>
                        <div class="product-volume">Talla única</div>
                        <div class="product-footer">
                            <span class="product-price">$35.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Producto 6 -->
                <div class="product-card" data-category="accesorios">
                    <div class="product-image">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Gift Card H Barber</h3>
                        <p class="product-brand">H Barber Shop</p>
                        <p class="product-description">Tarjeta de regalo para servicios o productos. El regalo perfecto para él.</p>
                        <div class="product-volume">Valor personalizable</div>
                        <div class="product-footer">
                            <span class="product-price">Desde $50.000</span>
                            <button class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kits Especiales -->
    <section class="products-section kits-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Kits Especiales</h2>
                <p class="section-subtitle">Combina y ahorra con nuestros kits exclusivos</p>
                <div class="section-line"></div>
            </div>
            <div class="kits-grid">
                <!-- Kit Básico -->
                <div class="kit-card">
                    <div class="kit-header">
                        <h3 class="kit-name">Kit Básico</h3>
                        <p class="kit-tagline">Para empezar tu rutina</p>
                    </div>
                    <div class="kit-content">
                        <ul class="kit-items">
                            <li><i class="fas fa-check"></i> Shampoo Anticaída 350ml</li>
                            <li><i class="fas fa-check"></i> Pomada Mate 100g</li>
                            <li><i class="fas fa-check"></i> Peine de Madera</li>
                        </ul>
                        <div class="kit-pricing">
                            <span class="kit-original">$111.000</span>
                            <span class="kit-price">$89.000</span>
                        </div>
                        <span class="kit-savings">Ahorras $22.000</span>
                        <button class="btn-kit">
                            <i class="fas fa-shopping-cart"></i>
                            Agregar Kit
                        </button>
                    </div>
                </div>

                <!-- Kit Premium -->
                <div class="kit-card featured">
                    <div class="kit-badge">Más Popular</div>
                    <div class="kit-header">
                        <h3 class="kit-name">Kit Premium</h3>
                        <p class="kit-tagline">Cuidado completo</p>
                    </div>
                    <div class="kit-content">
                        <ul class="kit-items">
                            <li><i class="fas fa-check"></i> Shampoo Anticaída 350ml</li>
                            <li><i class="fas fa-check"></i> Acondicionador 350ml</li>
                            <li><i class="fas fa-check"></i> Aceite para Barba 50ml</li>
                            <li><i class="fas fa-check"></i> Pomada Mate 100g</li>
                            <li><i class="fas fa-check"></i> Cepillo para Barba</li>
                        </ul>
                        <div class="kit-pricing">
                            <span class="kit-original">$218.000</span>
                            <span class="kit-price">$165.000</span>
                        </div>
                        <span class="kit-savings">Ahorras $53.000</span>
                        <button class="btn-kit featured">
                            <i class="fas fa-shopping-cart"></i>
                            Agregar Kit
                        </button>
                    </div>
                </div>

                <!-- Kit Barba Completa -->
                <div class="kit-card">
                    <div class="kit-header">
                        <h3 class="kit-name">Kit Barba Total</h3>
                        <p class="kit-tagline">Todo para tu barba</p>
                    </div>
                    <div class="kit-content">
                        <ul class="kit-items">
                            <li><i class="fas fa-check"></i> Aceite para Barba 50ml</li>
                            <li><i class="fas fa-check"></i> Bálsamo para Barba 60g</li>
                            <li><i class="fas fa-check"></i> Shampoo Barba 200ml</li>
                            <li><i class="fas fa-check"></i> Cepillo para Barba</li>
                            <li><i class="fas fa-check"></i> Tijeras para Barba</li>
                        </ul>
                        <div class="kit-pricing">
                            <span class="kit-original">$225.000</span>
                            <span class="kit-price">$179.000</span>
                        </div>
                        <span class="kit-savings">Ahorras $46.000</span>
                        <button class="btn-kit">
                            <i class="fas fa-shopping-cart"></i>
                            Agregar Kit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Información de envío -->
    <section class="shipping-info">
        <div class="container">
            <div class="shipping-grid">
                <div class="shipping-item">
                    <i class="fas fa-truck"></i>
                    <h4>Envío Gratis</h4>
                    <p>En compras mayores a $100.000</p>
                </div>
                <div class="shipping-item">
                    <i class="fas fa-box"></i>
                    <h4>Empaque Premium</h4>
                    <p>Presentación de lujo en cada pedido</p>
                </div>
                <div class="shipping-item">
                    <i class="fas fa-rotate-left"></i>
                    <h4>Devoluciones</h4>
                    <p>30 días para cambios o devoluciones</p>
                </div>
                <div class="shipping-item">
                    <i class="fas fa-headset"></i>
                    <h4>Soporte</h4>
                    <p>Asesoría personalizada</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <span class="logo-icon">H</span>
                        <span class="logo-text">Barber Shop</span>
                    </div>
                    <p class="footer-tagline">Donde el estilo se encuentra con la tradición</p>
                </div>
                <div class="footer-links">
                    <h4>Navegación</h4>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="servicios.html">Servicios</a></li>
                        <li><a href="productos.html">Productos</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contacto</h4>
                    <p><i class="fas fa-map-marker-alt"></i> Calle Principal #123, Ciudad</p>
                    <p><i class="fas fa-phone"></i> +57 300 123 4567</p>
                    <p><i class="fas fa-envelope"></i> info@hbarbershop.com</p>
                </div>
                <div class="footer-social">
                    <h4>Síguenos</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 H Barber Shop SAS. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Script para filtros -->
    <script>
        // Toggle del menú móvil
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.querySelector('.nav-menu');
        
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });

        // Filtrado de productos
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productCards = document.querySelectorAll('.product-card');
        const productSections = document.querySelectorAll('.products-section[data-category]');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remover clase active de todos los botones
                filterBtns.forEach(b => b.classList.remove('active'));
                // Agregar clase active al botón clickeado
                btn.classList.add('active');

                const filter = btn.dataset.filter;

                if (filter === 'todos') {
                    // Mostrar todas las secciones
                    productSections.forEach(section => {
                        section.style.display = 'block';
                    });
                } else {
                    // Mostrar solo la sección correspondiente
                    productSections.forEach(section => {
                        if (section.dataset.category === filter) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
