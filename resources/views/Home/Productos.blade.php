@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Productos premium de H Barber Shop SAS. Cuidado de cabello, barba, styling y accesorios profesionales. Compra presencial en nuestra barbería.">
    <meta name="theme-color" content="#D4AF37">
    <title>Productos | H Barber Shop SAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/Home/Productos.css'])
</head>
<body lang="es">
    <!-- Skip Link -->
    <a href="#main-products-content" class="skip-link">Saltar al contenido principal</a>


    <!-- Hero Productos -->
    <section class="page-hero" role="banner" aria-label="Sección principal de productos" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('img/5.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-content">
            <h1 class="hero-title">Nuestros Productos</h1>
            <p class="hero-subtitle">Productos premium para el cuidado masculino. Calidad profesional para usar en casa.</p>
        </div>
    </section>

    <!-- Filtros -->
    <section class="filters-section" aria-label="Filtro de categorías de productos">
        <div class="container">
            <h2 class="visually-hidden">Categorías de productos</h2>
            <div class="filters-container" role="tablist">
                <button class="filter-btn active" data-filter="todos" role="tab" aria-selected="true">Todos</button>
                <button class="filter-btn" data-filter="cabello" role="tab" aria-selected="false">Cabello</button>
                <button class="filter-btn" data-filter="barba" role="tab" aria-selected="false">Barba</button>
                <button class="filter-btn" data-filter="styling" role="tab" aria-selected="false">Styling</button>
                <button class="filter-btn" data-filter="accesorios" role="tab" aria-selected="false">Accesorios</button>
            </div>
        </div>
    </section>

    <main id="main-products-content">
    @php
        $categorias = [
            'cabello' => 'Cuidado del Cabello',
            'barba' => 'Cuidado de Barba',
            'styling' => 'Styling & Fijación',
            'accesorios' => 'Accesorios',
        ];
    @endphp

    @foreach($categorias as $catKey => $catTitulo)
        <section class="products-section" id="{{ $catKey }}-products" data-category="{{ $catKey }}" role="tabpanel" aria-labelledby="{{ $catKey }}-tab">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title" id="{{ $catKey }}-tab">{{ $catTitulo }}</h2>
                    <div class="section-line" aria-hidden="true"></div>
                </div>
                <div class="products-grid" role="list">
                    @php $hayProductos = false; @endphp
                    @foreach($productos as $producto)
                        @if(strtolower($producto->pro_categoria) === $catKey)
                            @php $hayProductos = true; @endphp
                            <article class="product-card" data-category="{{ $catKey }}" role="listitem" aria-label="{{ $producto->pro_nombre }}">
                                @if($producto->pro_descuento > 0)
                                    <div class="product-badge" aria-label="Oferta disponible">Oferta</div>
                                @endif
                                <div class="product-image">
                                    @if($producto->pro_imagen)
                                        <img src="{{ asset('storage/' . $producto->pro_imagen) }}" alt="Producto: {{ $producto->pro_nombre }}">
                                    @else
                                        <i class="fas fa-box" aria-hidden="true"></i>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name">{{ $producto->pro_nombre }}</h3>
                                    <p class="product-description" aria-label="Descripción del producto">{{ $producto->pro_descripcion }}</p>
                                    <div class="product-volume" aria-label="Stock disponible">Stock: {{ $producto->pro_stock }}</div>
                                    <div class="product-footer">
                                        <span class="product-price" aria-label="Precio">
                                            ${{ number_format($producto->pro_precio - ($producto->pro_precio * $producto->pro_descuento / 100), 0, ',', '.') }}
                                            @if($producto->pro_descuento > 0)
                                                <span style="text-decoration:line-through;color:#888;font-size:0.9em;margin-left:8px;" aria-label="Precio original">${{ number_format($producto->pro_precio, 0, ',', '.') }}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                    @if(!$hayProductos)
                        <p role="status" aria-live="polite">No hay productos de esta categoría disponibles en este momento.</p>
                    @endif
                </div>
            </div>
        </section>
    @endforeach

    <!-- Kits Especiales -->
    <section class="products-section kits-section" aria-label="Kits especiales disponibles">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Kits Especiales</h2>
                <p class="section-subtitle">Combina y ahorra con nuestros kits exclusivos</p>
                <div class="section-line" aria-hidden="true"></div>
            </div>
            <div class="kits-grid" role="list">
                @php
                    $kits = $productos->where('pro_categoria', 'kit');
                @endphp
                @forelse($kits as $kit)
                <article class="kit-card @if(isset($kit->destacado) && $kit->destacado) featured @endif" role="listitem" aria-label="{{ $kit->pro_nombre }}">
                    @if(isset($kit->destacado) && $kit->destacado)
                        <div class="kit-badge" aria-label="Producción más popular">Más Popular</div>
                    @endif
                    <div class="kit-header">
                        <h3 class="kit-name">{{ $kit->pro_nombre }}</h3>
                        <p class="kit-tagline">{{ $kit->pro_descripcion }}</p>
                    </div>
                    <div class="kit-content">
                        <ul class="kit-items" role="list">
                            @foreach($kit->productosDelKit() as $producto)
                                <li role="listitem"><i class="fas fa-check" aria-hidden="true"></i> {{ $producto->pro_nombre }}</li>
                            @endforeach
                        </ul>
                        <div class="kit-pricing" aria-label="Información de precio">
                            @if(isset($kit->pro_precio_original) && $kit->pro_precio_original > $kit->pro_precio)
                                <span class="kit-original" aria-label="Precio original">${{ number_format($kit->pro_precio_original, 0, ',', '.') }}</span>
                            @endif
                            <span class="kit-price" aria-label="Precio del kit">${{ number_format($kit->pro_precio, 0, ',', '.') }}</span>
                        </div>
                        @if(isset($kit->pro_precio_original) && $kit->pro_precio_original > $kit->pro_precio)
                            <span class="kit-savings" aria-label="Ahorro">Ahorras ${{ number_format($kit->pro_precio_original - $kit->pro_precio, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </article>
                @empty
                    <p role="status" aria-live="polite">No hay kits especiales disponibles en este momento.</p>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Información de compra en barbería -->
    <section class="shipping-info" aria-label="Información sobre compra y servicio">
        <div class="container">
            <div class="shipping-grid" role="list">
                <article class="shipping-item" role="listitem">
                    <i class="fas fa-store" aria-hidden="true"></i>
                    <h4>Compra Presencial</h4>
                    <p>Productos disponibles solo en la barbería</p>
                </article>
                <article class="shipping-item" role="listitem">
                    <i class="fas fa-scissors" aria-hidden="true"></i>
                    <h4>Calidad Profesional</h4>
                    <p>Productos usados por nuestros barberos</p>
                </article>
                <article class="shipping-item" role="listitem">
                    <i class="fas fa-user-check" aria-hidden="true"></i>
                    <h4>Asesoría Personalizada</h4>
                    <p>Te ayudamos a elegir el producto ideal</p>
                </article>
                <article class="shipping-item" role="listitem">
                    <i class="fas fa-credit-card" aria-hidden="true"></i>
                    <h4>Pago en Local</h4>
                    <p>Efectivo y medios de pago disponibles</p>
                </article>
            </div>
        </div>
    </section>

    </main>



    <!-- Script para filtros accesible -->
    <script>
        // Crear región viva para anuncios
        if (!document.querySelector('[role="status"]')) {
            const statusRegion = document.createElement('div');
            statusRegion.setAttribute('role', 'status');
            statusRegion.setAttribute('aria-live', 'polite');
            statusRegion.setAttribute('aria-atomic', 'true');
            statusRegion.style.position = 'absolute';
            statusRegion.style.left = '-10000px';
            statusRegion.id = 'products-status';
            document.body.insertBefore(statusRegion, document.body.firstChild);
        }

        // Toggle del menú móvil (solo si existe)
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.querySelector('.nav-menu');
        
        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                navToggle.classList.toggle('active');
            });
        }

        // Filtrado de productos accesible
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productSections = document.querySelectorAll('.products-section[data-category]');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remover clase active y aria-selected de todos los botones
                filterBtns.forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                // Agregar clase active y aria-selected al botón clickeado
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');

                const filter = btn.dataset.filter;

                if (filter === 'todos') {
                    // Mostrar todas las secciones
                    productSections.forEach(section => {
                        section.style.display = 'block';
                    });
                    // Anunciar cambio
                    const statusRegion = document.querySelector('#products-status');
                    if (statusRegion) {
                        statusRegion.textContent = 'Mostrando todos los productos';
                    }
                } else {
                    // Mostrar solo la sección correspondiente
                    productSections.forEach(section => {
                        if (section.dataset.category === filter) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                    // Anunciar cambio
                    const categoryName = btn.textContent.trim();
                    const statusRegion = document.querySelector('#products-status');
                    if (statusRegion) {
                        statusRegion.textContent = `Mostrando productos de ${categoryName}`;
                    }
                }
            });

            // Navegación con teclado en filtros
            btn.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    const nextBtn = this.nextElementSibling;
                    if (nextBtn && nextBtn.classList.contains('filter-btn')) {
                        nextBtn.click();
                        nextBtn.focus();
                    }
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    const prevBtn = this.previousElementSibling;
                    if (prevBtn && prevBtn.classList.contains('filter-btn')) {
                        prevBtn.click();
                        prevBtn.focus();
                    }
                }
            });
        });

        // Navbar scroll effect (solo si existe)
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (navbar && window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else if (navbar) {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
   
</body>
@endsection

@push('styles')

@endpush