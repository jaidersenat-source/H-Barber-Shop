/**
 * Accessibility Core – Global
 * Compatible con JAWS, NVDA y VoiceOver
 * H Barber Shop – 2026
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        initLiveRegion();
        initTablists();
    });

    /* =====================================================
       REGIÓN VIVA GLOBAL
    ===================================================== */
    function initLiveRegion() {
        if (!document.getElementById('a11y-status')) {
            const region = document.createElement('div');
            region.id = 'a11y-status';
            region.setAttribute('role', 'status');
            region.setAttribute('aria-live', 'polite');
            region.setAttribute('aria-atomic', 'true');
            region.className = 'sr-only';
            document.body.prepend(region);
        }
    }

    function announce(message) {
        const region = document.getElementById('a11y-status');
        if (region) {
            region.textContent = '';
            setTimeout(() => {
                region.textContent = message;
            }, 50);
        }
    }

    /* =====================================================
       TABS / FILTROS ACCESIBLES (GENÉRICO)
       Uso: data-a11y="tablist"
    ===================================================== */
    function initTablists() {
        const tablists = document.querySelectorAll('[data-a11y="tablist"]');

        tablists.forEach(tablist => {
            // Asegura roles correctos
            tablist.setAttribute('role', 'tablist');
            const tabs = tablist.querySelectorAll('[role="tab"]');
            const panels = tablist.parentElement.querySelectorAll('[role="tabpanel"]');

            tabs.forEach((tab, index) => {
                // Asegura aria-controls y aria-labelledby
                let panelId = tab.getAttribute('aria-controls');
                if (!panelId && panels[index]) {
                    panelId = panels[index].id || `tabpanel-${index}`;
                    panels[index].id = panelId;
                    tab.setAttribute('aria-controls', panelId);
                }
                if (panels[index]) {
                    panels[index].setAttribute('role', 'tabpanel');
                    panels[index].setAttribute('aria-labelledby', tab.id || `tab-${index}`);
                }
                tab.id = tab.id || `tab-${index}`;

                tab.setAttribute('aria-selected', tab.getAttribute('aria-selected') || 'false');
                tab.setAttribute('tabindex', tab.getAttribute('aria-selected') === 'true' ? '0' : '-1');

                tab.addEventListener('click', () => activateTab(tab, tabs, panels));
                // Elimina atajos de teclado personalizados para evitar conflicto con JAWS
                // tab.addEventListener('keydown', e => handleTabKeydown(e, tab, tabs));
            });
        });
    }

    function activateTab(tab, tabs, panels) {
        tabs.forEach((t, i) => {
            t.setAttribute('aria-selected', 'false');
            t.setAttribute('tabindex', '-1');
            if (panels && panels[i]) {
                panels[i].setAttribute('hidden', '');
            }
        });

        tab.setAttribute('aria-selected', 'true');
        tab.setAttribute('tabindex', '0');
        tab.focus();

        // Muestra el panel correspondiente
        if (panels) {
            const panelId = tab.getAttribute('aria-controls');
            const panel = Array.from(panels).find(p => p.id === panelId);
            if (panel) {
                panel.removeAttribute('hidden');
            }
        }

        const label = tab.textContent.trim();
        announce(`Sección actual: ${label}`);
    }

    // Se eliminan atajos de teclado personalizados para evitar conflicto con comandos nativos de JAWS y otros lectores
    // El foco y navegación se delegan al navegador y lector de pantalla

    /* =====================================================
       API PÚBLICA
    ===================================================== */
    window.A11y = {
        announce
    };

})();
