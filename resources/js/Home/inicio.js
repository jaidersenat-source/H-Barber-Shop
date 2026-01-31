// ========================================
// INICIALIZACIÓN SEGURA DE LIBRERÍAS
// ========================================

// Esperar a que todas las librerías estén cargadas
function waitForLibraries() {
  return new Promise((resolve) => {
    const checkLibraries = setInterval(() => {
      if (window.gsap && window.ScrollTrigger) {
        clearInterval(checkLibraries);
        console.log('✅ Todas las librerías cargadas correctamente');
        resolve();
      }
    }, 100);
  });
}

// ========================================
// VIDEO BACKGROUND HERO
// ========================================

// ========================================
// VIDEO BACKGROUND HERO (CORREGIDO)
// ========================================

function initVideoHero() {
  const heroVideo = document.getElementById('hero-video');
  const videoOverlay = document.querySelector('.video-overlay');
  
  if (!heroVideo) {
    console.warn('⚠️ Video hero no encontrado');
    return;
  }

  // Asegurar que el video se reproduce automáticamente
  heroVideo.play().catch(error => {
    console.log('Autoplay fue bloqueado, intentando reproducir con interacción del usuario');
    document.addEventListener('click', () => {
      heroVideo.play();
    }, { once: true });
  });

  // Añadir efecto parallax al video (CORREGIDO)
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const heroSection = document.querySelector('.hero');
    
    if (heroSection && scrolled < heroSection.offsetHeight) {
      // IMPORTANTE: Mantener el centrado (-50%, -50%) y solo agregar el efecto parallax
      heroVideo.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.3}px))`;
      
      // Aumentar opacidad del overlay al hacer scroll
      if (videoOverlay) {
        const opacity = Math.min(0.7 + (scrolled / heroSection.offsetHeight) * 0.3, 0.9);
        videoOverlay.style.background = `linear-gradient(135deg, rgba(0,0,0,${opacity}) 0%, rgba(10,10,20,${opacity}) 100%)`;
      }
    }
  });

  console.log('✅ Video hero inicializado correctamente');
}

// ========================================
// PARTÍCULAS DECORATIVAS SUTILES
// ========================================

function initDecorativeParticles() {
  const canvas = document.getElementById('particles-canvas');
  if (!canvas) {
    console.warn('⚠️ Canvas de partículas no encontrado');
    return;
  }

  const ctx = canvas.getContext('2d');
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  const particles = [];
  const particleCount = 50;

  class Particle {
    constructor() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height;
      this.size = Math.random() * 2 + 1;
      this.speedX = Math.random() * 0.5 - 0.25;
      this.speedY = Math.random() * 0.5 - 0.25;
      this.opacity = Math.random() * 0.5 + 0.2;
    }

    update() {
      this.x += this.speedX;
      this.y += this.speedY;

      if (this.x > canvas.width) this.x = 0;
      if (this.x < 0) this.x = canvas.width;
      if (this.y > canvas.height) this.y = 0;
      if (this.y < 0) this.y = canvas.height;
    }

    draw() {
      ctx.fillStyle = `rgba(212, 175, 55, ${this.opacity})`;
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  for (let i = 0; i < particleCount; i++) {
    particles.push(new Particle());
  }

  function animateParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    particles.forEach(particle => {
      particle.update();
      particle.draw();
    });

    // Dibujar líneas entre partículas cercanas
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < 100) {
          ctx.strokeStyle = `rgba(212, 175, 55, ${0.1 * (1 - distance / 100)})`;
          ctx.lineWidth = 0.5;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }

    requestAnimationFrame(animateParticles);
  }

  animateParticles();

  // Resize handler
  window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  });

  console.log('✅ Partículas decorativas inicializadas');
}

// ========================================
// GSAP SCROLL ANIMATIONS
// ========================================

function initScrollAnimations() {
  try {
    gsap.registerPlugin(ScrollTrigger);

    // ===== HERO CONTENT ENTRANCE =====
    gsap.from('.hero-content h1', {
      y: 100,
      opacity: 0,
      duration: 1.2,
      ease: 'power3.out',
      delay: 0.3
    });

    gsap.from('.hero-content p', {
      y: 80,
      opacity: 0,
      duration: 1,
      ease: 'power3.out',
      delay: 0.6
    });

    gsap.from('.hero-buttons', {
      y: 60,
      opacity: 0,
      duration: 1,
      ease: 'power3.out',
      delay: 0.9
    });

    gsap.from('.scroll-indicator', {
      y: -30,
      opacity: 0,
      duration: 1,
      ease: 'power2.out',
      delay: 1.2
    });

    // ===== EXPERIENCE CARDS =====
    const experienceCards = document.querySelectorAll(".experience-card");
    experienceCards.forEach((card, index) => {
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: "top 85%",
          end: "top 20%",
          toggleActions: "play none none reverse",
        },
        y: 80,
        opacity: 0,
        duration: 0.8,
        delay: index * 0.15,
        ease: "power3.out"
      });
    });

    // ===== SERVICE CARDS =====
    const serviceCards = document.querySelectorAll(".service-card");
    serviceCards.forEach((card, index) => {
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: "top 85%",
          toggleActions: "play none none reverse"
        },
        scale: 0.85,
        opacity: 0,
        duration: 0.9,
        delay: index * 0.12,
        ease: "back.out(1.3)"
      });
    });

    // ===== LOYALTY CARD =====
    const loyaltyCard = document.querySelector(".loyalty-card");
    if (loyaltyCard) {
      gsap.from(loyaltyCard, {
        scrollTrigger: {
          trigger: loyaltyCard,
          start: "top 80%",
          toggleActions: "play none none reverse"
        },
        rotationY: -90,
        opacity: 0,
        duration: 1.2,
        ease: "back.out(1.5)"
      });
    }

    // ===== PRODUCT CARDS =====
    const productCards = document.querySelectorAll(".product-card");
    productCards.forEach((card, index) => {
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: "top 90%",
          toggleActions: "play none none reverse"
        },
        y: 60,
        opacity: 0,
        duration: 0.7,
        delay: index * 0.08,
        ease: "power2.out"
      });
    });

    // ===== BRAND GRID ELEMENTS =====
    const brandImages = document.querySelectorAll(".brand-image");
    brandImages.forEach((img, index) => {
      gsap.from(img, {
        scrollTrigger: {
          trigger: img,
          start: "top 85%",
          toggleActions: "play none none reverse"
        },
        x: index % 2 === 0 ? -100 : 100,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });
    });

    const brandContents = document.querySelectorAll(".brand-content");
    brandContents.forEach((content, index) => {
      gsap.from(content, {
        scrollTrigger: {
          trigger: content,
          start: "top 85%",
          toggleActions: "play none none reverse"
        },
        x: index % 2 === 0 ? 100 : -100,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });
    });

    // ===== SECTION TITLES =====
    const sectionTitles = document.querySelectorAll(".section-title");
    sectionTitles.forEach((title) => {
      gsap.from(title, {
        scrollTrigger: {
          trigger: title,
          start: "top 85%",
          toggleActions: "play none none reverse"
        },
        y: 60,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
      });
    });

    // ===== CTA FINAL =====
    const ctaElements = document.querySelectorAll(".cta-title, .cta-subtitle, .btn-cta-3d");
    ctaElements.forEach((el, index) => {
      gsap.from(el, {
        scrollTrigger: {
          trigger: el,
          start: "top 85%",
          toggleActions: "play none none reverse"
        },
        y: 50,
        opacity: 0,
        duration: 0.8,
        delay: index * 0.2,
        ease: "power2.out"
      });
    });

    console.log('✅ Animaciones de scroll inicializadas');

  } catch (error) {
    console.error('❌ Error al inicializar animaciones:', error);
  }
}

// ========================================
// PRODUCTS CAROUSEL
// ========================================

function initProductsCarousel() {
  const track = document.querySelector(".products-track");
  const prevBtn = document.querySelector(".carousel-btn.prev");
  const nextBtn = document.querySelector(".carousel-btn.next");

  if (!track || !prevBtn || !nextBtn) {
    console.warn('⚠️ Elementos del carrusel no encontrados');
    return;
  }

  const scrollAmount = 320;

  prevBtn.addEventListener("click", () => {
    track.scrollBy({
      left: -scrollAmount,
      behavior: "smooth"
    });
  });

  nextBtn.addEventListener("click", () => {
    track.scrollBy({
      left: scrollAmount,
      behavior: "smooth"
    });
  });

  console.log('✅ Carrusel de productos inicializado');
}

// ========================================
// MOBILE MENU
// ========================================

function initMobileMenu() {
  const menuBtn = document.querySelector(".mobile-menu-btn");
  const navLinks = document.querySelector(".nav-links");
  const body = document.body;

  if (!menuBtn || !navLinks) {
    console.warn('⚠️ Elementos del menú móvil no encontrados');
    return;
  }

  let isOpen = false;

  menuBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    isOpen = !isOpen;

    if (isOpen) {
      navLinks.style.display = "flex";
      navLinks.style.position = "fixed";
      navLinks.style.top = "70px";
      navLinks.style.left = "0";
      navLinks.style.right = "0";
      navLinks.style.flexDirection = "column";
      navLinks.style.background = "rgba(10, 10, 10, 0.98)";
      navLinks.style.padding = "2rem";
      navLinks.style.gap = "1.5rem";
      navLinks.style.zIndex = "999";
      navLinks.style.boxShadow = "0 10px 40px rgba(0,0,0,0.5)";
      
      menuBtn.classList.add('active');
      body.style.overflow = 'hidden';
    } else {
      navLinks.style.display = "none";
      menuBtn.classList.remove('active');
      body.style.overflow = 'auto';
    }
  });

  navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 768) {
        navLinks.style.display = "none";
        menuBtn.classList.remove('active');
        body.style.overflow = 'auto';
        isOpen = false;
      }
    });
  });

  document.addEventListener('click', (e) => {
    if (isOpen && !navLinks.contains(e.target) && !menuBtn.contains(e.target)) {
      navLinks.style.display = "none";
      menuBtn.classList.remove('active');
      body.style.overflow = 'auto';
      isOpen = false;
    }
  });

  console.log('✅ Menú móvil inicializado');
}

// ========================================
// SMOOTH SCROLL
// ========================================

function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const href = this.getAttribute("href");
      
      if (!href || href === '#') {
        e.preventDefault();
        return;
      }

      const target = document.querySelector(href);
      
      if (target) {
        e.preventDefault();
        const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 70;
        const targetPosition = target.offsetTop - navbarHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: "smooth"
        });
      }
    });
  });

  console.log('✅ Smooth scroll inicializado');
}

// ========================================
// NAVBAR SCROLL EFFECT
// ========================================

function initNavbarScroll() {
  const navbar = document.querySelector(".navbar");
  
  if (!navbar) {
    console.warn('⚠️ Navbar no encontrado');
    return;
  }

  let lastScroll = 0;

  window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
      navbar.style.background = "rgba(10, 10, 10, 0.98)";
      navbar.style.boxShadow = "0 4px 20px rgba(212, 175, 55, 0.15)";
      navbar.style.padding = "0.5rem 0";
    } else {
      navbar.style.background = "rgba(10, 10, 10, 0.95)";
      navbar.style.boxShadow = "none";
      navbar.style.padding = "1rem 0";
    }

    lastScroll = currentScroll;
  });

  console.log('✅ Efecto de scroll del navbar inicializado');
}

// ========================================
// BUTTONS INTERACTIONS
// ========================================

function initButtonInteractions() {
  const buttons = document.querySelectorAll(
    ".btn-primary, .btn-primary-3d, .btn-secondary-3d, .btn-cta-3d, .btn-service, .btn-product"
  );

  buttons.forEach((button) => {
    button.addEventListener("click", (e) => {
      const buttonText = e.target.textContent.trim();
      console.log('🔘 Botón clickeado:', buttonText);

      const ripple = document.createElement('span');
      const rect = button.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;

      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      ripple.classList.add('ripple');

      button.style.position = 'relative';
      button.style.overflow = 'hidden';
      button.appendChild(ripple);

      setTimeout(() => ripple.remove(), 600);

      if (buttonText.includes('Agendar') || buttonText.includes('Reservar')) {
        mostrarModalReserva();
      } else if (buttonText.includes('Ver')) {
        console.log('Ver más información del producto/servicio');
      }
    });
  });

  console.log('✅ Interacciones de botones inicializadas');
}

// ========================================
// MODAL DE RESERVA
// ========================================

function mostrarModalReserva() {
  alert('🗓️ Sistema de Reservas\n\nLlámanos para agendar tu cita:\n+57 310 123 4567\n\n¡O usa nuestro sistema de reservas online!');
}

// ========================================
// PROGRESS BAR ANIMATION
// ========================================

function initProgressAnimation() {
  const progressFill = document.querySelector('.progress-fill');
  
  if (progressFill) {
    gsap.from(progressFill, {
      scrollTrigger: {
        trigger: progressFill,
        start: "top 80%",
        toggleActions: "play none none reverse"
      },
      width: 0,
      duration: 1.5,
      ease: "power2.out"
    });
  }
}

// ========================================
// INICIALIZACIÓN PRINCIPAL
// ========================================

async function init() {
  console.log('🚀 Iniciando H Barber Shop...');
  
  try {
    await waitForLibraries();
    
    initVideoHero();
    initDecorativeParticles();
    initScrollAnimations();
    initProductsCarousel();
    initMobileMenu();
    initSmoothScroll();
    initNavbarScroll();
    initButtonInteractions();
    initProgressAnimation();
    
    console.log('✅ H Barber Shop inicializado completamente');
    
  } catch (error) {
    console.error('❌ Error durante la inicialización:', error);
  }
}

// ========================================
// EJECUTAR CUANDO EL DOM ESTÉ LISTO
// ========================================

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}

// ========================================
// ESTILOS CSS DINÁMICOS
// ========================================

const style = document.createElement('style');
style.textContent = `
  .ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s ease-out;
    pointer-events: none;
  }

  @keyframes ripple-animation {
    to {
      transform: scale(4);
      opacity: 0;
    }
  }

  .mobile-menu-btn.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
  }

  .mobile-menu-btn.active span:nth-child(2) {
    opacity: 0;
  }

  .mobile-menu-btn.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
  }

  .mobile-menu-btn span {
    transition: all 0.3s ease;
  }

  /* Video Hero Styles */
  .hero {
    position: relative;
    overflow: hidden;
  }

  #hero-video {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translateX(-50%) translateY(-50%);
    z-index: 0;
    object-fit: cover;
  }

  .video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(10,10,20,0.7) 100%);
    z-index: 1;
    transition: background 0.3s ease;
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  #particles-canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
  }

  .scroll-indicator {
    animation: bounce 2s infinite;
  }

  @keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
      transform: translateY(0);
    }
    40% {
      transform: translateY(-10px);
    }
    60% {
      transform: translateY(-5px);
    }
  }
`;
document.head.appendChild(style);