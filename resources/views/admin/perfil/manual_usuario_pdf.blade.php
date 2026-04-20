<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Manual de Usuario - H Barber Shop</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.65;
            color: #1a1a1a;
            background: #ffffff;
        }

        /* ══════════════════════════════════════
           PORTADA
        ══════════════════════════════════════ */
        .portada {
            page-break-after: always;
            position: relative;
            height: 100%;
            min-height: 800px;
        }

        .portada-header {
            background: #111111;
            padding: 50px 50px 40px;
            position: relative;
            overflow: hidden;
        }

        .portada-header-accent {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: #dc0000;
        }

        .portada-logo-row {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .portada-logo-left {
            display: table-cell;
            vertical-align: middle;
        }

        .portada-logo-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .portada-brand {
            font-size: 30pt;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 4px;
            text-transform: uppercase;
            line-height: 1;
        }

        .portada-brand span {
            color: #dc0000;
        }

        .portada-tagline {
            font-size: 9pt;
            color: #999999;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .portada-doc-badge {
            background: #dc0000;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: inline-block;
        }

        .portada-title-block {
            border-top: 1px solid #333333;
            padding-top: 28px;
        }

        .portada-title {
            font-size: 22pt;
            font-weight: 900;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -0.5px;
        }

        .portada-subtitle {
            font-size: 11pt;
            color: #aaaaaa;
            margin-top: 8px;
            font-weight: 400;
        }

        /* Banda roja separadora */
        .portada-banda {
            background: #dc0000;
            height: 5px;
        }

        /* Cuerpo blanco de portada */
        .portada-body {
            background: #f7f7f7;
            padding: 50px 50px 40px;
        }

        .portada-desc-title {
            font-size: 8pt;
            font-weight: 700;
            color: #dc0000;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .portada-desc {
            font-size: 10.5pt;
            color: #444444;
            line-height: 1.75;
            max-width: 540px;
            margin-bottom: 36px;
        }

        .portada-meta-row {
            display: table;
            width: 100%;
            border-top: 2px solid #e0e0e0;
            padding-top: 24px;
        }

        .portada-meta-col {
            display: table-cell;
            vertical-align: top;
            width: 33.33%;
            padding-right: 20px;
        }

        .portada-meta-label {
            font-size: 7.5pt;
            font-weight: 700;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4px;
        }

        .portada-meta-value {
            font-size: 10pt;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* Secciones rápidas de portada */
        .portada-covers {
            margin-top: 36px;
            display: table;
            width: 100%;
        }

        .portada-cover-item {
            display: table-cell;
            width: 25%;
            padding: 14px 16px;
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            vertical-align: top;
        }

        .portada-cover-item + .portada-cover-item {
            margin-left: 8px;
        }

        .portada-cover-num {
            font-size: 18pt;
            font-weight: 900;
            color: #dc0000;
            line-height: 1;
        }

        .portada-cover-text {
            font-size: 8pt;
            color: #666666;
            margin-top: 4px;
            line-height: 1.4;
        }

        /* Footer portada */
        .portada-footer {
            background: #111111;
            padding: 16px 50px;
            display: table;
            width: 100%;
        }

        .portada-footer-left {
            display: table-cell;
            vertical-align: middle;
        }

        .portada-footer-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .portada-footer-text {
            font-size: 8pt;
            color: #666666;
        }

        .portada-footer-text span {
            color: #dc0000;
        }

        /* ══════════════════════════════════════
           ÍNDICE
        ══════════════════════════════════════ */
        .indice {
            page-break-after: always;
            padding: 40px 45px;
        }

        .indice-header {
            display: table;
            width: 100%;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 3px solid #dc0000;
        }

        .indice-header-left {
            display: table-cell;
            vertical-align: bottom;
        }

        .indice-header-right {
            display: table-cell;
            vertical-align: bottom;
            text-align: right;
        }

        .indice-title {
            font-size: 18pt;
            font-weight: 900;
            color: #111111;
            letter-spacing: -0.5px;
        }

        .indice-subtitle {
            font-size: 8.5pt;
            color: #888888;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .indice-total {
            font-size: 8pt;
            color: #999999;
            text-align: right;
        }

        .indice-total strong {
            color: #dc0000;
            font-size: 13pt;
            font-weight: 900;
            display: block;
        }

        /* Grid de índice en 2 columnas */
        .indice-grid {
            display: table;
            width: 100%;
        }

        .indice-col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding-right: 20px;
        }

        .indice-col:last-child {
            padding-right: 0;
            padding-left: 20px;
            border-left: 1px solid #eeeeee;
        }

        .indice-item {
            display: table;
            width: 100%;
            padding: 7px 0;
            border-bottom: 1px dotted #e5e5e5;
        }

        .indice-item-num {
            display: table-cell;
            width: 28px;
            vertical-align: middle;
            font-size: 8.5pt;
            font-weight: 900;
            color: #dc0000;
        }

        .indice-item-text {
            display: table-cell;
            vertical-align: middle;
            font-size: 9.5pt;
            color: #333333;
        }

        /* ══════════════════════════════════════
           SECCIONES DE CONTENIDO
        ══════════════════════════════════════ */
        .seccion {
            padding: 36px 45px 28px;
            border-bottom: 1px solid #eeeeee;
        }

        .seccion-pagina {
            page-break-before: always;
        }

        /* Encabezado de sección */
        .seccion-head {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 2px solid #eeeeee;
        }

        .seccion-head-left {
            display: table-cell;
            vertical-align: bottom;
        }

        .seccion-head-right {
            display: table-cell;
            vertical-align: bottom;
            text-align: right;
        }

        .seccion-num {
            display: inline-block;
            background: #dc0000;
            color: #ffffff;
            font-size: 9pt;
            font-weight: 900;
            padding: 3px 10px;
            border-radius: 3px;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        h2 {
            font-size: 15pt;
            font-weight: 900;
            color: #111111;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .seccion-module-tag {
            font-size: 7.5pt;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        h3 {
            font-size: 10.5pt;
            font-weight: 800;
            color: #1a1a1a;
            margin-top: 20px;
            margin-bottom: 8px;
            padding-left: 10px;
            border-left: 3px solid #dc0000;
        }

        p {
            margin-bottom: 9px;
            color: #333333;
            font-size: 10pt;
        }

        ul, ol {
            padding-left: 20px;
            margin-bottom: 12px;
        }

        li {
            margin-bottom: 5px;
            font-size: 10pt;
            color: #333333;
        }

        strong {
            color: #111111;
            font-weight: 700;
        }

        /* Pasos numerados mejorados */
        ol.pasos {
            list-style: none;
            padding-left: 0;
            counter-reset: paso;
        }

        ol.pasos li {
            counter-increment: paso;
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        ol.pasos li::before {
            content: counter(paso);
            display: table-cell;
            width: 24px;
            height: 24px;
            background: #111111;
            color: #ffffff;
            font-size: 8pt;
            font-weight: 900;
            text-align: center;
            vertical-align: middle;
            border-radius: 50%;
            padding-top: 2px;
            flex-shrink: 0;
        }

        ol.pasos li span {
            display: table-cell;
            vertical-align: middle;
            padding-left: 10px;
        }

        /* kbd mejorado */
        kbd {
            background: #1a1a1a;
            color: #ffffff;
            border-radius: 4px;
            padding: 1px 6px;
            font-size: 8pt;
            font-family: 'DejaVu Sans Mono', monospace;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        code {
            background: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 1px 5px;
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 9pt;
            color: #dc0000;
        }

        /* Notas */
        .nota {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 10px 14px;
            margin: 14px 0;
            border-radius: 0 6px 6px 0;
        }

        .nota-title {
            font-size: 8pt;
            font-weight: 800;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .nota p {
            font-size: 9.5pt;
            color: #78350f;
            margin: 0;
        }

        /* Nota tipo importante (roja) */
        .nota-importante {
            background: #fff5f5;
            border-left: 4px solid #dc0000;
            padding: 10px 14px;
            margin: 14px 0;
            border-radius: 0 6px 6px 0;
        }

        .nota-importante .nota-title {
            color: #dc0000;
        }

        .nota-importante p {
            color: #7f1d1d;
        }

        /* Nota tipo info (verde) */
        .nota-info {
            background: #f0fff4;
            border-left: 4px solid #10b981;
            padding: 10px 14px;
            margin: 14px 0;
            border-radius: 0 6px 6px 0;
        }

        .nota-info .nota-title {
            color: #065f46;
        }

        .nota-info p {
            color: #064e3b;
        }

        /* Tabla de atajos */
        table.atajos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table.atajos thead tr {
            background: #111111;
            color: #ffffff;
        }

        table.atajos thead th {
            padding: 9px 12px;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        table.atajos tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        table.atajos tbody tr:nth-child(even) {
            background: #fafafa;
        }

        table.atajos tbody td {
            padding: 9px 12px;
            font-size: 9.5pt;
            vertical-align: middle;
        }

        table.atajos tbody td:first-child {
            width: 35%;
        }

        /* Lista de correos */
        .correos-list {
            list-style: none;
            padding: 0;
        }

        .correos-list li {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .correos-list li::before {
            content: "✉";
            display: table-cell;
            width: 24px;
            color: #dc0000;
            font-size: 11pt;
            vertical-align: middle;
        }

        .correos-list li span {
            display: table-cell;
            vertical-align: middle;
            padding-left: 8px;
        }

        /* Tabla de roles */
        table.roles {
            width: 100%;
            border-collapse: collapse;
            margin: 14px 0;
        }

        table.roles thead tr {
            background: #111111;
        }

        table.roles thead th {
            padding: 10px 14px;
            font-size: 8.5pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffffff;
            text-align: left;
        }

        table.roles tbody tr {
            border-bottom: 1px solid #eeeeee;
        }

        table.roles tbody tr:nth-child(even) { background: #fafafa; }

        table.roles tbody td {
            padding: 10px 14px;
            font-size: 9.5pt;
            vertical-align: top;
        }

        table.roles tbody td:first-child {
            font-weight: 700;
            color: #dc0000;
            width: 22%;
            white-space: nowrap;
        }

        /* Chips de módulo */
        .chip {
            display: inline-block;
            background: #f3f4f6;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 8pt;
            color: #555555;
            font-weight: 700;
            margin: 1px 2px;
        }

        .chip-rojo {
            background: #fff0f0;
            border-color: #fca5a5;
            color: #dc0000;
        }

        /* Pie de página de sección */
        .seccion-footer {
            margin-top: 18px;
            font-size: 8pt;
            color: #bbbbbb;
            text-align: right;
        }

        /* ══════════════════════════════════════
           PIE DE PÁGINA GLOBAL
        ══════════════════════════════════════ */
        .pie-pagina {
            background: #111111;
            padding: 14px 45px;
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .pie-left {
            display: table-cell;
            vertical-align: middle;
        }

        .pie-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .pie-text {
            font-size: 8pt;
            color: #666666;
        }

        .pie-text span { color: #dc0000; }

        @media print {
            body { padding: 0; }
            .portada-header-accent { background: #dc0000 !important; }
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════
     PORTADA
══════════════════════════════════════ --}}
<div class="portada">

    <div class="portada-header">
        <div class="portada-header-accent"></div>

        <div class="portada-logo-row">
            <div class="portada-logo-left">
                <div class="portada-brand">H <span>Barber</span> Shop</div>
                <div class="portada-tagline">Tu barber&iacute;a de confianza</div>
            </div>
            <div class="portada-logo-right">
                <span class="portada-doc-badge">Manual de usuario</span>
            </div>
        </div>

        <div class="portada-title-block">
            <div class="portada-title">Gu&iacute;a completa del<br>Sistema de Gesti&oacute;n</div>
            <div class="portada-subtitle">Administraci&oacute;n &middot; Personal &middot; Facturaci&oacute;n &middot; CRM &middot; Blog &middot; Reportes</div>
        </div>
    </div>

    <div class="portada-banda"></div>

    <div class="portada-body">
        <div class="portada-desc-title">Acerca de este manual</div>
        <p class="portada-desc">
            Esta gu&iacute;a explica paso a paso todas las funciones del sistema de gesti&oacute;n de H Barber Shop.
            Cubre desde el inicio de sesi&oacute;n hasta la configuraci&oacute;n avanzada, incluyendo turnos,
            facturaci&oacute;n, CRM, fidelizaci&oacute;n, membres&iacute;as, gastos y el sitio web p&uacute;blico.
        </p>

        <div class="portada-covers">
            <div class="portada-cover-item">
                <div class="portada-cover-num">28</div>
                <div class="portada-cover-text">M&oacute;dulos y secciones documentadas</div>
            </div>
            <div class="portada-cover-item" style="margin-left:8px;">
                <div class="portada-cover-num">3</div>
                <div class="portada-cover-text">Tipos de usuarios del sistema</div>
            </div>
            <div class="portada-cover-item" style="margin-left:8px;">
                <div class="portada-cover-num">10</div>
                <div class="portada-cover-text">Correos autom&aacute;ticos configurados</div>
            </div>
            <div class="portada-cover-item" style="margin-left:8px;">
                <div class="portada-cover-num">acc</div>
                <div class="portada-cover-text">Accesible para lectores de pantalla</div>
            </div>
        </div>

        <div class="portada-meta-row">
            <div class="portada-meta-col">
                <div class="portada-meta-label">Generado el</div>
                <div class="portada-meta-value">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
            </div>
            <div class="portada-meta-col">
                <div class="portada-meta-label">Versi&oacute;n</div>
                <div class="portada-meta-value">1.0</div>
            </div>
            <div class="portada-meta-col">
                <div class="portada-meta-label">Sistema</div>
                <div class="portada-meta-value">H Barber Shop Admin</div>
            </div>
        </div>
    </div>

    <div class="portada-footer">
        <div class="portada-footer-left">
            <div class="portada-footer-text">&copy; {{ date('Y') }} <span>H Barber Shop</span> &mdash; Todos los derechos reservados</div>
        </div>
        <div class="portada-footer-right">
            <div class="portada-footer-text">Manual de Usuario &mdash; Uso interno</div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     ÍNDICE
══════════════════════════════════════ --}}
<div class="indice">

    <div class="indice-header">
        <div class="indice-header-left">
            <div class="indice-title">&Iacute;ndice de contenido</div>
            <div class="indice-subtitle">Navegaci&oacute;n completa del manual</div>
        </div>
        <div class="indice-header-right">
            <div class="indice-total">
                <strong>28</strong>
                secciones
            </div>
        </div>
    </div>

    <div class="indice-grid">
        <div class="indice-col">
            @php $secciones1 = [
                [1,'Introducci&oacute;n al sistema'],
                [2,'C&oacute;mo iniciar sesi&oacute;n'],
                [3,'Recuperar la contrase&ntilde;a'],
                [4,'Panel principal (Dashboard)'],
                [5,'M&oacute;dulo de Personal (Barberos)'],
                [6,'M&oacute;dulo de Sedes'],
                [7,'M&oacute;dulo de Turnos (Citas)'],
                [8,'Cancelar o reprogramar turno'],
                [9,'Pagos y anticipos con QR'],
                [10,'Disponibilidad (Horarios)'],
                [11,'Servicios y Combos'],
                [12,'Productos y Kits'],
                [13,'CRM &mdash; Gesti&oacute;n de clientes'],
                [14,'M&oacute;dulo de Fidelizaci&oacute;n'],
            ]; @endphp
            @foreach($secciones1 as $s)
            <div class="indice-item">
                <span class="indice-item-num">{{ $s[0] }}</span>
                <span class="indice-item-text">{!! $s[1] !!}</span>
            </div>
            @endforeach
        </div>
        <div class="indice-col">
            @php $secciones2 = [
                [15,'M&oacute;dulo de Facturaci&oacute;n'],
                [16,'M&oacute;dulo de Reportes'],
                [17,'M&oacute;dulo de Blog'],
                [18,'Moderaci&oacute;n de Comentarios'],
                [19,'Configuraci&oacute;n del sistema'],
                [20,'Sitio web p&uacute;blico'],
                [21,'Panel del Barbero'],
                [22,'Correos autom&aacute;ticos'],
                [23,'Atajos de teclado'],
                [24,'Lectores de pantalla'],
                [25,'M&oacute;dulo de Membres&iacute;as'],
                [26,'M&oacute;dulo de Gastos'],
                [27,'Perfil y WhatsApp'],
                [28,'D&oacute;nde pedir ayuda'],
            ]; @endphp
            @foreach($secciones2 as $s)
            <div class="indice-item">
                <span class="indice-item-num">{{ $s[0] }}</span>
                <span class="indice-item-text">{!! $s[1] !!}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     SECCIÓN 1
══════════════════════════════════════ --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">01</span>
            <h2>Introducci&oacute;n al sistema</h2>
            <div class="seccion-module-tag">Visi&oacute;n general</div>
        </div>
    </div>
    <p>Bienvenido al manual de usuario de <strong>H Barber Shop</strong>. Este es un sistema completo de gesti&oacute;n que permite administrar todos los aspectos del negocio desde cualquier navegador web.</p>
    <p>El sistema tiene tres tipos de usuarios con diferentes niveles de acceso:</p>
    <table class="roles">
        <thead><tr><th>Rol</th><th>Acceso</th><th>M&oacute;dulos disponibles</th></tr></thead>
        <tbody>
            <tr>
                <td>Administrador</td>
                <td>Completo</td>
                <td>Todos los m&oacute;dulos: turnos, personal, servicios, productos, CRM, facturaci&oacute;n, reportes, blog, gastos, membres&iacute;as y configuraci&oacute;n.</td>
            </tr>
            <tr>
                <td>Barbero</td>
                <td>Limitado</td>
                <td>Panel propio: sus turnos de la semana, horario, resumen de ganancias y perfil personal.</td>
            </tr>
            <tr>
                <td>Visitante</td>
                <td>P&uacute;blico</td>
                <td>Sitio web: servicios, productos, agendamiento de cita, fidelizaci&oacute;n y blog.</td>
            </tr>
        </tbody>
    </table>
    <p>El men&uacute; de navegaci&oacute;n se encuentra en el lado izquierdo de la pantalla. En la parte inferior encontrar&aacute;s <strong>Configuraci&oacute;n</strong> y el bot&oacute;n para <strong>Cerrar sesi&oacute;n</strong>.</p>
    <div class="nota-info">
        <div class="nota-title">Accesibilidad</div>
        <p>Si usas un lector de pantalla, navega entre secciones con la tecla <kbd>H</kbd>. Todos los formularios tienen etiquetas accesibles y el sistema es compatible con NVDA, JAWS y VoiceOver.</p>
    </div>
</div>

{{-- SECCIÓN 2 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">02</span>
            <h2>C&oacute;mo iniciar sesi&oacute;n</h2>
            <div class="seccion-module-tag">Acceso al sistema</div>
        </div>
    </div>
    <p>Para ingresar al sistema necesitas tu correo electr&oacute;nico y contrase&ntilde;a. Sigue estos pasos:</p>
    <ol class="pasos">
        <li><span>Abre el navegador web y escribe la direcci&oacute;n del sistema. Presiona <kbd>Enter</kbd>.</span></li>
        <li><span>Escribe tu <strong>Correo electr&oacute;nico</strong> en el primer campo.</span></li>
        <li><span>Presiona <kbd>Tab</kbd> para pasar al campo <strong>Contrase&ntilde;a</strong> y escr&iacute;bela.</span></li>
        <li><span>Presiona <kbd>Tab</kbd> hasta llegar al bot&oacute;n <strong>Iniciar sesi&oacute;n</strong> y presiona <kbd>Enter</kbd>.</span></li>
        <li><span>Si los datos son correctos, el sistema te llevar&aacute; al panel principal.</span></li>
        <li><span>Si hay un error, aparecer&aacute; un mensaje indicando qu&eacute; sali&oacute; mal.</span></li>
    </ol>
    <div class="nota">
        <div class="nota-title">Seguridad</div>
        <p>El sistema limita los intentos a <strong>5 por minuto</strong> para proteger tu cuenta contra accesos no autorizados.</p>
    </div>
</div>

{{-- SECCIÓN 3 --}}
<div class="seccion">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">03</span>
            <h2>C&oacute;mo recuperar la contrase&ntilde;a</h2>
            <div class="seccion-module-tag">Acceso al sistema</div>
        </div>
    </div>
    <p>Si olvidaste tu contrase&ntilde;a, puedes restablecerla por correo electr&oacute;nico:</p>
    <ol class="pasos">
        <li><span>En la p&aacute;gina de inicio de sesi&oacute;n, selecciona <strong>&iquest;Olvidaste tu contrase&ntilde;a?</strong></span></li>
        <li><span>Escribe el correo electr&oacute;nico asociado a tu cuenta.</span></li>
        <li><span>Selecciona <strong>Enviar enlace de restablecimiento</strong>.</span></li>
        <li><span>Revisa tu bandeja de entrada. Recibir&aacute;s un enlace para crear una nueva contrase&ntilde;a.</span></li>
        <li><span>Abre el enlace, escribe la nueva contrase&ntilde;a y conf&iacute;rmala.</span></li>
        <li><span>Selecciona <strong>Restablecer contrase&ntilde;a</strong>.</span></li>
    </ol>
</div>

{{-- SECCIÓN 4 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">04</span>
            <h2>Panel principal (Dashboard)</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Inicio</div>
        </div>
    </div>
    <p>El panel principal es la primera p&aacute;gina al iniciar sesi&oacute;n como administrador. Selecciona <strong>Inicio</strong> en el men&uacute; lateral.</p>
    <h3>Tarjetas de resumen</h3>
    <ul>
        <li><strong>Clientes totales:</strong> Cantidad total de clientes registrados.</li>
        <li><strong>Turnos pendientes:</strong> Citas programadas sin atender.</li>
        <li><strong>Turnos realizados:</strong> Citas completadas.</li>
        <li><strong>Ingresos del mes:</strong> Total facturado durante el mes actual.</li>
    </ul>
    <h3>Tablas del panel</h3>
    <ul>
        <li><strong>Servicios m&aacute;s vendidos:</strong> Los servicios m&aacute;s solicitados del per&iacute;odo.</li>
        <li><strong>Clientes frecuentes:</strong> Los clientes que m&aacute;s visitan la barber&iacute;a.</li>
    </ul>
</div>

{{-- SECCIÓN 5 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">05</span>
            <h2>M&oacute;dulo de Personal (Barberos)</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Personal</div>
        </div>
    </div>
    <p>Permite registrar y gestionar a los barberos. Selecciona <strong>Personal</strong> en el men&uacute; lateral.</p>
    <h3>5.1 Ver la lista de barberos</h3>
    <p>La tabla muestra: Documento, Nombre, Sede, Estado, Usuario y Acciones.</p>
    <h3>5.2 Registrar un nuevo barbero</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Registrar nuevo barbero</strong>.</span></li>
        <li><span>Completa: Nombre, Apellido, Documento, Tel&eacute;fono y Sede.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>.</span></li>
    </ol>
    <h3>5.3 Activar o desactivar un barbero</h3>
    <p>Usa los botones de la columna de acciones. Un barbero desactivado no puede iniciar sesi&oacute;n en el sistema.</p>
    <h3>5.4 Activar la cuenta de usuario de un barbero</h3>
    <ol class="pasos">
        <li><span>Ve a <strong>Personal &rarr; Usuarios</strong> en el men&uacute; lateral.</span></li>
        <li><span>Busca al barbero en la tabla. Ver&aacute;s su nombre de usuario, c&eacute;dula y estado.</span></li>
        <li><span>Selecciona <strong>Activar</strong>. El barbero podr&aacute; iniciar sesi&oacute;n desde ese momento.</span></li>
    </ol>
</div>

{{-- SECCIÓN 6 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">06</span>
            <h2>M&oacute;dulo de Sedes</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Sedes</div>
        </div>
    </div>
    <p>Gestiona las ubicaciones de la barber&iacute;a. Selecciona <strong>Sedes</strong> en el men&uacute; lateral. La tabla muestra: ID, Nombre, Direcci&oacute;n, Slogan y Acciones.</p>
    <h3>Crear una nueva sede</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Registrar nueva sede</strong>.</span></li>
        <li><span>Completa nombre, direcci&oacute;n y slogan.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>.</span></li>
    </ol>
    <h3>Editar o eliminar una sede</h3>
    <p>Usa los botones <strong>Editar</strong> o <strong>Eliminar</strong> en la fila correspondiente. Al eliminar se pedir&aacute; confirmaci&oacute;n.</p>
</div>

{{-- SECCIÓN 7 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">07</span>
            <h2>M&oacute;dulo de Turnos (Citas)</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Turnos</div>
        </div>
    </div>
    <p>Gestiona todas las citas de los clientes. Selecciona <strong>Turnos</strong> en el men&uacute; lateral.</p>
    <h3>7.1 Ver la lista de turnos</h3>
    <p>Filtra por estado <span class="chip">Pendiente</span> <span class="chip">Cancelado</span> <span class="chip">Realizado</span>, por estado de pago y por fecha. La tabla muestra: Cliente, Barbero, Fecha, Hora, Estado, Estado de pago y Acciones.</p>
    <h3>7.2 Crear un nuevo turno</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Nuevo Turno</strong>.</span></li>
        <li><span>Selecciona la fecha del turno en el calendario.</span></li>
        <li><span>Selecciona el servicio. El sistema mostrar&aacute; los horarios disponibles.</span></li>
        <li><span>Selecciona el horario deseado.</span></li>
        <li><span>Si el cliente ya existe, ingresa su c&eacute;dula para autocompletar. Si es nuevo, completa todos los campos.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>. El cliente y el barbero recibir&aacute;n notificaci&oacute;n por correo.</span></li>
    </ol>
    <h3>7.3 Marcar un turno como realizado</h3>
    <ol class="pasos">
        <li><span>Busca el turno en la lista.</span></li>
        <li><span>Selecciona el bot&oacute;n <strong>Realizado</strong> en la columna de acciones.</span></li>
        <li><span>Quedar&aacute; habilitada la opci&oacute;n de facturarlo.</span></li>
    </ol>
</div>

{{-- SECCIÓN 8 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">08</span>
            <h2>Cancelar o reprogramar un turno</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Turnos</div>
        </div>
    </div>
    <h3>Cancelar un turno</h3>
    <ol class="pasos">
        <li><span>Ve al m&oacute;dulo de <strong>Turnos</strong>.</span></li>
        <li><span>Busca el turno y selecciona el bot&oacute;n <strong>Cancelar</strong>.</span></li>
        <li><span>Confirma la acci&oacute;n. El turno pasar&aacute; a estado Cancelado.</span></li>
    </ol>
    <h3>Reprogramar un turno</h3>
    <ol class="pasos">
        <li><span>Busca el turno y selecciona el bot&oacute;n <strong>Reprogramar</strong>.</span></li>
        <li><span>Selecciona la nueva fecha y hora disponibles.</span></li>
        <li><span>Selecciona <strong>Guardar cambios</strong>.</span></li>
    </ol>
</div>

{{-- SECCIÓN 9 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">09</span>
            <h2>Pagos y anticipos con QR</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Turnos &mdash; Pagos</div>
        </div>
    </div>
    <p>El sistema permite a los clientes pagar un anticipo de <strong>$10.000 COP</strong> al agendar su cita mediante c&oacute;digos QR de <strong>Nequi</strong>, <strong>DaviPlata</strong> o <strong>Bancolombia</strong>.</p>
    <h3>Confirmar un pago de anticipo</h3>
    <ol class="pasos">
        <li><span>El turno con anticipo aparece con estado <strong>Pendiente de pago</strong>.</span></li>
        <li><span>Verifica en tu cuenta que el pago fue recibido.</span></li>
        <li><span>Busca el turno y selecciona <strong>Confirmar pago</strong>.</span></li>
        <li><span>El cliente recibir&aacute; una notificaci&oacute;n por correo autom&aacute;ticamente.</span></li>
    </ol>
    <h3>Rechazar un pago</h3>
    <p>Busca el turno y selecciona <strong>Rechazar pago</strong>. El turno vuelve a su estado anterior.</p>
    <h3>Configurar los c&oacute;digos QR</h3>
    <ol class="pasos">
        <li><span>Ve a <strong>Configuraci&oacute;n &rarr; Implementar QR de Pagos</strong>.</span></li>
        <li><span>En cada tarjeta (Nequi, DaviPlata, Bancolombia) selecciona <strong>Seleccionar archivo</strong>.</span></li>
        <li><span>Elige la imagen QR (JPG o PNG, m&aacute;x. 2 MB) y presiona <strong>Subir QR</strong>.</span></li>
    </ol>
</div>

{{-- SECCIÓN 10 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">10</span>
            <h2>Disponibilidad (Horarios de barberos)</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Disponibilidad</div>
        </div>
    </div>
    <p>Define los d&iacute;as y horas disponibles de cada barbero. Selecciona <strong>Disponibilidad</strong> en el men&uacute; lateral. La tabla muestra: Fecha, D&iacute;a, Hora de inicio, Hora de fin, Estado y Acciones.</p>
    <h3>Crear disponibilidad individual</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Crear disponibilidad</strong>.</span></li>
        <li><span>Selecciona barbero, fecha, hora de inicio y hora de fin.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>.</span></li>
    </ol>
    <h3>Disponibilidad semanal masiva</h3>
    <p>Puedes crear la disponibilidad de toda una semana de forma masiva para un barbero. Es m&aacute;s r&aacute;pido que crearla d&iacute;a a d&iacute;a.</p>
    <h3>Consultar por fecha</h3>
    <p>Filtra por fecha para ver qu&eacute; barberos est&aacute;n disponibles ese d&iacute;a.</p>
</div>

{{-- SECCIÓN 11 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">11</span>
            <h2>Servicios y Combos</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Servicios</div>
        </div>
    </div>
    <p>Gestiona cortes, afeitados y combos. Selecciona <strong>Servicios</strong> en el men&uacute; lateral. La tabla muestra: Tipo, Nombre, Categor&iacute;a, Precio, Descuento, Precio final, Duraci&oacute;n, Estado e Incluye.</p>
    <h3>Crear un nuevo servicio</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Crear servicio / combo</strong>.</span></li>
        <li><span>Completa: nombre, categor&iacute;a, precio, descuento (opcional), duraci&oacute;n y estado.</span></li>
        <li><span>Si es un combo, selecciona los servicios que incluye.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>.</span></li>
    </ol>
    <h3>Editar o eliminar</h3>
    <p>Usa los botones <strong>Editar</strong> o <strong>Eliminar</strong> en la fila del servicio.</p>
</div>

{{-- SECCIÓN 12 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">12</span>
            <h2>Productos y Kits</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Productos</div>
        </div>
    </div>
    <p>Gestiona productos como ceras, aceites, shampoos y kits. Selecciona <strong>Productos</strong> en el men&uacute; lateral.</p>
    <h3>Ver los productos</h3>
    <p>Usa los botones <span class="chip chip-rojo">Todos</span> <span class="chip">Productos</span> <span class="chip">Kits</span> para filtrar. La tabla muestra: Tipo, Nombre, Categor&iacute;a, Precio, Stock, Estado, Imagen y Acciones.</p>
    <h3>Crear un nuevo producto</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Crear producto/kit</strong>.</span></li>
        <li><span>Completa: nombre, categor&iacute;a, precio, stock, estado e imagen.</span></li>
        <li><span>Si es un kit, selecciona los productos individuales que incluye.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>.</span></li>
    </ol>
</div>

{{-- SECCIÓN 13 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">13</span>
            <h2>CRM &mdash; Gesti&oacute;n de Clientes</h2>
            <div class="seccion-module-tag">M&oacute;dulo: CRM</div>
        </div>
    </div>
    <p>Conoce a tus clientes, sus visitas y gastos hist&oacute;ricos. Selecciona <strong>CRM</strong> en el men&uacute; lateral.</p>
    <h3>Lista de clientes</h3>
    <p>La tabla muestra: Cliente, Celular, Visitas, &Uacute;ltima visita, Gasto total, Servicio favorito y Acci&oacute;n.</p>
    <div class="nota">
        <div class="nota-title">Alerta de inactividad</div>
        <p>Los clientes que llevan m&aacute;s de 2 meses sin visitar aparecen resaltados en naranja. Su fila incluye un bot&oacute;n de WhatsApp para contactarlos directamente.</p>
    </div>
    <h3>Ver el detalle de un cliente</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Ver detalle</strong> del cliente.</span></li>
        <li><span>Ver&aacute;s: total gastado, promedio por visita, historial de turnos y facturas.</span></li>
        <li><span>Puedes filtrar por rango de fechas o por servicio.</span></li>
    </ol>
    <h3>Exportar a PDF</h3>
    <p>Selecciona el bot&oacute;n <strong>Exportar PDF</strong> para descargar la lista completa de clientes.</p>
</div>

{{-- SECCIÓN 14 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">14</span>
            <h2>M&oacute;dulo de Fidelizaci&oacute;n</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Fidelizaci&oacute;n</div>
        </div>
    </div>
    <p>Programa de lealtad que premia a los clientes frecuentes con cortes gratis. Selecciona <strong>Fidelizaci&oacute;n</strong> en el men&uacute; lateral.</p>
    <h3>Ver clientes fidelizados</h3>
    <p>La tabla muestra: Cliente, C&eacute;dula, Tel&eacute;fono, Visitas acumuladas, Cortes gratis y &Uacute;ltima actualizaci&oacute;n.</p>
    <h3>Configurar el programa</h3>
    <ol class="pasos">
        <li><span>Selecciona el enlace <strong>Configuraci&oacute;n</strong> en la p&aacute;gina de fidelizaci&oacute;n.</span></li>
        <li><span>Define cu&aacute;ntas visitas se necesitan para ganar un corte gratis y si el programa est&aacute; activo.</span></li>
        <li><span>Selecciona <strong>Guardar configuraci&oacute;n</strong>.</span></li>
    </ol>
</div>

{{-- SECCIÓN 15 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">15</span>
            <h2>M&oacute;dulo de Facturaci&oacute;n</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Facturaci&oacute;n</div>
        </div>
    </div>
    <p>Crea y gestiona facturas de los servicios prestados. Selecciona <strong>Facturaci&oacute;n</strong> en el men&uacute; lateral.</p>
    <h3>Crear una factura</h3>
    <ol class="pasos">
        <li><span>Ve a <strong>Turnos</strong> y busca un turno con estado <strong>Realizado</strong>.</span></li>
        <li><span>Selecciona <strong>Facturar</strong> en las acciones del turno.</span></li>
        <li><span>Verifica los datos del formulario prellenado.</span></li>
        <li><span>Selecciona <strong>Guardar factura</strong>.</span></li>
    </ol>
    <h3>Detalle de factura</h3>
    <p>Muestra: datos del cliente, barbero, sede, tabla de servicios facturados y resumen (subtotal, descuento membres&iacute;a, total, abono y saldo).</p>
    <h3>Agregar servicios extra a una factura</h3>
    <p>Dentro del detalle, selecciona el servicio extra y presiona <strong>Agregar</strong>.</p>
    <h3>Descargar en PDF</h3>
    <p>Usa el bot&oacute;n <strong>Descargar PDF</strong> en la lista o en el detalle de la factura.</p>
</div>

{{-- SECCIÓN 16 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">16</span>
            <h2>M&oacute;dulo de Reportes</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Reporte General</div>
        </div>
    </div>
    <p>Estad&iacute;sticas del negocio filtradas por per&iacute;odo. Selecciona <strong>Reporte General</strong> en el men&uacute; lateral.</p>
    <h3>M&eacute;tricas principales</h3>
    <ul>
        <li><strong>Ventas totales:</strong> Monto total facturado en el per&iacute;odo.</li>
        <li><strong>Cortes realizados:</strong> Cantidad total de servicios completados.</li>
    </ul>
    <h3>Tablas del reporte</h3>
    <ul>
        <li><strong>Resumen por barbero:</strong> Servicios realizados y ventas por cada barbero.</li>
        <li><strong>Servicios m&aacute;s vendidos:</strong> Ordenados por cantidad de ventas.</li>
        <li><strong>Productos m&aacute;s vendidos:</strong> Ordenados por cantidad en el per&iacute;odo.</li>
        <li><strong>D&iacute;as con m&aacute;s turnos:</strong> D&iacute;as de la semana con mayor carga de trabajo.</li>
    </ul>
    <h3>Exportar</h3>
    <p>Bot&oacute;n <strong>Descargar PDF</strong> para formato PDF. Bot&oacute;n <strong>Descargar Excel</strong> para formato Excel.</p>
</div>

{{-- SECCIÓN 17 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">17</span>
            <h2>M&oacute;dulo de Blog</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Blog</div>
        </div>
    </div>
    <p>Publica art&iacute;culos visibles en el sitio web p&uacute;blico. Selecciona <strong>Blog</strong> en el men&uacute; lateral.</p>
    <h3>Crear un nuevo art&iacute;culo</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Crear art&iacute;culo</strong>.</span></li>
        <li><span>Completa: t&iacute;tulo, contenido, categor&iacute;a, imagen y estado.</span></li>
        <li><span>Selecciona <strong>Guardar</strong>.</span></li>
    </ol>
    <h3>Estados de un art&iacute;culo</h3>
    <p><span class="chip">Borrador</span> No visible en el sitio. &nbsp; <span class="chip chip-rojo">Publicado</span> Visible p&uacute;blicamente. &nbsp; <span class="chip">Archivado</span> Oculto pero conservado.</p>
    <h3>Previsualizar</h3>
    <p>Selecciona <strong>Preview</strong> para ver c&oacute;mo se ver&aacute; el art&iacute;culo en el sitio p&uacute;blico antes de publicarlo.</p>
</div>

{{-- SECCIÓN 18 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">18</span>
            <h2>Moderaci&oacute;n de Comentarios</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Comentarios</div>
        </div>
    </div>
    <p>Modera los comentarios del blog. Selecciona <strong>Comentarios</strong> en el men&uacute; lateral.</p>
    <h3>Acciones individuales</h3>
    <ul>
        <li><strong>Aprobar:</strong> El comentario pasa a ser visible en el blog.</li>
        <li><strong>Rechazar:</strong> El comentario queda oculto.</li>
        <li><strong>Eliminar:</strong> Se borra permanentemente.</li>
    </ul>
    <h3>Acciones masivas</h3>
    <p>Selecciona varios comentarios con las casillas de verificaci&oacute;n y usa los botones de acci&oacute;n masiva: <strong>Aprobar</strong>, <strong>Rechazar</strong> o <strong>Eliminar seleccionados</strong>.</p>
</div>

{{-- SECCIÓN 19 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">19</span>
            <h2>Configuraci&oacute;n del sistema</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Configuraci&oacute;n</div>
        </div>
    </div>
    <p>Ajusta los par&aacute;metros del sistema. Selecciona <strong>Configuraci&oacute;n</strong> en la parte inferior del men&uacute; lateral.</p>
    <h3>QR de Pagos</h3>
    <p>Sube las im&aacute;genes de los c&oacute;digos QR de Nequi, DaviPlata y Bancolombia. Ver secci&oacute;n 9.</p>
    <h3>Redes Sociales y WhatsApp</h3>
    <ol class="pasos">
        <li><span>Selecciona la tarjeta <strong>Redes Sociales y WhatsApp</strong>.</span></li>
        <li><span>Configura: WhatsApp, Instagram, Facebook, TikTok y YouTube.</span></li>
        <li><span>Selecciona <strong>Guardar configuraci&oacute;n</strong>.</span></li>
    </ol>
    <h3>Informaci&oacute;n Personal y Foto de Perfil</h3>
    <p>Cambia nombre de usuario, documento, correo, celular, contrase&ntilde;a y foto de perfil (JPG/PNG/GIF, m&aacute;x. 2 MB).</p>
</div>

{{-- SECCIÓN 20 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">20</span>
            <h2>Sitio web p&uacute;blico</h2>
            <div class="seccion-module-tag">Sitio p&uacute;blico</div>
        </div>
    </div>
    <p>La parte del sistema visible para cualquier visitante sin necesidad de iniciar sesi&oacute;n.</p>
    <h3>P&aacute;ginas disponibles</h3>
    <ul>
        <li><strong>Inicio:</strong> Presentaci&oacute;n con video de fondo, servicios populares y productos destacados.</li>
        <li><strong>Servicios:</strong> Cat&aacute;logo completo con precio, descuento y duraci&oacute;n.</li>
        <li><strong>Productos:</strong> Cat&aacute;logo con nombre, precio e imagen.</li>
        <li><strong>Nosotros:</strong> Historia, misi&oacute;n, visi&oacute;n, valores y equipo de barberos.</li>
        <li><strong>Contacto:</strong> Formulario, informaci&oacute;n y mapa de sedes.</li>
        <li><strong>Blog:</strong> Art&iacute;culos publicados con comentarios.</li>
    </ul>
    <h3>Agendar cita desde el sitio web</h3>
    <ol class="pasos">
        <li><span><strong>Paso 1:</strong> El cliente elige al barbero o &ldquo;Cualquier barbero&rdquo;.</span></li>
        <li><span><strong>Paso 2:</strong> Selecciona el servicio deseado.</span></li>
        <li><span><strong>Paso 3:</strong> El sistema muestra fechas y horarios disponibles.</span></li>
        <li><span><strong>Paso 4:</strong> El cliente paga el anticipo de $10.000 con QR de Nequi, DaviPlata o Bancolombia.</span></li>
        <li><span><strong>Paso 5:</strong> Ingresa nombre, c&eacute;dula y celular, y confirma la cita.</span></li>
    </ol>
    <h3>Consulta de Fidelizaci&oacute;n p&uacute;blica</h3>
    <p>Los clientes consultan su estado en el programa de lealtad ingresando su c&eacute;dula o celular. El sistema muestra visitas acumuladas, cortes gratis ganados y visitas faltantes.</p>
</div>

{{-- SECCIÓN 21 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">21</span>
            <h2>Panel del Barbero</h2>
            <div class="seccion-module-tag">Rol: Barbero</div>
        </div>
    </div>
    <p>Espacio simplificado para los empleados. El men&uacute; del barbero incluye: Inicio, Turnos, Horario, Perfil y Cerrar sesi&oacute;n.</p>
    <h3>Panel principal del barbero</h3>
    <p>Resumen semanal: Cortes realizados, Total de servicios, Ganancia (50%) y Desglose de servicios.</p>
    <h3>Turnos del barbero</h3>
    <p>Lista de turnos de la semana con fecha, hora, cliente, estado y documento. El barbero puede cambiar el estado de un turno y crear nuevos.</p>
    <h3>Horario del barbero</h3>
    <p>Vista de solo lectura del horario semanal. El d&iacute;a actual aparece resaltado.</p>
    <h3>Perfil</h3>
    <p>El barbero puede actualizar su nombre de usuario, documento y contrase&ntilde;a.</p>
</div>

{{-- SECCIÓN 22 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">22</span>
            <h2>Correos electr&oacute;nicos autom&aacute;ticos</h2>
            <div class="seccion-module-tag">Sistema &mdash; Notificaciones</div>
        </div>
    </div>
    <p>El sistema env&iacute;a los siguientes correos de forma autom&aacute;tica. No necesitas enviarlos manualmente:</p>
    <ul class="correos-list">
        <li><span><strong>Confirmaci&oacute;n de turno al cliente:</strong> Detalles de la cita (fecha, hora, barbero, servicio).</span></li>
        <li><span><strong>Notificaci&oacute;n al administrador:</strong> Aviso de nuevo turno agendado.</span></li>
        <li><span><strong>Notificaci&oacute;n al barbero:</strong> Informaci&oacute;n de la cita asignada.</span></li>
        <li><span><strong>Pago pendiente:</strong> El anticipo est&aacute; pendiente de verificaci&oacute;n.</span></li>
        <li><span><strong>Pago confirmado:</strong> El anticipo fue aceptado.</span></li>
        <li><span><strong>Fidelizaci&oacute;n:</strong> El cliente gan&oacute; un corte gratis.</span></li>
        <li><span><strong>Factura:</strong> Se puede enviar al cliente por correo desde el sistema.</span></li>
        <li><span><strong>Promoci&oacute;n:</strong> Correos de promoci&oacute;n a la base de clientes.</span></li>
        <li><span><strong>Formulario de contacto:</strong> El mensaje del visitante llega al administrador.</span></li>
        <li><span><strong>Recuperaci&oacute;n de contrase&ntilde;a:</strong> Enlace para restablecer la contrase&ntilde;a.</span></li>
    </ul>
</div>

{{-- SECCIÓN 23 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">23</span>
            <h2>Atajos de teclado</h2>
            <div class="seccion-module-tag">Accesibilidad</div>
        </div>
    </div>
    <table class="atajos">
        <thead>
            <tr>
                <th>Tecla</th>
                <th>Acci&oacute;n</th>
            </tr>
        </thead>
        <tbody>
            <tr><td><kbd>Tab</kbd></td><td>Avanza al siguiente elemento interactivo.</td></tr>
            <tr><td><kbd>Shift</kbd> + <kbd>Tab</kbd></td><td>Retrocede al elemento anterior.</td></tr>
            <tr><td><kbd>Enter</kbd></td><td>Activa el bot&oacute;n o enlace seleccionado.</td></tr>
            <tr><td><kbd>Espacio</kbd></td><td>Activa casillas de verificaci&oacute;n o botones.</td></tr>
            <tr><td><kbd>Escape</kbd></td><td>Cierra ventanas emergentes o men&uacute;s.</td></tr>
            <tr><td>Flechas arriba / abajo</td><td>Navegan entre opciones de un men&uacute; o lista.</td></tr>
            <tr><td>Flechas izquierda / derecha</td><td>Navegan entre pesta&ntilde;as o d&iacute;as del calendario.</td></tr>
            <tr><td><kbd>Alt</kbd> + <kbd>Flecha abajo</kbd></td><td>Abre un men&uacute; desplegable.</td></tr>
            <tr><td><kbd>Ctrl</kbd> + <kbd>Home</kbd></td><td>Ir al inicio de la p&aacute;gina.</td></tr>
            <tr><td><kbd>Ctrl</kbd> + <kbd>End</kbd></td><td>Ir al final de la p&aacute;gina.</td></tr>
        </tbody>
    </table>
</div>

{{-- SECCIÓN 24 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">24</span>
            <h2>Uso con lectores de pantalla</h2>
            <div class="seccion-module-tag">Accesibilidad</div>
        </div>
    </div>
    <h3>NVDA (gratuito, Windows)</h3>
    <ul>
        <li><kbd>H</kbd> &mdash; Saltar al siguiente encabezado.</li>
        <li><kbd>1</kbd> / <kbd>2</kbd> / <kbd>3</kbd> &mdash; Encabezados de nivel 1, 2 o 3.</li>
        <li><kbd>T</kbd> &mdash; Saltar a la siguiente tabla.</li>
        <li><kbd>F</kbd> &mdash; Ir al siguiente campo de formulario.</li>
        <li><kbd>B</kbd> &mdash; Ir al siguiente bot&oacute;n.</li>
        <li><kbd>Insert</kbd> + <kbd>Espacio</kbd> &mdash; Alternar modo exploraci&oacute;n y foco.</li>
    </ul>
    <h3>JAWS (Windows)</h3>
    <ul>
        <li><kbd>H</kbd> &mdash; Saltar al siguiente encabezado.</li>
        <li><kbd>Insert</kbd> + <kbd>F6</kbd> &mdash; Ver lista de encabezados.</li>
        <li><kbd>Insert</kbd> + <kbd>F7</kbd> &mdash; Ver lista de enlaces.</li>
    </ul>
    <h3>VoiceOver (Mac / iOS)</h3>
    <ul>
        <li><kbd>Command</kbd> + <kbd>F5</kbd> &mdash; Activar o desactivar VoiceOver en Mac.</li>
        <li><kbd>Control</kbd> + <kbd>Option</kbd> + Flechas &mdash; Navegar entre elementos.</li>
        <li>En iPhone/iPad: deslizar a la derecha para el siguiente elemento, tocar dos veces para activar.</li>
    </ul>
</div>

{{-- SECCIÓN 25 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">25</span>
            <h2>M&oacute;dulo de Membres&iacute;as</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Membres&iacute;as</div>
        </div>
    </div>
    <p>Crea planes de suscripci&oacute;n con beneficios exclusivos. Selecciona <strong>Membres&iacute;as</strong> en el men&uacute; lateral.</p>
    <h3>Crear una membres&iacute;a</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>+ Crear membres&iacute;a</strong>.</span></li>
        <li><span>Completa: Nombre, Descripci&oacute;n, Precio, Duraci&oacute;n (1, 3, 6 o 12 meses), Tipo de beneficio (gratis o % de descuento), L&iacute;mite de usos, Servicios aplicables, Orden e Imagen.</span></li>
        <li><span>Selecciona <strong>Crear membres&iacute;a</strong>.</span></li>
    </ol>
    <h3>Gestionar membres&iacute;as</h3>
    <ul>
        <li><strong>Activar / Desactivar:</strong> Las inactivas no aparecen en el sitio p&uacute;blico.</li>
        <li><strong>Editar:</strong> Al cambiar la imagen, la anterior se elimina autom&aacute;ticamente.</li>
        <li><strong>Eliminar:</strong> Solo si no tiene clientes con suscripci&oacute;n activa.</li>
    </ul>
    <h3>Asignar membres&iacute;a a un cliente</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Clientes con membres&iacute;as</strong>.</span></li>
        <li><span>Ingresa la c&eacute;dula del cliente, selecciona la membres&iacute;a y la fecha de inicio. La fecha de vencimiento se calcula autom&aacute;ticamente.</span></li>
        <li><span>Para cancelar una suscripci&oacute;n usa el bot&oacute;n <strong>Cancelar</strong> en la fila.</span></li>
    </ol>
</div>

{{-- SECCIÓN 26 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">26</span>
            <h2>M&oacute;dulo de Gastos</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Gastos</div>
        </div>
    </div>
    <p>Registra egresos del negocio y genera reportes financieros. Selecciona <strong>Gastos</strong> en el men&uacute; lateral.</p>
    <h3>Registrar un nuevo gasto</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>+ Registrar gasto</strong>.</span></li>
        <li><span>Completa: Categor&iacute;a, Sede (opcional), Descripci&oacute;n, Monto, Fecha y Comprobante (PDF/JPG/PNG, m&aacute;x. 5 MB).</span></li>
        <li><span>Selecciona <strong>Guardar gasto</strong>.</span></li>
    </ol>
    <h3>Filtrar y exportar</h3>
    <p>Filtra por rango de fechas, categor&iacute;a, sede o descripci&oacute;n. Usa <strong>Exportar Excel</strong> para descargar los gastos filtrados.</p>
    <h3>Reporte financiero (Ingresos vs. Gastos)</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Reporte Financiero</strong>.</span></li>
        <li><span>El reporte muestra: total de ingresos, total de gastos, ganancia neta y desglose por categor&iacute;a.</span></li>
        <li><span>Exportable a Excel con <strong>Exportar reporte</strong>.</span></li>
    </ol>
</div>

{{-- SECCIÓN 27 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">27</span>
            <h2>Perfil y configuraci&oacute;n de WhatsApp</h2>
            <div class="seccion-module-tag">M&oacute;dulo: Configuraci&oacute;n</div>
        </div>
    </div>
    <h3>Actualizar informaci&oacute;n personal</h3>
    <ol class="pasos">
        <li><span>Selecciona <strong>Informaci&oacute;n Personal</strong> en Configuraci&oacute;n.</span></li>
        <li><span>Actualiza: Usuario, Documento, Nombres, Apellidos, Correo y Celular.</span></li>
        <li><span>Presiona <strong>Guardar cambios</strong>.</span></li>
    </ol>
    <h3>Cambiar la contrase&ntilde;a</h3>
    <ol class="pasos">
        <li><span>En Informaci&oacute;n Personal, despl&aacute;zate a <strong>Cambiar contrase&ntilde;a</strong>.</span></li>
        <li><span>Ingresa la contrase&ntilde;a actual y la nueva (m&iacute;nimo 8 caracteres, una may&uacute;scula y un n&uacute;mero).</span></li>
        <li><span>Conf&iacute;rmala y presiona <strong>Cambiar contrase&ntilde;a</strong>.</span></li>
    </ol>
    <h3>Configurar WhatsApp del sitio p&uacute;blico</h3>
    <ol class="pasos">
        <li><span>Selecciona la tarjeta <strong>Redes Sociales y WhatsApp</strong>.</span></li>
        <li><span>Escribe el n&uacute;mero en formato internacional sin espacios.</span></li>
        <li><span>Presiona <strong>Guardar configuraci&oacute;n</strong>.</span></li>
    </ol>
    <div class="nota-importante">
        <div class="nota-title">Formato del n&uacute;mero</div>
        <p>El n&uacute;mero debe estar <strong>sin espacios, guiones ni par&eacute;ntesis</strong>.<br>
        Correcto: <code>573001234567</code> &nbsp;&middot;&nbsp; Incorrecto: <code>300 123 4567</code></p>
    </div>
    <h3>D&oacute;nde aparecen los botones de WhatsApp</h3>
    <ul>
        <li>Bot&oacute;n flotante y secci&oacute;n de contacto en la P&aacute;gina de Inicio.</li>
        <li>P&aacute;ginas de Servicios, Contacto y Fidelizaci&oacute;n.</li>
        <li>Footer del sitio web p&uacute;blico.</li>
        <li>M&oacute;dulo CRM: clientes resaltados en naranja (m&aacute;s de 2 meses sin visitar).</li>
        <li>M&oacute;dulo de Turnos: detalle de cada turno.</li>
    </ul>
</div>

{{-- SECCIÓN 28 --}}
<div class="seccion seccion-pagina">
    <div class="seccion-head">
        <div class="seccion-head-left">
            <span class="seccion-num">28</span>
            <h2>D&oacute;nde pedir ayuda</h2>
            <div class="seccion-module-tag">Soporte</div>
        </div>
    </div>
    <p>Si tienes alguna dificultad, estas son las formas de obtener ayuda:</p>
    <ul>
        <li><strong>Administrador del sistema:</strong> Si eres barbero, comun&iacute;cate con el administrador para problemas de acceso o configuraci&oacute;n.</li>
        <li><strong>WhatsApp de soporte:</strong> Env&iacute;a un mensaje describiendo tu problema. El equipo responder&aacute; lo antes posible.</li>
        <li><strong>Formulario de contacto:</strong> Desde la p&aacute;gina p&uacute;blica de Contacto puedes enviar tu consulta.</li>
        <li><strong>Presencial:</strong> Acude a la sede de la barber&iacute;a y pide asistencia directamente al personal.</li>
    </ul>
    <div class="nota-info">
        <div class="nota-title">Recuerda</div>
        <p>Este manual siempre est&aacute; disponible desde el m&oacute;dulo de <strong>Configuraci&oacute;n</strong> del sistema. Puedes consultarlo en cualquier momento.</p>
    </div>
</div>

{{-- PIE DE PÁGINA --}}
<div class="pie-pagina">
    <div class="pie-left">
        <div class="pie-text">&copy; {{ date('Y') }} <span>H Barber Shop</span> &mdash; Manual de Usuario &mdash; Todos los derechos reservados</div>
    </div>
    <div class="pie-right">
        <div class="pie-text">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
    </div>
</div>

</body>
</html>