
        let selectedBarber = null;
        let selectedService = null;
        let barberAvailable = true;
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let selectedDate = null;
        let selectedTime = null;

        // Función para anunciar a JAWS (región viva)
        function announceToScreenReader(message) {
            let announcer = document.getElementById('a11y-announcer');
            if (!announcer) {
                announcer = document.createElement('div');
                announcer.id = 'a11y-announcer';
                announcer.setAttribute('role', 'status');
                announcer.setAttribute('aria-live', 'polite');
                announcer.setAttribute('aria-atomic', 'true');
                announcer.className = 'sr-only';
                document.body.appendChild(announcer);
            }
            announcer.textContent = '';
            setTimeout(() => {
                announcer.textContent = message;
            }, 100);
        }

        // Función para seleccionar barbero (reutilizable para click y teclado)
        function selectBarber(card) {
            document.querySelectorAll('#step-1 .selection-card').forEach(c => {
                c.classList.remove('selected');
                c.setAttribute('aria-checked', 'false');
                c.setAttribute('tabindex', '-1');
            });
            card.classList.add('selected');
            card.setAttribute('aria-checked', 'true');
            card.setAttribute('tabindex', '0');
            card.focus();
            selectedBarber = card.dataset.barber;
            
            // Actualizar resumen
            const barberName = card.dataset.name;
            document.getElementById('summary-barber').textContent = barberName;
            
            // Anunciar a JAWS
            announceToScreenReader(`Barbero seleccionado: ${barberName}`);
            
            const btnNext1 = document.getElementById('btn-next-1');
            const availabilityMsg = document.getElementById('barber-availability-message');

            // Leer disponibilidad directamente del atributo data (calculado en servidor)
            // 'any' siempre tiene disponibilidad; para barberos específicos usamos data-has-availability
            const hasAvailability = (selectedBarber === 'any') || (card.dataset.hasAvailability !== 'false');

            if (availabilityMsg) {
                availabilityMsg.style.display = 'none';
                availabilityMsg.textContent = '';
            }

            if (hasAvailability) {
                barberAvailable = true;
                btnNext1.disabled = false;
                btnNext1.setAttribute('aria-disabled', 'false');
                // Avanzar automáticamente al siguiente paso
                setTimeout(() => goToStep(2), 150);
            } else {
                barberAvailable = false;
                btnNext1.disabled = true;
                btnNext1.setAttribute('aria-disabled', 'true');
                if (availabilityMsg) {
                    availabilityMsg.textContent = 'Este barbero no cuenta con disponibilidad.';
                    availabilityMsg.style.display = 'block';
                }
                announceToScreenReader('Este barbero no cuenta con disponibilidad.');
            }
        }

        // Navegación con flechas en radiogroup de barberos (para JAWS)
        function setupRadioGroupNavigation(containerSelector) {
            const cards = Array.from(document.querySelectorAll(`${containerSelector} .selection-card`));
            
            cards.forEach((card, index) => {
                card.addEventListener('keydown', (e) => {
                    let targetIndex = index;
                    
                    switch(e.key) {
                        case 'ArrowDown':
                        case 'ArrowRight':
                            e.preventDefault();
                            targetIndex = (index + 1) % cards.length;
                            break;
                        case 'ArrowUp':
                        case 'ArrowLeft':
                            e.preventDefault();
                            targetIndex = (index - 1 + cards.length) % cards.length;
                            break;
                        case ' ':
                        case 'Enter':
                            e.preventDefault();
                            if (containerSelector === '#step-1') {
                                selectBarber(card);
                            } else if (containerSelector === '#step-2') {
                                selectService(card);
                            }
                            return;
                        default:
                            return;
                    }
                    
                    cards[targetIndex].focus();
                });
            });
        }

        // Selection functionality for barber cards
        document.querySelectorAll('#step-1 .selection-card').forEach(card => {
            // Click con mouse
            card.addEventListener('click', () => {
                selectBarber(card);
            });
        });

        // Configurar navegación con flechas para barberos
        setupRadioGroupNavigation('#step-1');

        // Función para seleccionar servicio (reutilizable para click y teclado)
        function selectService(card) {
            // Si el barbero seleccionado no tiene disponibilidad, bloquear selección
            if (typeof barberAvailable !== 'undefined' && !barberAvailable) {
                const availabilityMsg = document.getElementById('barber-availability-message');
                if (availabilityMsg) {
                    availabilityMsg.textContent = 'Este barbero no cuenta con disponibilidad.';
                    availabilityMsg.style.display = 'block';
                }
                announceToScreenReader('Este barbero no cuenta con disponibilidad.');
                return;
            }
            document.querySelectorAll('#step-2 .selection-card').forEach(c => {
                c.classList.remove('selected');
                c.setAttribute('aria-checked', 'false');
                c.setAttribute('tabindex', '-1');
            });
            card.classList.add('selected');
            card.setAttribute('aria-checked', 'true');
            card.setAttribute('tabindex', '0');
            card.focus();
            selectedService = {
                id: card.dataset.service,
                name: card.dataset.name,
                price: card.dataset.price,
                duration: card.dataset.duration,
                type: card.dataset.type || 'service',
                description: card.querySelector('.service-description') ? card.querySelector('.service-description').textContent : '',
                comboServices: card.querySelector('.combo-services') ? card.querySelector('.combo-services').textContent : ''
            };
            // Actualizar resumen
            document.getElementById('summary-service').textContent = selectedService.name;
            document.getElementById('summary-duration').textContent = selectedService.duration + ' min';
            document.getElementById('summary-total').textContent = '$' + new Intl.NumberFormat('es-CO').format(selectedService.price);
            
            // Anunciar a JAWS
            announceToScreenReader(`Servicio seleccionado: ${selectedService.name}, ${selectedService.duration} minutos, ${new Intl.NumberFormat('es-CO', {style: 'currency', currency: 'COP'}).format(selectedService.price)}`);
            
            // Mostrar descripción y servicios incluidos si es combo
           
            const btnNext2 = document.getElementById('btn-next-2');
            btnNext2.disabled = false;
            btnNext2.setAttribute('aria-disabled', 'false');
            // Avanzar automáticamente al siguiente paso para mejorar la fluidez UX
            setTimeout(() => goToStep(3), 150);
        }

        // Selection functionality for service cards
        document.querySelectorAll('#step-2 .selection-card').forEach(card => {
            // Click con mouse
            card.addEventListener('click', () => {
                selectService(card);
            });
        });

        // Configurar navegación con flechas para servicios
        setupRadioGroupNavigation('#step-2');

        // Calendar navigation
        document.getElementById('prev-month').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar();
        });

        document.getElementById('next-month').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar();
        });

        function generateCalendar() {
            const monthNames = [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ];
            
            document.getElementById('calendar-month').textContent = `${monthNames[currentMonth]} ${currentYear}`;
            
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const startDate = firstDay.getDay();
            
            let calendarHTML = '';
            
            // Empty cells for days before month starts
            for (let i = 0; i < startDate; i++) {
                calendarHTML += '<button class="calendar-day empty"></button>';
            }
            
            // Days of the month
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const date = new Date(currentYear, currentMonth, day);
                const today = new Date();
                let classes = 'calendar-day';
                
                if (date.toDateString() === today.toDateString()) {
                    classes += ' today';
                }
                
                if (date < today.setHours(0,0,0,0)) {
                    classes += ' disabled';
                }
                
                calendarHTML += `<button class="${classes}" data-date="${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}">${day}</button>`;
            }
            
            document.getElementById('calendar-days').innerHTML = calendarHTML;
            
            // Add click handlers to calendar days
            document.querySelectorAll('.calendar-day:not(.disabled):not(.empty)').forEach(day => {
                day.addEventListener('click', () => {
                    document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                    day.classList.add('selected');
                    selectedDate = day.dataset.date;
                    
                    // Actualizar resumen de fecha
                    const dateObj = new Date(selectedDate + 'T00:00:00');
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    document.getElementById('summary-date').textContent = dateObj.toLocaleDateString('es-ES', options);
                    
                    loadAvailableTimeSlots();
                    checkStep3();
                });
            });
        }

        function loadAvailableTimeSlots() {
            if (!selectedBarber || !selectedDate) {
                return;
            }
            
            const timeSlotsContainer = document.getElementById('time-slots');
            timeSlotsContainer.innerHTML = '<div style="text-align: center; padding: 1rem; color: #666;">Cargando horarios...</div>';
            
            // AJAX request to get available time slots
            fetch(`/agendar/horarios-disponibles`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    barber_id: selectedBarber,
                    date: selectedDate,
                    service_duration: selectedService ? selectedService.duration : 30
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    generateTimeSlots(data.available_slots);
                } else {
                    timeSlotsContainer.innerHTML = '<div style="text-align: center; padding: 1rem; color: #666;">No hay horarios disponibles para esta fecha</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                timeSlotsContainer.innerHTML = '<div style="text-align: center; padding: 1rem; color: #ff6b6b;">Error al cargar horarios</div>';
            });
        }

        function generateTimeSlots(availableSlots) {
            const timeSlotsContainer = document.getElementById('time-slots');
            let slotsHTML = '';
            
            if (availableSlots.length === 0) {
                slotsHTML = '<div style="text-align: center; padding: 1rem; color: #666;">No hay horarios disponibles para esta fecha</div>';
            } else {
                const now = new Date();
                const hoy = now.toISOString().slice(0, 10); // Formato YYYY-MM-DD
                
                console.log('Validación de tiempo:', {
                    hoy: hoy,
                    selectedDate: selectedDate,
                    isToday: selectedDate === hoy,
                    currentTime: now.toISOString()
                });
                
                availableSlots.forEach(slot => {
                    let shouldSkip = false;
                    
                    // Usar la misma lógica que en el admin
                    if (selectedDate === hoy) {
                        const slotDate = new Date(selectedDate + 'T' + slot.time);
                        console.log(`Slot ${slot.display_time}:`, {
                            slotDate: slotDate.toISOString(),
                            now: now.toISOString(),
                            isPast: slotDate <= now
                        });
                        
                        if (slotDate <= now) {
                            shouldSkip = true;
                        }
                    }
                    
                    // Solo agregar el slot si no debe saltarse
                    if (!shouldSkip) {
                        slotsHTML += `<button class="time-slot" data-time="${slot.time}">${slot.display_time}</button>`;
                    }
                });
            }
            
            timeSlotsContainer.innerHTML = slotsHTML;
            
            // Add click handlers to time slots
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.addEventListener('click', () => {
                    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                    slot.classList.add('selected');
                    selectedTime = slot.dataset.time;
                    
                    // Actualizar resumen de hora
                    document.getElementById('summary-time').textContent = slot.textContent;
                    
                    checkStep3();
                });
            });
        }

        function checkStep3() {
            const dateSelected = selectedDate;
            const timeSelected = selectedTime;
            const btnNext3 = document.getElementById('btn-next-3');
            const isEnabled = dateSelected && timeSelected;
            btnNext3.disabled = !isEnabled;
            btnNext3.setAttribute('aria-disabled', isEnabled ? 'false' : 'true');
            // Si ambos están seleccionados y el usuario está en el paso 3, avanzar automáticamente
            if (isEnabled && document.getElementById('step-3').classList.contains('active')) {
                setTimeout(() => goToStep(4), 200);
            }
        }

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const category = btn.dataset.category;
                
                document.querySelectorAll('#services-grid .selection-card').forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Navigation
        function goToStep(stepNumber) {
            document.querySelectorAll('.booking-step').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.progress-steps .step').forEach((s, i) => {
                s.classList.remove('active', 'completed');
                if (i + 1 < stepNumber) s.classList.add('completed');
                if (i + 1 === stepNumber) s.classList.add('active');
            });
            document.querySelectorAll('.step-line').forEach((l, i) => {
                l.classList.toggle('completed', i + 1 < stepNumber);
            });
            document.getElementById(`step-${stepNumber}`).classList.add('active');
            
            // Initialize calendar when going to step 3
            if (stepNumber === 3) {
                generateCalendar();
                if (selectedBarber && selectedBarber !== 'any') {
                    document.getElementById('time-slots').innerHTML = '<div style="text-align: center; padding: 1rem; color: #666;">Selecciona una fecha para ver horarios disponibles</div>';
                }
            }
        }

        document.getElementById('btn-next-1').addEventListener('click', () => {
            if (!barberAvailable) return;
            goToStep(2);
        });
        document.getElementById('btn-next-2').addEventListener('click', () => goToStep(3));
        document.getElementById('btn-next-3').addEventListener('click', () => goToStep(4));
        document.getElementById('btn-next-4').addEventListener('click', () => goToStep(5));
        document.getElementById('btn-back-2').addEventListener('click', () => goToStep(1));
        document.getElementById('btn-back-3').addEventListener('click', () => goToStep(2));
        document.getElementById('btn-back-4').addEventListener('click', () => goToStep(3));
        document.getElementById('btn-back-5').addEventListener('click', () => goToStep(4));
        
        // Payment option logic
        document.querySelectorAll('input[name="payment-option"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const qrSection = document.getElementById('qr-payment');
                const summaryPaymentInfo = document.getElementById('summary-payment-info');
                const summaryPayment = document.getElementById('summary-payment');
                
                if (this.value === 'with-payment') {
                    qrSection.style.display = 'block';
                    summaryPaymentInfo.style.display = 'flex';
                    summaryPayment.textContent = '$10.000 - Pendiente Verificación';
                    
                    // Cargar QR codes con timestamp para evitar cache
                    loadQRCodes();
                } else {
                    qrSection.style.display = 'none';
                    summaryPaymentInfo.style.display = 'none';
                }
            });
        });

        // Función para cargar QR codes
        function loadQRCodes() {
            console.log('Iniciando carga de QR codes...');
            const timestamp = new Date().getTime();
            
            // Cargar QR de Nequi - Verificar si existe
            const nequiImg = document.getElementById('nequi-qr');
            if (nequiImg) {
                console.log('Elemento nequi-qr encontrado, cargando...');
                nequiImg.onload = function() {
                    console.log('QR de Nequi cargado exitosamente');
                };
                nequiImg.onerror = function() {
                    console.warn('Error cargando QR de Nequi desde src:', this.src);
                };
                // Forzar recarga agregando timestamp
                const currentSrc = nequiImg.src;
                const newSrc = currentSrc.split('?')[0] + `?v=${timestamp}`;
                nequiImg.src = newSrc;
                console.log('Nequi QR src actualizado a:', newSrc);
            } else {
                console.log('Elemento nequi-qr no encontrado - QR no disponible');
            }
            
            // Cargar QR de DaviPlata - Verificar si existe
            const daviplataImg = document.getElementById('daviplata-qr');
            if (daviplataImg) {
                console.log('Elemento daviplata-qr encontrado, cargando...');
                daviplataImg.onload = function() {
                    console.log('QR de DaviPlata cargado exitosamente');
                };
                daviplataImg.onerror = function() {
                    console.warn('Error cargando QR de DaviPlata desde src:', this.src);
                };
                // Forzar recarga agregando timestamp
                const currentSrc = daviplataImg.src;
                const newSrc = currentSrc.split('?')[0] + `?v=${timestamp}`;
                daviplataImg.src = newSrc;
                console.log('DaviPlata QR src actualizado a:', newSrc);
            } else {
                console.log('Elemento daviplata-qr no encontrado - QR no disponible');
            }

            // Cargar QR de Bancolombia
            const bancolombiaImg = document.getElementById('bancolombia-qr');
            if (bancolombiaImg) {
                const currentSrc = bancolombiaImg.src;
                bancolombiaImg.src = currentSrc.split('?')[0] + `?v=${timestamp}`;
            }

            // Lógica de los botones selectores de método
            document.querySelectorAll('.qr-method-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const method = this.dataset.method;
                    // Ocultar todos los paneles y desactivar botones
                    document.querySelectorAll('.qr-panel').forEach(p => p.style.display = 'none');
                    document.querySelectorAll('.qr-method-btn').forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-pressed', 'false');
                    });
                    // Mostrar el panel seleccionado
                    const panel = document.getElementById('panel-' + method);
                    if (panel) panel.style.display = 'block';
                    this.classList.add('active');
                    this.setAttribute('aria-pressed', 'true');
                });
            });
        }

        // ------ Validación en tiempo real de campos del formulario ------
        function showFieldError(fieldId, message) {
            const input = document.getElementById(fieldId);
            const err = document.getElementById(fieldId + '-error');
            if (input) input.classList.add('input-error');
            if (err) { err.textContent = message; err.style.display = 'block'; }
        }

        function clearFieldError(fieldId) {
            const input = document.getElementById(fieldId);
            const err = document.getElementById(fieldId + '-error');
            if (input) input.classList.remove('input-error');
            if (err) { err.textContent = ''; err.style.display = 'none'; }
        }

        function validateCedula() {
                    const v = document.getElementById('client-cedula').value.trim();
                    if (!v) { showFieldError('client-cedula', 'La cédula es obligatoria.'); return false; }
                    if (!/^[0-9]+$/.test(v)) { showFieldError('client-cedula', 'Cédula inválida: solo números.'); return false; }
                    if (v.length < 5 || v.length > 10) { showFieldError('client-cedula', 'Cédula inválida: debe tener entre 5 y 10 dígitos.'); return false; }
                    clearFieldError('client-cedula');
                    return true;
        }

        function validatePhone() {
                    const v = document.getElementById('client-phone').value.trim();
                    if (!v) { showFieldError('client-phone', 'El teléfono es obligatorio.'); return false; }
                    if (!/^[0-9]+$/.test(v)) { showFieldError('client-phone', 'Teléfono inválido: solo números.'); return false; }
                    // Debe comenzar con 3 y tener exactamente 10 dígitos
                    if (!/^3[0-9]{9}$/.test(v)) { showFieldError('client-phone', 'Teléfono inválido: debe comenzar con 3 y tener 10 dígitos.'); return false; }
                    clearFieldError('client-phone');
                    return true;
        }

        function validateEmail() {
            const v = document.getElementById('client-email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!v) { showFieldError('client-email', 'El correo es obligatorio.'); return false; }
            if (!emailRegex.test(v)) { showFieldError('client-email', 'Correo inválido.'); return false; }
            clearFieldError('client-email');
            return true;
        }

        function validateName() {
            const v = document.getElementById('client-name').value.trim();
            if (!v) { showFieldError('client-name', 'El nombre es obligatorio.'); return false; }
            if (v.length < 3) { showFieldError('client-name', 'Ingresa tu nombre completo.'); return false; }
            clearFieldError('client-name');
            return true;
        }

        // Attach real-time validators when DOM loaded
        document.addEventListener('DOMContentLoaded', function() {
            const ced = document.getElementById('client-cedula'); if (ced) { ced.addEventListener('input', validateCedula); ced.addEventListener('blur', validateCedula); }
            const phone = document.getElementById('client-phone'); if (phone) { phone.addEventListener('input', validatePhone); phone.addEventListener('blur', validatePhone); }
            const mail = document.getElementById('client-email'); if (mail) { mail.addEventListener('input', validateEmail); mail.addEventListener('blur', validateEmail); }
            const name = document.getElementById('client-name'); if (name) { name.addEventListener('input', validateName); name.addEventListener('blur', validateName); }
        });
        
        // Flag para prevenir múltiples envíos
        let isSubmitting = false;

        // Consentimiento: controlar habilitación del botón confirm
        (function setupConsent() {
            const acceptTerms = document.getElementById('accept-terms');
            const btnConfirmInit = document.getElementById('btn-confirm');
            if (!btnConfirmInit) return;
            if (acceptTerms) {
                // Asegurar estado inicial
                btnConfirmInit.disabled = !acceptTerms.checked;
                btnConfirmInit.setAttribute('aria-disabled', acceptTerms.checked ? 'false' : 'true');

                acceptTerms.addEventListener('change', function() {
                    btnConfirmInit.disabled = !this.checked;
                    btnConfirmInit.setAttribute('aria-disabled', this.checked ? 'false' : 'true');
                    if (this.checked) {
                        // desplazar el botón confirmar al centro de la pantalla para que sea visible
                        setTimeout(() => {
                            btnConfirmInit.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            btnConfirmInit.focus({ preventScroll: true });
                        }, 120);
                    }
                });
            }
        })();

        // Modal de términos: abrir al hacer clic en el enlace
        (function setupTermsModal() {
            const openLink = document.getElementById('open-terms-modal');
            const modal = document.getElementById('terms-modal');
            const modalBody = document.getElementById('terms-modal-body');
            const tpl = document.getElementById('terms-template');
            const btnClose = document.getElementById('terms-close');
            const btnAccept = document.getElementById('terms-accept');
            const btnDownload = document.getElementById('terms-download');
            const overlay = document.getElementById('terms-modal-overlay');

            if (!openLink || !modal || !tpl) return;

            function openModal() {
                // Cargar texto
                const raw = tpl.textContent || tpl.innerText || '';
                // Render simple HTML: reemplazar saltos de línea por <br> y mantener negritas
                const html = raw.replace(/\n/g, '<br>');
                modalBody.innerHTML = html;
                modal.style.display = 'block';
                // focus
                setTimeout(() => modalBody.focus(), 50);
            }

            function closeModal() {
                modal.style.display = 'none';
            }

            openLink.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });

            if (btnClose) btnClose.addEventListener('click', closeModal);
            if (overlay) overlay.addEventListener('click', closeModal);

            if (btnAccept) btnAccept.addEventListener('click', function() {
                const acceptTerms = document.getElementById('accept-terms');
                if (acceptTerms) {
                    acceptTerms.checked = true;
                    acceptTerms.dispatchEvent(new Event('change'));
                }
                closeModal();
                // scroll to confirm button
                const btnConfirm = document.getElementById('btn-confirm');
                if (btnConfirm) { btnConfirm.scrollIntoView({ behavior: 'smooth', block: 'center' }); btnConfirm.focus({ preventScroll: true }); }
            });

            if (btnDownload) btnDownload.addEventListener('click', function() {
                const downloadUrl = btnDownload.dataset.downloadUrl || '/terminos/descargar';
                const viewUrl = '/terminos';
                // Intentar HEAD al PDF; si existe abrirlo, si no abrir la vista HTML
                fetch(downloadUrl, { method: 'HEAD' }).then(resp => {
                    if (resp.ok) {
                        window.open(downloadUrl, '_blank');
                    } else {
                        window.open(viewUrl, '_blank');
                    }
                }).catch(() => {
                    window.open(viewUrl, '_blank');
                });
            });

            // close on Escape
            document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && modal.style.display === 'block') closeModal(); });
        })();

        document.getElementById('btn-confirm').addEventListener('click', () => {
            // Validar campos requeridos (se mostrará retroalimentación centralizada)
            const clientName = document.getElementById('client-name').value.trim();
            const clientCedula = document.getElementById('client-cedula').value.trim();
            const clientPhone = document.getElementById('client-phone').value.trim();
            const clientEmail = document.getElementById('client-email').value.trim();
            const clientBirthdate = document.getElementById('client-birthdate').value;

            // Check if payment option was selected
            const paymentOption = document.querySelector('input[name="payment-option"]:checked').value;
            const hasPayment = paymentOption === 'with-payment';
            const transactionRef = hasPayment ? document.getElementById('transaction-reference').value.trim() : null;

            // Prevenir envíos múltiples
            if (isSubmitting) {
                console.warn('Enviando... por favor espera');
                return;
            }

            // Obtener el botón
            const btnConfirm = document.getElementById('btn-confirm');
            const originalHTML = btnConfirm.innerHTML;

            // Desactivar botón y mostrar loading
            isSubmitting = true;
            btnConfirm.disabled = true;
            btnConfirm.style.opacity = '0.6';
            btnConfirm.style.pointerEvents = 'none';
            btnConfirm.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite; display: inline-block; margin-right: 8px;">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
                Guardando Cita...
            `;

            // Agregar estilos de animación si no existen
            if (!document.querySelector('style[data-spinner]')) {
                const style = document.createElement('style');
                style.setAttribute('data-spinner', 'true');
                style.textContent = `
                    @keyframes spin {
                        from { transform: rotate(0deg); }
                        to { transform: rotate(360deg); }
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Client-side validation before submit
            const feedback = document.getElementById('booking-feedback');
            function showFeedback(html) {
                if (feedback) {
                    feedback.innerHTML = html;
                    feedback.style.display = 'block';
                    feedback.classList.add('alert', 'alert-danger');
                    feedback.focus && feedback.focus();
                    window.scrollTo({ top: feedback.getBoundingClientRect().top + window.scrollY - 80, behavior: 'smooth' });
                } else {
                    alert(html.replace(/<[^>]+>/g, '\n'));
                }
            }

            // Clear previous feedback
            if (feedback) { feedback.style.display = 'none'; feedback.innerHTML = ''; feedback.classList.remove('alert','alert-danger'); }

            const errors = [];
            if (!clientName) errors.push('Ingresa tu nombre completo.');
            if (!clientCedula || !/^[0-9]+$/.test(clientCedula)) errors.push('Ingresa una cédula válida (solo números).');
            if (!clientPhone || !/^[0-9]+$/.test(clientPhone)) errors.push('Ingresa un teléfono válido (solo números).');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!clientEmail || !emailRegex.test(clientEmail)) errors.push('Ingresa un correo electrónico válido.');
            if (!selectedDate || !selectedTime) errors.push('Selecciona fecha y hora disponibles.');
            if (!selectedService) errors.push('Selecciona un servicio.');
            if (hasPayment && !transactionRef) errors.push('Por favor, ingresa el número de transacción para confirmar el pago.');
            const acceptTerms = document.getElementById('accept-terms');
            if (!acceptTerms || !acceptTerms.checked) errors.push('Debes aceptar la política de privacidad para continuar.');

            if (errors.length > 0) {
                showFeedback('<ul style="margin:0 0 0 1.1rem;padding:0.4rem 0">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>');
                isSubmitting = false;
                btnConfirm.disabled = false;
                btnConfirm.style.opacity = '1';
                btnConfirm.style.pointerEvents = 'auto';
                btnConfirm.innerHTML = originalHTML;
                return;
            }

            // Gather booking data
            const bookingData = {
                barber: selectedBarber,
                type: selectedService.type,
                serv_id: selectedService.id,
                combo_id: null,
                date: selectedDate,
                time: selectedTime,
                client_name: clientName,
                client_cedula: clientCedula,
                client_phone: clientPhone,
                client_email: clientEmail ? clientEmail : null,
                client_birthdate: clientBirthdate || null,
                has_payment: hasPayment,
                transaction_reference: hasPayment ? document.getElementById('transaction-reference').value : null,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            console.log('Enviando datos:', bookingData);

            // Submit booking
            fetch('/agendar-cita', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(bookingData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(errJson => { throw { status: response.status, body: errJson }; });
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Personalizar mensaje según si hay anticipo o no
                    const successTitle = document.getElementById('success-title');
                    const successText = document.getElementById('success-text');
                    
                    // Información del barbero asignado
                    let barberoInfo = '';
                    if (data.barbero_asignado && data.barbero_asignado.fue_asignado_automaticamente) {
                        barberoInfo = `<br><br><strong>✨ Barbero asignado:</strong> ${data.barbero_asignado.nombre}`;
                    }
                    
                    if (hasPayment) {
                        // Con anticipo - esperando confirmación
                        successTitle.textContent = 'Cita por Confirmar Anticipo';
                        successText.innerHTML = `
                            Tu solicitud de cita ha sido recibida exitosamente. <br><br>
                            <strong>Hemos registrado tu pago de $10,000 COP</strong> y estamos verificando la transacción. <br><br>
                            <span style="color: #d4a853; font-weight: 600;">📧 Te enviaremos un correo electrónico confirmando tu cita una vez verifiquemos el anticipo.</span>
                            ${barberoInfo}
                            <br><br>
                            Gracias por tu confianza en H Barber Shop.
                        `;
                    } else {
                        // Sin anticipo - confirmación normal
                        successTitle.textContent = 'Cita Confirmada';
                        successText.innerHTML = `
                            Tu cita ha sido agendada exitosamente. <br><br>
                            Te esperamos puntual para brindarte la mejor experiencia en H Barber Shop.
                            ${barberoInfo}
                        `;
                    }
                    
                    document.querySelectorAll('.booking-step').forEach(s => s.classList.remove('active'));
                    document.getElementById('step-success').classList.add('active');
                } else {
                    // Mostrar mensaje de error unificado
                    showFeedback('<strong>Error:</strong> ' + (data.message || 'No se pudo agendar la cita.'));
                    // Restaurar botón en caso de error
                    isSubmitting = false;
                    btnConfirm.disabled = false;
                    btnConfirm.style.opacity = '1';
                    btnConfirm.style.pointerEvents = 'auto';
                    btnConfirm.innerHTML = originalHTML;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Manejo de errores HTTP/validación
                if (error && error.status === 422 && error.body && error.body.errors) {
                    const msgs = Object.values(error.body.errors).flat().map(m => '<li>' + m + '</li>').join('');
                    showFeedback('<strong>Errores de validación:</strong><ul style="margin:0 0 0 1.1rem;padding:0.4rem 0">' + msgs + '</ul>');
                } else if (error && error.body && error.body.message) {
                    showFeedback('<strong>Error:</strong> ' + (error.body.message));
                } else {
                    showFeedback('<strong>Error:</strong> Error al procesar la solicitud. Intenta de nuevo.');
                }
                // Restaurar botón en caso de error
                isSubmitting = false;
                btnConfirm.disabled = false;
                btnConfirm.style.opacity = '1';
                btnConfirm.style.pointerEvents = 'auto';
                btnConfirm.innerHTML = originalHTML;
            });
        });

        // Función para copiar número al portapapeles
        document.addEventListener('click', function(e) {
            const phoneBox = e.target.closest('[data-copy-phone]');
            if (phoneBox) {
                const phone = '3118104544';
                navigator.clipboard.writeText(phone).then(function() {
                    const originalText = phoneBox.innerHTML;
                    phoneBox.innerHTML = '<span style="color: #2e7d32; font-size: 16px;">✓ ¡Número copiado!</span>';
                    setTimeout(function() {
                        phoneBox.innerHTML = originalText;
                    }, 2000);
                }).catch(function(err) {
                    console.error('Error al copiar:', err);
                    alert('Número: 3118104544');
                });
            }
        });
        // Initialize calendar on page load
        generateCalendar();