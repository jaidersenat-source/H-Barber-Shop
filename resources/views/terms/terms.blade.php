<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Términos y Condiciones - H Barber Shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #1F2937;
            font-size: 10px;
            background: #fff;
        }

        /* ── PORTADA / HEADER ── */
        .cover-header {
            background: #0A0A0A;
            padding: 18px 24px 16px;
            margin-bottom: 0;
            position: relative;
            border-left: 4px solid #D4AF37;
            border-right: 4px solid #DC2626;
        }

        .cover-header-inner {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-letter {
            font-size: 52px;
            font-weight: 900;
            color: #D4AF37;
            line-height: 1;
            font-family: Georgia, serif;
            letter-spacing: -2px;
        }

        .logo-divider {
            width: 1px;
            height: 56px;
            background: rgba(212,175,55,0.4);
        }

        .logo-text h1 {
            font-family: Georgia, serif;
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 3px;
            line-height: 1.1;
            margin-bottom: 2px;
        }

        .logo-text .sas {
            font-size: 9px;
            font-weight: 400;
            color: #D4AF37;
            letter-spacing: 5px;
            display: block;
            margin-bottom: 8px;
        }

        .logo-text .doc-title {
            font-size: 10px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: block;
        }

        .logo-text .doc-sub {
            font-size: 8px;
            color: #9CA3AF;
            letter-spacing: 0.5px;
            display: block;
            margin-top: 2px;
        }

        .header-bottom-line {
            height: 1px;
            background: linear-gradient(to right, #D4AF37, #DC2626, transparent);
            margin-top: 14px;
        }

        /* ── BADGES ── */
        .badges {
            display: flex;
            gap: 0;
            margin-bottom: 16px;
            border-bottom: 1px solid #E5E0D0;
        }

        .badge {
            flex: 1;
            padding: 5px 8px;
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: center;
        }

        .badge-gold  { background: #FEF9E7; color: #92400E; border-right: 1px solid #E5E0D0; }
        .badge-blue  { background: #EFF6FF; color: #1E40AF; border-right: 1px solid #E5E0D0; }
        .badge-green { background: #F0FDF4; color: #166534; }

        /* ── CONTENIDO PRINCIPAL ── */
        .content {
            padding: 18px 24px 0;
        }

        /* ── SECCIÓN ── */
        .section {
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            padding-bottom: 5px;
            border-bottom: 1px solid #E5E0D0;
        }

        .art-pill {
            background: #DC2626;
            color: #fff;
            font-size: 6.5px;
            font-weight: 700;
            letter-spacing: 0.8px;
            padding: 3px 7px;
            border-radius: 3px;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .section-title {
            font-family: Georgia, serif;
            font-size: 11px;
            font-weight: 700;
            color: #0A0A0A;
        }

        .section-body {
            font-size: 9.5px;
            color: #374151;
            line-height: 1.65;
            text-align: justify;
        }

        .section-body ol,
        .section-body ul {
            padding-left: 16px;
            margin-top: 4px;
        }

        .section-body li {
            margin-bottom: 3px;
            line-height: 1.6;
        }

        .section-body li::marker {
            color: #D4AF37;
        }

        .hl { font-weight: 700; color: #0A0A0A; }

        /* ── CAJA META ── */
        .meta-box {
            margin: 18px 24px 0;
            background: #F9F9F7;
            border-left: 3px solid #D4AF37;
            border-radius: 4px;
            padding: 10px 14px;
            display: flex;
            gap: 0;
        }

        .meta-divider {
            width: 1px;
            background: #E5E0D0;
            margin: 0 14px;
            flex-shrink: 0;
        }

        .meta-item {
            flex: 1;
        }

        .meta-label {
            font-size: 6.5px;
            font-weight: 700;
            color: #9CA3AF;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .meta-value {
            font-size: 9px;
            font-weight: 700;
            color: #0A0A0A;
        }

        /* ── NOTA LEGAL FINAL ── */
        .legal-note {
            margin: 12px 24px 0;
            padding: 8px 12px;
            background: #FEF9E7;
            border: 1px solid rgba(212,175,55,0.3);
            border-radius: 4px;
            font-size: 8px;
            color: #6B7280;
            text-align: center;
            line-height: 1.5;
        }

        /* ── FOOTER ── */
        .page-footer {
            margin-top: 18px;
            padding: 8px 24px 0;
            border-top: 1px solid #E5E0D0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 7px;
            color: #9CA3AF;
        }

        .footer-right {
            font-size: 7px;
            color: #9CA3AF;
        }

        .footer-brand {
            font-weight: 700;
            color: #D4AF37;
        }
    </style>
</head>
<body>

    <!-- PORTADA HEADER -->
    <div class="cover-header">
        <div class="cover-header-inner">
            <div class="logo-letter">H</div>
            <div class="logo-divider"></div>
            <div class="logo-text">
                <h1>BARBER SHOP</h1>
                <span class="sas">S &nbsp; A &nbsp; S</span>
                <span class="doc-title">Términos y Condiciones</span>
                <span class="doc-sub">Política de tratamiento de datos personales</span>
            </div>
        </div>
        <div class="header-bottom-line"></div>
    </div>

    <!-- BADGES -->
    <div class="badges">
        <div class="badge badge-gold">Ley 1581 de 2012</div>
        <div class="badge badge-blue">Política de privacidad</div>
        <div class="badge badge-green">Colombia</div>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 1</span>
                <span class="section-title">Identificación del Responsable</span>
            </div>
            <div class="section-body">
                El presente documento regula el uso de la página web de <span class="hl">H Barber Shop SAS</span>,
                así como el tratamiento de los datos personales recolectados a través de la misma,
                en cumplimiento de la normatividad colombiana vigente en materia de protección de datos.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 2</span>
                <span class="section-title">Aceptación de los Términos</span>
            </div>
            <div class="section-body">
                Al acceder, registrarse o proporcionar información personal en la página web de
                <span class="hl">H Barber Shop</span>, el usuario acepta de manera libre, previa y expresa
                los presentes términos y condiciones en su totalidad.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 3</span>
                <span class="section-title">Finalidad del Tratamiento de Datos</span>
            </div>
            <div class="section-body">
                Los datos personales recolectados serán utilizados exclusivamente para:
                <ol>
                    <li>Confirmación, gestión y recordatorio de citas.</li>
                    <li>Envío de información relacionada con los servicios de la barbería.</li>
                    <li>Comunicación de promociones, descuentos, novedades y campañas publicitarias.</li>
                </ol>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 4</span>
                <span class="section-title">Tratamiento y Protección de Datos</span>
            </div>
            <div class="section-body">
                <span class="hl">H Barber Shop</span> garantiza que los datos personales serán tratados
                conforme a los principios de legalidad, confidencialidad, seguridad y transparencia.
                Se adoptarán las medidas técnicas, humanas y administrativas necesarias para proteger
                la información contra acceso no autorizado, pérdida, alteración o uso indebido.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 5</span>
                <span class="section-title">Confidencialidad de la Información</span>
            </div>
            <div class="section-body">
                Los datos personales proporcionados por los usuarios no serán vendidos, cedidos ni
                compartidos con terceros sin autorización previa y expresa, salvo obligación legal
                debidamente motivada por autoridad competente.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 6</span>
                <span class="section-title">Derechos del Titular de los Datos</span>
            </div>
            <div class="section-body">
                De conformidad con la Ley 1581 de 2012, el usuario como titular tiene derecho a:
                <ol>
                    <li>Conocer, actualizar y rectificar sus datos personales en cualquier momento.</li>
                    <li>Solicitar prueba de la autorización otorgada para el tratamiento de sus datos.</li>
                    <li>Revocar la autorización y/o solicitar la supresión de sus datos personales.</li>
                    <li>Acceder de forma gratuita a sus datos personales que estén siendo tratados.</li>
                </ol>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 7</span>
                <span class="section-title">Autorización del Usuario</span>
            </div>
            <div class="section-body">
                El usuario autoriza de manera libre, previa, expresa e informada a <span class="hl">H Barber Shop</span>
                para el tratamiento de sus datos personales conforme a lo establecido en el presente
                documento y en la legislación colombiana aplicable.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 8</span>
                <span class="section-title">Modificaciones</span>
            </div>
            <div class="section-body">
                <span class="hl">H Barber Shop</span> se reserva el derecho de modificar los presentes
                términos en cualquier momento. Cualquier cambio será informado oportunamente a través
                de los canales oficiales de comunicación y de la página web.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 9</span>
                <span class="section-title">Legislación Aplicable</span>
            </div>
            <div class="section-body">
                El presente documento se rige por las leyes vigentes en materia de protección de datos
                personales en Colombia, en particular la Ley Estatutaria 1581 de 2012, el Decreto
                1377 de 2013 y demás normas concordantes.
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <span class="art-pill">Art. 10</span>
                <span class="section-title">Contacto y Reclamaciones</span>
            </div>
            <div class="section-body">
                Para consultas, solicitudes o reclamos relacionados con el tratamiento de datos personales,
                el usuario podrá comunicarse a través de los canales oficiales de <span class="hl">H Barber Shop</span>:
                correo electrónico, WhatsApp o visita presencial al establecimiento.
            </div>
        </div>

    </div>

    <!-- META BOX -->
    <div class="meta-box">
        <div class="meta-item">
            <span class="meta-label">Fecha de actualización</span>
            <span class="meta-value">09 de abril de 2026</span>
        </div>
        <div class="meta-divider"></div>
        <div class="meta-item">
            <span class="meta-label">Representante legal</span>
            <span class="meta-value">Juan Pérez</span>
        </div>
        <div class="meta-divider"></div>
        <div class="meta-item">
            <span class="meta-label">Contacto oficial</span>
            <span class="meta-value">contacto@hbarbershop.com</span>
        </div>
    </div>

    <!-- NOTA LEGAL -->
    <div class="legal-note">
        Este documento fue generado por <strong>H Barber Shop SAS</strong> y tiene carácter vinculante.
        Su uso o reproducción parcial sin autorización está prohibido.
    </div>

    <!-- FOOTER -->
    <div class="page-footer">
        <span class="footer-left">
            Documento confidencial &mdash; <span class="footer-brand">H Barber Shop SAS</span> &mdash; Bogotá, Colombia
        </span>
        <span class="footer-right">Página 1 de 1</span>
    </div>

</body>
</html>