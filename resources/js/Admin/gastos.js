// resources/js/Admin/gastos.js
// Script para manejar el modal de confirmación de eliminación de gastos

document.addEventListener('DOMContentLoaded', function () {
    let gastoIdAEliminar = null;
    const modal = document.getElementById('modal-eliminar-gasto');
    const form = document.getElementById('form-eliminar-gasto');
    const btnCancelar = document.getElementById('btn-cancelar-eliminar-gasto');
    const btnConfirmar = document.getElementById('btn-confirmar-eliminar-gasto');
    const descripcionSpan = document.getElementById('gasto-descripcion-eliminar');

    document.querySelectorAll('.btn-delete[data-gasto-id]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            gastoIdAEliminar = this.getAttribute('data-gasto-id');
            const descripcion = this.getAttribute('data-gasto-descripcion');
            const action = this.getAttribute('data-gasto-action');
            form.action = action;
            descripcionSpan.textContent = descripcion;
            modal.classList.add('show');
            modal.removeAttribute('aria-hidden');
            btnConfirmar.focus();
        });
    });

    btnCancelar.addEventListener('click', function () {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    });

    // Cerrar modal con Escape
    document.addEventListener('keydown', function (e) {
        if (modal.classList.contains('show') && e.key === 'Escape') {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        }
    });

    // Evitar submit doble
    form.addEventListener('submit', function () {
        btnConfirmar.disabled = true;
    });
});
