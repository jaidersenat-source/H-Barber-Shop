
// JavaScript para toggle de contrasena accesible

document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    const announcer = document.getElementById('sr-announcer');
    
    toggleButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const isPassword = input.type === 'password';
            
            input.type = isPassword ? 'text' : 'password';
            this.setAttribute('aria-label', isPassword ? 'Ocultar contrasena' : 'Mostrar contrasena');
            this.classList.toggle('active', isPassword);
            
            // Anunciar cambio a lectores de pantalla
            announcer.textContent = isPassword ? 'Contrasena visible' : 'Contrasena oculta';
        });
    });

    // Validacion en tiempo real
    const form = document.getElementById('perfil-form');
    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');

    if (confirmation) {
        confirmation.addEventListener('input', function() {
            if (password.value && this.value && password.value !== this.value) {
                this.setCustomValidity('Las contrasenas no coinciden');
                announcer.textContent = 'Advertencia: Las contrasenas no coinciden';
            } else {
                this.setCustomValidity('');
            }
        });
    }
});



// Navegación accesible con flechas y Tab para todo el módulo Configuración de Perfil
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-configuracion-perfil');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;
    let current = 0;
    focusables[0].focus();
    modulo.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Focus trap
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.shiftKey) {
                if (document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                if (document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            }
        } else if (["ArrowDown", "ArrowRight"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let next = (current + 1) % focusables.length;
                focusables[next].focus();
            }
        } else if (["ArrowUp", "ArrowLeft"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let prev = (current - 1 + focusables.length) % focusables.length;
                focusables[prev].focus();
            }
        } else if (e.key === 'Escape') {
            const menu = document.querySelector('.sidebar a');
            if (menu) menu.focus();
        }
    });
});

