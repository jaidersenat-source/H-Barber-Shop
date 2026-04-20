// JavaScript para gestión accesible del módulo Personal (crear)
(function() {
    'use strict';
    // Solo validación básica y mensajes accesibles, sin interferir con comandos del lector de pantalla
    const rolSelect = document.getElementById('rolSelect');
    const pwdDiv = document.getElementById('passwordDiv');
    const pwdInput = document.getElementById('rolPassword');
    const documentoField = document.getElementById('per_documento');
    const telefonoField = document.getElementById('per_telefono');
    const nombreField = document.getElementById('per_nombre');
    const apellidoField = document.getElementById('per_apellido');
    const announcements = document.getElementById('sr-announcements');

    function announce(message) {
        announcements.textContent = message;
        setTimeout(function() {
            announcements.textContent = '';
        }, 1000);
    }

    function togglePasswordField() {
        if (!rolSelect) return;
        const isAdmin = rolSelect.value === 'admin';
        if (isAdmin) {
            pwdDiv.hidden = false;
            pwdInput.required = true;
            pwdInput.setAttribute('aria-required', 'true');
            announce('Campo de contraseña visible. Se requiere su contraseña para asignar rol de administrador.');
        } else {
            pwdDiv.hidden = true;
            if (pwdInput) {
                pwdInput.required = false;
                pwdInput.removeAttribute('aria-required');
                pwdInput.value = '';
            }
            if (rolSelect.value) {
                announce('Rol seleccionado: ' + rolSelect.options[rolSelect.selectedIndex].text);
            }
        }
    }

    if (rolSelect) {
        togglePasswordField();
        rolSelect.addEventListener('change', togglePasswordField);
    }

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
    document.querySelectorAll('input, select').forEach(function(field) {
        field.addEventListener('input', function() {
            this.classList.remove('input-error');
            this.removeAttribute('aria-invalid');
        });
    });

    // Sanitización: solo dígitos para documento y teléfono
    if (documentoField) {
        documentoField.setAttribute('inputmode', 'numeric');
        documentoField.setAttribute('pattern', '\\d*');
        documentoField.addEventListener('input', function() {
            const v = this.value;
            const digits = v.replace(/\D+/g, '');
            if (v !== digits) this.value = digits;
        });
    }

    if (telefonoField) {
        telefonoField.setAttribute('inputmode', 'numeric');
        telefonoField.setAttribute('pattern', '\\d*');
        telefonoField.addEventListener('input', function() {
            const v = this.value;
            const digits = v.replace(/\D+/g, '');
            if (v !== digits) this.value = digits;
        });
    }

    // Evitar números en nombre y apellido
    function stripDigitsFromField(field) {
        if (!field) return;
        field.addEventListener('input', function() {
            const v = this.value;
            const cleaned = v.replace(/\d+/g, '');
            if (v !== cleaned) {
                this.value = cleaned;
            }
        });
    }
    stripDigitsFromField(nombreField);
    stripDigitsFromField(apellidoField);
})();
