// JS de turnos movido desde create.blade.php

// Navegación con flechas entre elementos interactivos
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-turnos-create');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    function getFocusables() {
        return Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    }
    modulo.addEventListener('keydown', function(e) {
        const focusables = getFocusables();
        const idx = focusables.indexOf(document.activeElement);
        if (focusables.length === 0 || idx === -1) return;
        if (['ArrowDown','ArrowRight'].includes(e.key)) {
            e.preventDefault();
            const next = focusables[(idx + 1) % focusables.length];
            next.focus();
        } else if (['ArrowUp','ArrowLeft'].includes(e.key)) {
            e.preventDefault();
            const prev = focusables[(idx - 1 + focusables.length) % focusables.length];
            prev.focus();
        }
    });
});

document.getElementById('fecha').addEventListener('change', function(){
    let date = this.value;
    if (!date) return;
    const servicioId = document.getElementById('servicio') ? document.getElementById('servicio').value : '';
    let url = window.turnosAvailableRoute + '?date=' + date;
    if (servicioId) url += '&servicio_id=' + servicioId;
    fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(json => {
            const container = document.getElementById('result');
            container.innerHTML = '';
            if (!json.items || json.items.length === 0) {
                container.innerHTML = '<p>No hay barberos disponibles ese día.</p>';
                return;
            }
            json.items.forEach(item => {
                const div = document.createElement('div');
                div.style.border = "1px solid #ddd"; div.style.padding = "10px"; div.style.marginBottom = "10px";
                let html = '<h3>' + item.barbero + ' (' + item.per_documento + ')</h3>';
                html += '<p>Franja: ' + item.hora_inicio + ' - ' + item.hora_fin + '</p>';

                const start = item.hora_inicio;
                const end = item.hora_fin;

                function toMinutes(t){
                    const [h,m] = t.split(':').map(Number); return h*60 + m;
                }
                function toTime(mins){
                    const h = String(Math.floor(mins/60)).padStart(2,'0');
                    const m = String(mins%60).padStart(2,'0');
                    return h + ':' + m;
                }

                const step = item.step || 40;
                const s = toMinutes(start), e = toMinutes(end);
                const reservados = item.reservados;

                html += '<div>';
                const now = new Date();
                const hoy = now.toISOString().slice(0,10);
                for (let t = s; t + step <= e; t += step) {
                    const slot = toTime(t);
                    if (json.date === hoy) {
                        const slotDate = new Date(json.date + 'T' + slot + ':00');
                        if (slotDate <= now) continue;
                    }
                    let disabled = false;
                    for (let r of reservados) {
                        const rStart = toMinutes(r.hora);
                        const rDur = r.duracion || step;
                        const rEnd = rStart + rDur;
                        if (t < rEnd && (t + step) > rStart) { disabled = true; break; }
                    }
                    html += '<button ' + (disabled ? 'disabled' : '') + ' data-dis="'+item.dis_id+'" data-fecha="'+json.date+'" data-hora="'+slot+'" class="slotBtn" style="margin:4px;">' + slot + (disabled? ' (ocupado)':'') + '</button>';
                }
                html += '</div>';

                div.innerHTML = html;
                container.appendChild(div);
            });

            document.querySelectorAll('.slotBtn').forEach(b => {
                b.addEventListener('click', function(){
                    const dis_id = this.dataset.dis;
                    const fecha = this.dataset.fecha;
                    const hora = this.dataset.hora;
                    mostrarModalTurno({
                        dis_id,
                        fecha,
                        hora
                    });
                });
            });
        })
        .catch(e => {
            document.getElementById('result').innerHTML = '<p>Error al consultar disponibilidades</p>';
        });
});

// Disparar la carga inicial para la fecha por defecto
document.addEventListener('DOMContentLoaded', function(){
    const f = document.getElementById('fecha');
    if (f) f.dispatchEvent(new Event('change'));
    const svc = document.getElementById('servicio');
    if (svc) svc.addEventListener('change', function(){
        if (f) f.dispatchEvent(new Event('change'));
    });
});

// Focus trap dinámico y volver al menú con Esc en create de turnos
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-turnos-create');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    function getFocusables() {
        return Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    }
    function focusTrapHandler(e) {
        const focusables = getFocusables();
        if (focusables.length === 0) return;
        const first = focusables[0];
        const last = focusables[focusables.length - 1];
        if (e.key === 'Tab') {
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
        } else if (e.key === 'Escape') {
            const menu = document.querySelector('.sidebar a');
            if (menu) menu.focus();
        }
    }
    const initialFocus = getFocusables();
    if (initialFocus.length) initialFocus[0].focus();
    modulo.addEventListener('keydown', focusTrapHandler);
    const observer = new MutationObserver(() => {
        if (!modulo.contains(document.activeElement)) {
            const f = getFocusables();
            if (f.length) f[0].focus();
        }
    });
    observer.observe(modulo, { childList: true, subtree: true });
});

// Modal accesible para registrar turno
function mostrarModalTurno(datos) {
    let modal = document.getElementById('modal-turno');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'modal-turno';
        modal.style = 'display:flex;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:10000;align-items:center;justify-content:center;';
        document.body.appendChild(modal);
    }
    modal.innerHTML = `
        <div style="background:#fff;padding:2.5rem 2rem;border-radius:16px;max-width:420px;width:95vw;box-shadow:0 4px 24px rgba(0,0,0,0.18);position:relative;">
            <button type="button" id="cerrar-modal-turno" style="position:absolute;top:12px;right:16px;font-size:1.5rem;background:none;border:none;cursor:pointer;">&times;</button>
            <h3 style="margin-bottom:1.5rem;">Registrar Turno</h3>
            <form id="form-turno-modal">
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="tur_nombre">Nombre del cliente</label>
                    <input type="text" id="tur_nombre" name="tur_nombre" required class="form-control" placeholder="Nombre completo">
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="tur_cedula">Número de cédula</label>
                    <input type="text" id="tur_cedula" name="tur_cedula" class="form-control" placeholder="Ej: 1234567890">
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="tur_celular">Celular</label>
                    <input type="text" id="tur_celular" name="tur_celular" class="form-control" placeholder="Ej: 32145632145">
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label for="tur_fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="text" id="tur_fecha_nacimiento" name="tur_fecha_nacimiento" class="form-control" placeholder="AAAA-MM-DD">
                </div>
                <input type="hidden" name="tur_fecha" value="${datos.fecha}">
                <input type="hidden" name="tur_hora" value="${datos.hora}">
                <input type="hidden" name="dis_id" value="${datos.dis_id}">
                <button type="submit" class="btn btn-primary" style="width:100%;margin-top:1.5rem;">Guardar turno</button>
            </form>
        </div>
    `;
    modal.querySelector('#cerrar-modal-turno').onclick = () => { modal.style.display = 'none'; };
    modal.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };
    modal.style.display = 'flex';
    setTimeout(() => {
        const input = modal.querySelector('input,select,textarea');
        if (input) input.focus();
    }, 100);
    
    const cedulaInput = modal.querySelector('#tur_cedula');
    cedulaInput.addEventListener('blur', function() {
        const cedula = this.value.trim();
        if (cedula.length > 0) {
            fetch(`/admin/api/turnos/buscar-cedula/${cedula}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(json => {
                if (json.success && json.data) {
                    if(json.data.tur_nombre) modal.querySelector('#tur_nombre').value = json.data.tur_nombre;
                    if(json.data.tur_celular) modal.querySelector('#tur_celular').value = json.data.tur_celular;
                    if(json.data.tur_correo) modal.querySelector('#tur_correo').value = json.data.tur_correo;
                    if(json.data.tur_fecha_nacimiento) modal.querySelector('#tur_fecha_nacimiento').value = json.data.tur_fecha_nacimiento;
                }
            });
        }
    });
    
    modal.querySelector('#form-turno-modal').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        fetch(window.turnosStoreRoute, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data
        })
        .then(async r => {
            if (!r.ok) {
                let msg = 'Error al registrar el turno';
                try {
                    const data = await r.clone().json();
                    if (data && data.message) {
                        msg = data.message;
                    } else if (data && data.errors) {
                        msg = Object.values(data.errors).flat().join(' ');
                    }
                } catch {
                    try {
                        const text = await r.text();
                        const match = text.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
                        if (match) msg = match[1].replace(/<[^>]+>/g, '').trim().substring(0, 200);
                    } catch {}
                }
                mostrarModalErrorTurno(msg);
                return;
            }
            
            let resp;
            try {
                resp = await r.clone().json();
                if (resp.success) {
                    modal.style.display = 'none';
                    showTurnoExitoModal(function(){ window.location.reload(); });
                } else {
                    mostrarModalErrorTurno(resp.message || 'Error al registrar el turno');
                }
            } catch {
                modal.style.display = 'none';
                showTurnoExitoModal(function(){ window.location.reload(); });
            }
        })
        .catch(() => mostrarModalErrorTurno('Error al registrar el turno'));
    };
}

// Modal de error para turno
function mostrarModalErrorTurno(msg) {
    let modal = document.getElementById('modal-turno-error');
    if (!modal) return alert(msg);
    document.getElementById('modal-turno-error-msg').textContent = msg;
    modal.style.display = 'flex';
    const closeBtn = modal.querySelector('.modal-turno-error-close');
    const acceptBtn = modal.querySelector('.modal-turno-error-accept');
    function closeModal() {
        modal.style.display = 'none';
        closeBtn.onclick = acceptBtn.onclick = null;
    }
    closeBtn.onclick = acceptBtn.onclick = closeModal;
    setTimeout(() => acceptBtn.focus(), 100);
}

// Modal de éxito para turno registrado
function showTurnoExitoModal(callback) {
    const modal = document.getElementById('modal-turno-exito');
    const closeBtn = modal.querySelector('.modal-turno-exito-close');
    const acceptBtn = modal.querySelector('.modal-turno-exito-accept');
    modal.style.display = 'flex';
    setTimeout(() => acceptBtn.focus(), 100);
    function closeModal() {
        modal.style.display = 'none';
        acceptBtn.onclick = closeBtn.onclick = null;
    }
    acceptBtn.onclick = closeBtn.onclick = function() {
        closeModal();
        if (callback) callback();
    };
}

