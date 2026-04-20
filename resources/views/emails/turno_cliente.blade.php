<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Confirmación de Turno - H Barber Shop</title>
  <style>
    /* Añadiendo estilos profesionales para el email */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
      line-height: 1.6;
      color: #333;
    }
    
    .email-wrapper {
      width: 100%;
      background-color: #f5f5f5;
      padding: 40px 20px;
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .header {
      background: linear-gradient(135deg, #8B0000 0%, #660000 100%);
      color: #ffffff;
      padding: 40px 30px;
      text-align: center;
    }
    
    .header h1 {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 8px 0;
      letter-spacing: -0.5px;
    }
    
    .header p {
      font-size: 14px;
      margin: 0;
      opacity: 0.95;
    }
    
    .content {
      padding: 40px 30px;
    }
    
    .greeting {
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
    }
    
    .greeting strong {
      color: #8B0000;
    }
    
    .intro-text {
      font-size: 15px;
      color: #555;
      margin-bottom: 30px;
      line-height: 1.7;
    }
    
    .details-card {
      background: #f9f9f9;
      border-left: 4px solid #8B0000;
      border-radius: 8px;
      padding: 25px;
      margin: 30px 0;
    }
    
    .details-card h2 {
      font-size: 16px;
      color: #8B0000;
      margin: 0 0 20px 0;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .detail-row {
      display: flex;
      padding: 12px 0;
      border-bottom: 1px solid #e5e5e5;
    }
    
    .detail-row:last-child {
      border-bottom: none;
    }
    
    .detail-label {
      font-weight: 600;
      color: #666;
      min-width: 140px;
      font-size: 14px;
    }
    
    .detail-value {
      color: #333;
      font-size: 14px;
      font-weight: 500;
    }
    
    .info-box {
      background: #fff8e6;
      border: 1px solid #ffd966;
      border-radius: 8px;
      padding: 20px;
      margin: 25px 0;
      display: flex;
      align-items: start;
      gap: 15px;
    }
    
    .info-icon {
      font-size: 24px;
      color: #d4a017;
      flex-shrink: 0;
    }
    
    .info-text {
      font-size: 14px;
      color: #6b5a00;
      line-height: 1.6;
    }
    
    .cta-section {
      text-align: center;
      margin-top: 35px;
      padding-top: 30px;
      border-top: 1px solid #e5e5e5;
    }
    
    .cta-button {
      display: inline-block;
      background: #8B0000;
      color: #ffffff !important;
      text-decoration: none;
      padding: 14px 36px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 15px;
      transition: background 0.3s ease;
      box-shadow: 0 2px 8px rgba(139, 0, 0, 0.2);
    }
    
    .cta-button:hover {
      background: #660000;
    }
    
    .footer {
      background: #2d2d2d;
      color: #ffffff;
      padding: 30px;
      text-align: center;
    }
    
    .footer p {
      margin: 8px 0;
      font-size: 13px;
      opacity: 0.9;
    }
    
    .footer-brand {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 10px;
      color: #ffffff;
    }
    
    .footer-contact {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .social-links {
      margin-top: 15px;
    }
    
    .social-links a {
      color: #ffffff;
      text-decoration: none;
      margin: 0 10px;
      font-size: 13px;
      opacity: 0.9;
    }
    
    /* Responsive Design */
    @media only screen and (max-width: 600px) {
      .email-wrapper {
        padding: 20px 10px;
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
        gap: 5px;
      }
      
      .detail-label {
        min-width: auto;
        font-size: 13px;
      }
      
      .detail-value {
        font-size: 15px;
      }
      
      .info-box {
        padding: 15px;
      }
      
      .cta-button {
        display: block;
        width: 100%;
        padding: 16px;
      }
      
      .footer {
        padding: 25px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="container">
      <!-- Header Section -->
      <div class="header">
        <h1>¡Tu Turno está Confirmado!</h1>
        <p>H Barber Shop - Estilo y Profesionalismo</p>
      </div>

      <!-- Content Section -->
      <div class="content">
        <div class="greeting">
          Hola <strong>{{ $turno->tur_nombre }}</strong>,
        </div>

        <p class="intro-text">
          Nos complace confirmar tu cita en H Barber Shop. Estamos comprometidos en brindarte la mejor experiencia y un servicio de calidad excepcional.
        </p>

        <!-- Details Card -->
        <div class="details-card">
          <h2>Detalles de tu Cita</h2>
          
          <div class="detail-row">
            <div class="detail-label">📅 Fecha:</div>
            <div class="detail-value">{{ $turno->tur_fecha }}</div>
          </div>
          
          <div class="detail-row">
            <div class="detail-label">🕐 Hora:</div>
            <div class="detail-value">{{ $turno->tur_hora }}</div>
          </div>
          
          <div class="detail-row">
            <div class="detail-label">✂️ Barbero:</div>
            <div class="detail-value">{{ $turno->barbero ? $turno->barbero->per_nombre : 'Por asignar' }}</div>
          </div>
        </div>

        <!-- Info Box -->
        <div class="info-box">
          <div class="info-icon">💡</div>
          <div class="info-text">
            <strong>Recordatorio importante:</strong> Por favor, llega 5 minutos antes de tu turno para asegurar que recibas la mejor atención posible y evitar retrasos.
          </div>
        </div>

        <!-- Call to Action -->
        <div class="cta-section">
          <p style="margin-bottom: 20px; color: #666; font-size: 14px;">
            ¿Necesitas hacer algún cambio o conocer más sobre nuestros servicios?
          </p>
          <a href="{{ url('/') }}" class="cta-button" target="_blank">
            Visitar Nuestra Página
          </a>
        </div>
      </div>

      <!-- Footer Section -->
      <div class="footer">
        <div class="footer-brand">H Barber Shop</div>
        <p>Tu barbería de confianza</p>
        
        <div class="footer-contact">
          <p>Si necesitas reprogramar o cancelar tu cita, contáctanos lo antes posible.</p>
          <p style="margin-top: 10px;">Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
        
        <div class="social-links">
          <p style="font-size: 12px; opacity: 0.7; margin-top: 15px;">
            © {{ date('Y') }} H Barber Shop. Todos los derechos reservados.
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
