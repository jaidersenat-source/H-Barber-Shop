<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - H Barber Shop</title>
    <style type="text/css">
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
    padding: 20px;
    line-height: 1.6;
}
.email-container {
    max-width: 600px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.header {
    background: linear-gradient(135deg, #7d1935 0%, #a82647 100%);
    color: #ffffff;
    padding: 40px 30px;
    text-align: center;
    position: relative;
}
.header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,.05) 10px, rgba(255,255,255,.05) 20px);
}
.header-content {
    position: relative;
    z-index: 1;
}
.icon-receipt {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.header h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}
.header p {
    font-size: 16px;
    opacity: 0.95;
}
.content {
    padding: 40px 30px;
}
.thank-you-message {
    text-align: center;
    margin-bottom: 30px;
}
.thank-you-message h2 {
    color: #2d3748;
    font-size: 24px;
    margin-bottom: 10px;
}
.thank-you-message p {
    color: #718096;
    font-size: 15px;
}
.details-card {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 30px;
}
.detail-row {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #cbd5e0;
}
.detail-row:last-child {
    border-bottom: none;
}
.detail-icon {
    width: 40px;
    height: 40px;
    background: #7d1935;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}
.detail-content {
    flex: 1;
}
.detail-label {
    font-size: 12px;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-bottom: 2px;
}
.detail-value {
    font-size: 16px;
    color: #2d3748;
    font-weight: 600;
}
.pdf-notice {
    background: linear-gradient(135deg, #7d1935 0%, #a82647 100%);
    color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 25px;
}
.pdf-notice svg {
    margin-bottom: 10px;
}
.pdf-notice p {
    font-size: 14px;
    line-height: 1.5;
}
.pdf-notice strong {
    font-size: 16px;
}
.contact-info {
    background: #f7fafc;
    border-left: 4px solid #7d1935;
    padding: 15px 20px;
    border-radius: 6px;
    margin-top: 20px;
}
.contact-info p {
    color: #4a5568;
    font-size: 14px;
    margin: 5px 0;
}
.footer {
    background: #2d3748;
    color: #cbd5e0;
    padding: 30px;
    text-align: center;
}
.footer-logo {
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 10px;
}
.footer p {
    font-size: 13px;
    margin: 5px 0;
}
.footer-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
    margin: 20px 0;
}
.footer-links {
    margin-top: 15px;
}
.footer-links a {
    color: #a0aec0;
    text-decoration: none;
    margin: 0 10px;
    font-size: 12px;
    transition: color 0.3s ease;
}
.footer-links a:hover {
    color: #ffffff;
}
@media (max-width: 600px) {
    body {
        padding: 10px;
    }
    .header {
        padding: 30px 20px;
    }
    .header h1 {
        font-size: 24px;
    }
    .content {
        padding: 30px 20px;
    }
    .details-card {
        padding: 20px 15px;
    }
    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        padding: 15px 0;
    }
    .detail-icon {
        margin-bottom: 10px;
    }
    .footer {
        padding: 25px 20px;
    }
    .footer-links a {
        display: block;
        margin: 8px 0;
    }
}
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="icon-receipt">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <h1>Factura Generada</h1>
                <p>Comprobante de tu servicio</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="thank-you-message">
                <h2>¡Gracias por tu compra!</h2>
                <p>Hemos procesado exitosamente tu pago. A continuación los detalles:</p>
            </div>

            <!-- Details Card -->
            <div class="details-card">
                <div class="detail-row">
                    <div class="detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Cliente</div>
                        <div class="detail-value">{{ $factura->turno->tur_nombre ?? 'No especificado' }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Fecha de Emisión</div>
                        <div class="detail-value">{{ $factura->fac_fecha }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Sede</div>
                        <div class="detail-value">{{ $factura->sede->sede_nombre ?? 'No especificada' }}</div>
                    </div>
                </div>
            </div>

            <!-- PDF Notice -->
            <div class="pdf-notice">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="12" y1="18" x2="12" y2="12"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
                <p><strong>Factura Adjunta</strong></p>
                <p>Encontrarás el detalle completo de tu servicio en el archivo PDF adjunto a este correo.</p>
            </div>

            <!-- Contact Info -->
            <div class="contact-info">
                <p><strong>¿Tienes alguna pregunta?</strong></p>
                <p>Si necesitas asistencia o tienes dudas sobre tu factura, no dudes en contactarnos.</p>
                <p>Estamos aquí para ayudarte.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">H Barber Shop</div>
            <p>Tu barbería de confianza</p>
            <div class="footer-divider"></div>
            <p style="font-size: 12px;">Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p style="font-size: 12px;">© 2025 H Barber Shop. Todos los derechos reservados.</p>
            <div class="footer-links">
                <a href="#">Política de Privacidad</a>
                <a href="#">Términos y Condiciones</a>
                <a href="#">Contacto</a>
            </div>
        </div>
    </div>
</body>
</html>
