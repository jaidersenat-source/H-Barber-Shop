@extends('layouts.blog')

@section('og_type', 'website')

@section('content')
@vite(['resources/css/Home/Politicas.css'])

<!-- Hero -->
<section class="politicas-hero" role="banner" aria-label="Encabezado de la página de políticas legales">
    <div class="politicas-hero-content">
        <span class="hero-badge">Documento Legal Oficial</span>
        <h1>Aviso Legal &amp; <span>Políticas Institucionales</span></h1>
        <p>H BARBER SHOP S.A.S. &nbsp;·&nbsp; NIT: 901.814.813-3 &nbsp;·&nbsp; Versión 2.0 &nbsp;·&nbsp; Neiva, Huila, Colombia &nbsp;·&nbsp; Abril 2026</p>
    </div>
</section>

<!-- Navegación de secciones -->
<nav class="politicas-nav" aria-label="Índice de secciones legales" id="politicas-nav-bar">
    <div class="politicas-nav-inner">
        <a href="#datos-personales" data-section="datos-personales">I. Datos Personales</a>
        <a href="#privacidad-cookies" data-section="privacidad-cookies">II. Privacidad y Cookies</a>
        <a href="#terminos-condiciones" data-section="terminos-condiciones">III. Términos y Condiciones</a>
    </div>
</nav>

<div class="politicas-main">
<div class="politicas-container">

    <div class="politicas-grid">
        <aside class="politicas-aside" aria-label="Índice y datos de la empresa">

            <!-- Tarjeta empresa -->
            <div class="politicas-id-card" role="region" aria-label="Datos de identificación de la empresa">
                <div class="id-card-header">
                    <div class="id-card-logo" aria-hidden="true">H</div>
                    <div class="id-card-brand">
                        <strong>H BARBER SHOP S.A.S.</strong>
                        <span>NIT 901.814.813-3</span>
                    </div>
                </div>
                <div class="id-card-grid">
                    <div class="id-field">
                        <span class="id-label">Representante Legal</span>
                        <span class="id-value">Angie Katerine Hernández Villamil</span>
                    </div>
                    <div class="id-field">
                        <span class="id-label">Dirección</span>
                        <span class="id-value">Calle 50 #21A-05, Álamos Norte, Neiva, Huila</span>
                    </div>
                    <div class="id-field">
                        <span class="id-label">Teléfono / WhatsApp</span>
                        <span class="id-value"><a href="tel:+573118104544">311 810 4544</a></span>
                    </div>
                    <div class="id-field">
                        <span class="id-label">Correo electrónico</span>
                        <span class="id-value"><a href="mailto:hbarbershopsas@gmail.com">hbarbershopsas@gmail.com</a></span>
                    </div>
                    <div class="id-field">
                        <span class="id-label">Sitio web</span>
                        <span class="id-value"><a href="https://www.hbarbershop.co" target="_blank" rel="noopener">www.hbarbershop.co</a></span>
                    </div>
                </div>
            </div>

            <!-- TOC con scrollspy -->
            <nav class="politicas-aside-toc" aria-label="Tabla de contenidos de las políticas">
                <p class="toc-title">En este documento</p>
                <ul>
                    <li>
                        <a href="#datos-personales" data-toc="datos-personales">
                            <span class="toc-num">I</span>
                            Política de Tratamiento de Datos
                        </a>
                    </li>
                    <li>
                        <a href="#privacidad-cookies" data-toc="privacidad-cookies">
                            <span class="toc-num">II</span>
                            Privacidad y Cookies
                        </a>
                    </li>
                    <li>
                        <a href="#terminos-condiciones" data-toc="terminos-condiciones">
                            <span class="toc-num">III</span>
                            Términos y Condiciones
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- CTA -->
            <a href="{{ route('agendar') }}" class="aside-cta" aria-label="Ir a agendar una cita">
                Agendar mi cita &rarr;
            </a>

        </aside>

        <div class="politicas-content">

    <!-- ─────────────────────────────────────────────────────────────────
         SECCIÓN I: POLÍTICA DE TRATAMIENTO DE DATOS PERSONALES
    ───────────────────────────────────────────────────────────────────── -->
    <section id="datos-personales" class="politica-seccion" role="region" aria-labelledby="titulo-datos">
        <div class="seccion-header">
            <span class="seccion-num">I</span>
            <h2 id="titulo-datos">Política de Tratamiento de Datos Personales</h2>
        </div>
        <p class="seccion-intro">En cumplimiento de la Ley Estatutaria 1581 de 2012, el Decreto Reglamentario 1377 de 2013 y demás normas concordantes, H BARBER SHOP S.A.S. adopta la presente Política de Tratamiento de Datos Personales, con el fin de garantizar la privacidad, confidencialidad y seguridad de la información suministrada por sus clientes, colaboradores y demás titulares de datos personales.</p>

        <div class="politica-bloque">
            <h3>1.1. Responsable del Tratamiento</h3>
            <ul class="info-list">
                <li><strong>Razón social:</strong> H BARBER SHOP S.A.S.</li>
                <li><strong>NIT:</strong> 901.814.813-3</li>
                <li><strong>Representante Legal:</strong> Angie Katerine Hernández Villamil</li>
                <li><strong>Dirección:</strong> Calle 50 #21A-05, Álamos Norte, Neiva, Huila</li>
                <li><strong>Teléfono:</strong> 311 810 4544</li>
                <li><strong>Correo electrónico:</strong> hbarbershopsas@gmail.com</li>
                <li><strong>Sitio web:</strong> www.hbarbershop.co</li>
            </ul>
        </div>

        <div class="politica-bloque">
            <h3>1.2. Datos Personales que se Recopilan</h3>
            <p>A través del sitio web y en el establecimiento físico, la Empresa podrá recopilar:</p>
            <ul>
                <li>Nombre completo y datos de identificación.</li>
                <li>Número de teléfono celular y/o fijo.</li>
                <li>Dirección de correo electrónico.</li>
                <li>Fecha y hora de citas agendadas.</li>
                <li>Historial de servicios solicitados.</li>
                <li>Preferencias y observaciones manifestadas por el cliente.</li>
                <li>Datos de navegación en el sitio web (a través de cookies y herramientas de análisis).</li>
            </ul>
        </div>

        <div class="politica-bloque">
            <h3>1.3. Finalidades del Tratamiento</h3>
            <p>Los datos personales recopilados serán utilizados exclusivamente para:</p>
            <ul>
                <li>Gestionar el agendamiento, confirmación y seguimiento de citas.</li>
                <li>Brindar atención al cliente y dar respuesta a solicitudes, quejas o inquietudes.</li>
                <li>Enviar comunicaciones sobre novedades, promociones y servicios, previa autorización del titular.</li>
                <li>Mejorar la experiencia del usuario en el sitio web y en el establecimiento.</li>
                <li>Cumplir con obligaciones legales, tributarias y contables.</li>
                <li>Analizar el comportamiento de navegación para optimizar los servicios digitales.</li>
            </ul>
        </div>

        <div class="politica-bloque">
            <h3>1.4. Derechos de los Titulares</h3>
            <p>De conformidad con el artículo 8 de la Ley 1581 de 2012, los titulares tienen los siguientes derechos:</p>
            <ul>
                <li>Conocer, actualizar y rectificar sus datos personales en cualquier momento.</li>
                <li>Solicitar prueba de la autorización otorgada para el tratamiento de sus datos.</li>
                <li>Ser informado sobre el uso que se ha dado a sus datos personales.</li>
                <li>Presentar quejas ante la Superintendencia de Industria y Comercio (SIC) por infracciones a la normativa de protección de datos.</li>
                <li>Revocar la autorización otorgada y/o solicitar la supresión de sus datos, siempre que no exista obligación legal que lo impida.</li>
                <li>Acceder de forma gratuita a sus datos personales que hayan sido objeto de tratamiento.</li>
            </ul>
        </div>

        <div class="politica-bloque">
            <h3>1.5. Canal para el Ejercicio de Derechos</h3>
            <p>Para ejercer cualquiera de los derechos anteriores:</p>
            <ul>
                <li><strong>Correo electrónico:</strong> <a href="mailto:hbarbershopsas@gmail.com">hbarbershopsas@gmail.com</a></li>
                <li><strong>Teléfono/WhatsApp:</strong> 311 810 4544</li>
                <li><strong>Dirección física:</strong> Calle 50 #21A-05, Álamos Norte, Neiva, Huila</li>
            </ul>
            <p>La Empresa atenderá las solicitudes en un plazo máximo de <strong>quince (15) días hábiles</strong> contados a partir de la fecha de recepción.</p>
        </div>

        <div class="politica-bloque">
            <h3>1.6. Seguridad de la Información</h3>
            <p>H BARBER SHOP S.A.S. implementa las medidas técnicas, humanas y administrativas necesarias para garantizar la seguridad de los datos personales y evitar su adulteración, pérdida, consulta, uso o acceso no autorizado o fraudulento.</p>
        </div>

        <div class="politica-bloque">
            <h3>1.7. Vigencia de la Política</h3>
            <p>La presente política entra en vigencia a partir de su publicación en el sitio web <strong>www.hbarbershop.co</strong>. Cualquier modificación sustancial será informada a los titulares con antelación.</p>
        </div>
    </section>

        </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────────
         SECCIÓN II: POLÍTICA DE PRIVACIDAD Y COOKIES
    ───────────────────────────────────────────────────────────────────── -->
    <section id="privacidad-cookies" class="politica-seccion" role="region" aria-labelledby="titulo-privacidad">
        <div class="seccion-header">
            <span class="seccion-num">II</span>
            <h2 id="titulo-privacidad">Política de Privacidad y Cookies</h2>
        </div>
        <p class="seccion-intro">H BARBER SHOP S.A.S. se compromete a proteger la privacidad de los usuarios que visitan el sitio web www.hbarbershop.co. La presente política describe cómo se recopila, utiliza y protege la información generada durante la navegación.</p>

        <div class="politica-bloque">
            <h3>2.1. Información Recopilada Automáticamente</h3>
            <p>Cuando el usuario navega por www.hbarbershop.co, el sitio web puede recopilar automáticamente:</p>
            <ul>
                <li>Dirección IP del dispositivo utilizado.</li>
                <li>Tipo de navegador y sistema operativo.</li>
                <li>Páginas visitadas y tiempo de permanencia en cada sección.</li>
                <li>Fuente de acceso al sitio (búsqueda orgánica, redes sociales, enlace directo, etc.).</li>
                <li>Interacciones con el formulario de agendamiento y el formulario de contacto.</li>
            </ul>
        </div>

        <div class="politica-bloque">
            <h3>2.2. ¿Qué Son las Cookies?</h3>
            <p>Las cookies son pequeños archivos de texto que los sitios web almacenan en el dispositivo del usuario con el fin de mejorar la experiencia de navegación, recordar preferencias y recopilar información estadística. No contienen información personal sensible ni ejecutan programas en el dispositivo del usuario.</p>
        </div>

        <div class="politica-bloque">
            <h3>2.3. Tipos de Cookies Utilizadas</h3>
            <div class="cookies-grid">
                <div class="cookie-card cookie-card--essential">
                    <div class="cookie-icon">🔒</div>
                    <h4>Cookies técnicas o esenciales</h4>
                    <p>Necesarias para el correcto funcionamiento del sitio web, incluyendo el formulario de agendamiento y el formulario de contacto. Sin estas cookies, algunos servicios no estarán disponibles.</p>
                    <span class="cookie-badge cookie-badge--required">Siempre activas</span>
                </div>
                <div class="cookie-card cookie-card--analytics">
                    <div class="cookie-icon">📊</div>
                    <h4>Cookies analíticas (Google Analytics)</h4>
                    <p>Permiten analizar el comportamiento de los usuarios en el sitio de forma anónima y agregada, con el fin de mejorar el servicio.</p>
                    <span class="cookie-badge cookie-badge--optional">Requieren consentimiento</span>
                </div>
                <div class="cookie-card cookie-card--marketing">
                    <div class="cookie-icon">📢</div>
                    <h4>Cookies de marketing (Píxel de Meta)</h4>
                    <p>Permiten medir la efectividad de campañas publicitarias en redes sociales (Facebook/Instagram) y personalizar los anuncios dirigidos a usuarios que han visitado el sitio.</p>
                    <span class="cookie-badge cookie-badge--optional">Requieren consentimiento</span>
                </div>
            </div>
        </div>

        <div class="politica-bloque">
            <h3>2.4. Gestión y Control de Cookies</h3>
            <p>El usuario puede configurar su navegador para aceptar, rechazar o eliminar las cookies almacenadas en su dispositivo. Sin embargo, desactivar ciertas cookies puede afectar el funcionamiento de algunas secciones del sitio.</p>
        </div>

        <div class="politica-bloque">
            <h3>2.5. Servicios de Terceros y Pagos</h3>
            <p>El sitio puede contener integraciones con servicios de terceros como redes sociales y plataformas de mensajería. H BARBER SHOP S.A.S. no se hace responsable por las políticas de privacidad de dichos terceros.</p>
            <p>En relación con los pagos, el sitio ofrece visualización de código QR bancario. Este proceso ocurre directamente en la plataforma del banco correspondiente, por lo cual H BARBER SHOP S.A.S. <strong>no almacena ni accede a datos financieros o bancarios del usuario</strong>.</p>
        </div>

        <div class="politica-bloque">
            <h3>2.6. Modificaciones</h3>
            <p>H BARBER SHOP S.A.S. se reserva el derecho de modificar esta política en cualquier momento, publicando la versión actualizada en el sitio web con indicación de la fecha de actualización.</p>
        </div>
    </section>

    <!-- ─────────────────────────────────────────────────────────────────
         SECCIÓN III: TÉRMINOS Y CONDICIONES DE USO DEL SITIO WEB
    ───────────────────────────────────────────────────────────────────── -->
    <section id="terminos-condiciones" class="politica-seccion" role="region" aria-labelledby="titulo-terminos">
        <div class="seccion-header">
            <span class="seccion-num">III</span>
            <h2 id="titulo-terminos">Términos y Condiciones de Uso del Sitio Web</h2>
        </div>
        <p class="seccion-intro">Los presentes Términos y Condiciones regulan el acceso y uso del sitio web www.hbarbershop.co, así como la contratación de los servicios ofrecidos por H BARBER SHOP S.A.S. Al acceder y utilizar este sitio, el usuario declara haber leído, comprendido y aceptado estos términos en su totalidad.</p>

        <div class="politica-bloque">
            <h3>3.1. Servicios Ofrecidos</h3>
            <p>El sitio web facilita información sobre los servicios de barbería y cuidado personal, así como el agendamiento de citas. Los servicios disponibles incluyen, entre otros:</p>
            <ul>
                <li>Cortes de cabello para caballero.</li>
                <li>Mantenimiento y diseño de barba.</li>
                <li>Diseño y perfilado de cejas.</li>
                <li>Limpieza e hidratación facial.</li>
                <li>Servicios ejecutivos integrales.</li>
                <li>Venta de productos de belleza y cuidado personal.</li>
            </ul>
            <p>La oferta está sujeta a disponibilidad y puede modificarse sin previo aviso.</p>
        </div>

        <div class="politica-bloque">
            <h3>3.2. Agendamiento de Citas</h3>
            <p>El usuario podrá solicitar citas a través del formulario de agendamiento disponible en el sitio. La confirmación se realizará a través del canal de contacto proporcionado. H BARBER SHOP S.A.S. se reserva el derecho de cancelar o reprogramar citas en casos de fuerza mayor.</p>
        </div>

        <div class="politica-bloque">
            <h3>3.3. Política de Cancelación</h3>
            <div class="alerta-box alerta-box--warning">
                <strong>⚠️ Importante:</strong> El cliente debe notificar cancelaciones o cambios con al menos <strong>dos (2) horas de anticipación</strong>. La inasistencia reiterada sin aviso previo podrá dar lugar a restricciones en el agendamiento futuro.
            </div>
        </div>

        <div class="politica-bloque">
            <h3>3.4. Medios de Pago</h3>
            <p>Los servicios se cancelan al momento de la atención en el establecimiento. El código QR bancario visible en el sitio es solo una referencia de pago. H BARBER SHOP S.A.S. <strong>no procesa ni almacena datos bancarios</strong> de sus clientes.</p>
        </div>

        <div class="politica-bloque">
            <h3>3.5. Propiedad Intelectual</h3>
            <p>Todos los contenidos del sitio web, incluyendo textos, imágenes, logotipos y diseños, son propiedad de H BARBER SHOP S.A.S. y están protegidos por la normativa colombiana e internacional de propiedad intelectual. Queda prohibida su reproducción sin autorización escrita previa.</p>
        </div>

        <div class="politica-bloque">
            <h3>3.6. Limitación de Responsabilidad</h3>
            <p>H BARBER SHOP S.A.S. no será responsable por:</p>
            <ul>
                <li>Interrupciones o fallos técnicos del sitio ajenos a su control.</li>
                <li>Uso indebido del sitio por parte de terceros.</li>
                <li>Inexactitudes en la información proporcionada por el usuario en los formularios.</li>
                <li>Virus u otros elementos tecnológicos nocivos introducidos por terceros.</li>
            </ul>
        </div>

        <div class="politica-bloque">
            <h3>3.7. Legislación Aplicable</h3>
            <p>Los presentes términos se rigen por las leyes de la República de Colombia. Cualquier controversia se somete a la jurisdicción de los jueces competentes de la ciudad de <strong>Neiva, Huila, Colombia</strong>.</p>
        </div>

        <div class="politica-bloque">
            <h3>3.8. Modificaciones</h3>
            <p>H BARBER SHOP S.A.S. puede modificar estos términos en cualquier momento. El uso continuado del sitio implica aceptación de los términos actualizados.</p>
        </div>
    </section>

    <!-- ─── Pie del documento ─── -->
    <div class="politicas-footer-note" role="contentinfo" aria-label="Metadatos del documento legal">
        <div class="politicas-meta-grid">
            <div class="meta-field">
                <span>Versión</span>
                <strong>2.0</strong>
            </div>
            <div class="meta-field">
                <span>Fecha de emisión</span>
                <strong>Abril 2026</strong>
            </div>
            <div class="meta-field">
                <span>Última actualización</span>
                <strong>16 de abril de 2026</strong>
            </div>
            <div class="meta-field">
                <span>Responsable</span>
                <strong>H BARBER SHOP S.A.S.</strong>
            </div>
        </div>

        <div class="politicas-footer-divider" aria-hidden="true"></div>

        <p>Para consultas sobre este documento, escríbenos a <a href="mailto:hbarbershopsas@gmail.com">hbarbershopsas@gmail.com</a> o llámanos al <a href="tel:+573118104544">311 810 4544</a>.</p>

        <div class="politicas-footer-actions">
            <a href="{{ route('agendar') }}" class="politicas-cta" aria-label="Agendar una cita">Agendar cita &rarr;</a>
            <a href="#main-content" class="back-to-top" aria-label="Volver al inicio de la página">↑ Volver arriba</a>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
(function () {
    'use strict';
    var sections = ['datos-personales', 'privacidad-cookies', 'terminos-condiciones'];
    var navLinks  = document.querySelectorAll('[data-section]');
    var tocLinks  = document.querySelectorAll('[data-toc]');

    function getOffset(id) {
        var el = document.getElementById(id);
        return el ? el.getBoundingClientRect().top + window.scrollY - 100 : 0;
    }

    function activate(id) {
        navLinks.forEach(function (a) {
            a.classList.toggle('active', a.dataset.section === id);
        });
        tocLinks.forEach(function (a) {
            a.classList.toggle('active', a.dataset.toc === id);
        });
    }

    function onScroll() {
        var scrollY = window.scrollY;
        var current = sections[0];
        sections.forEach(function (id) {
            if (scrollY >= getOffset(id) - 10) current = id;
        });
        activate(current);
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
@endpush
@endsection
