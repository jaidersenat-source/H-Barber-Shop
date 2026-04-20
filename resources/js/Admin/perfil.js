
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





