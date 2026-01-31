// JavaScript para gestión accesible del módulo Personal (crear)
(function() {
    'use strict';
    
    const rolSelect = document.getElementById('rolSelect');
    const pwdDiv = document.getElementById('passwordDiv');
    const pwdInput = document.getElementById('rolPassword');
    const announcements = document.getElementById('sr-announcements');

    // Función para anunciar cambios a lectores de pantalla
    function announce(message) {
        announcements.textContent = message;
        // Limpiar después de anuncio
        setTimeout(function() {
            announcements.textContent = '';
        }, 1000);
    }

    // Mostrar/ocultar campo de contraseña según rol
    function togglePasswordField() {
        const isAdmin = rolSelect.value === 'admin';
        
        if (isAdmin) {
            pwdDiv.hidden = false;
            pwdInput.required = true;
            pwdInput.setAttribute('aria-required', 'true');
            announce('Campo de contraseña visible. Se requiere su contraseña para asignar rol de administrador.');
            // Mover foco al campo de contraseña
            setTimeout(function() {
                pwdInput.focus();
            }, 100);
        } else {
            pwdDiv.hidden = true;
            pwdInput.required = false;
            pwdInput.removeAttribute('aria-required');
            pwdInput.value = '';
            if (rolSelect.value) {
                announce('Rol seleccionado: ' + rolSelect.options[rolSelect.selectedIndex].text);
            }
        }
    }

    // Verificar estado inicial (para cuando hay errores de validación)
    togglePasswordField();

    // Escuchar cambios en el selector de rol
    rolSelect.addEventListener('change', togglePasswordField);

    // Validación del lado del cliente con mensajes accesibles
    document.getElementById('personalForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let firstInvalid = null;
        let errors = [];

        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add('input-error');
                field.setAttribute('aria-invalid', 'true');
                const label = document.querySelector('label[for="' + field.id + '"]');
                if (label) {
                    errors.push(label.textContent.replace('*', '').replace('(obligatorio)', '').trim() + ' es obligatorio');
                }
                if (!firstInvalid) {
                    firstInvalid = field;
                }
            } else {
                field.classList.remove('input-error');
                field.removeAttribute('aria-invalid');
            }
        });

        // Validar formato de email
        const emailField = document.getElementById('per_correo');
        if (emailField.value && !emailField.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            emailField.classList.add('input-error');
            emailField.setAttribute('aria-invalid', 'true');
            errors.push('El formato del correo electrónico no es válido');
            if (!firstInvalid) {
                firstInvalid = emailField;
            }
        }

        if (errors.length > 0) {
            e.preventDefault();
            announce('Error en el formulario. ' + errors.join('. '));
            if (firstInvalid) {
                firstInvalid.focus();
            }
        } else {
            announce('Enviando formulario, por favor espere.');
        }
    });

    // Limpiar estado de error al escribir
    document.querySelectorAll('input, select').forEach(function(field) {
        field.addEventListener('input', function() {
            this.classList.remove('input-error');
            this.removeAttribute('aria-invalid');
        });
    });
})();
// Atajo de teclado global para volver (Alt+B)
document.addEventListener('keydown', function(e) {
    if ((e.altKey || e.metaKey) && (e.key === 'b' || e.key === 'B')) {
        const volverBtn = document.querySelector('a[accesskey="b"]');
        if (volverBtn) {
            volverBtn.focus();
            volverBtn.click();
        }
    }
});
// Navegación accesible con flechas y Tab para todo el módulo Personal (crear)
// y volver al menú con Esc

document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-personal');
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
