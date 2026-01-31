<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Felicidades, eres cliente fidelizado!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #8B1538 0%, #A91D3A 50%, #C7253E 100%);
            color: white;
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
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .celebration-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .header p {
            font-size: 18px;
            opacity: 0.95;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 24px;
            color: #8B1538;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .achievement-box {
            background: linear-gradient(135deg, #FFF5F7 0%, #FFE8ED 100%);
            border: 2px solid #8B1538;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            position: relative;
        }
        
        .achievement-box::before,
        .achievement-box::after {
            content: '★';
            position: absolute;
            font-size: 24px;
            color: #C7253E;
            opacity: 0.3;
        }
        
        .achievement-box::before {
            top: 10px;
            left: 15px;
        }
        
        .achievement-box::after {
            bottom: 10px;
            right: 15px;
        }
        
        .visits-counter {
            font-size: 48px;
            font-weight: 700;
            color: #8B1538;
            margin: 15px 0;
            text-shadow: 2px 2px 4px rgba(139, 21, 56, 0.1);
        }
        
        .visits-label {
            font-size: 16px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .reward-card {
            background: linear-gradient(135deg, #8B1538 0%, #C7253E 100%);
            color: white;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 8px 16px rgba(139, 21, 56, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .reward-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .reward-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        
        .reward-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
        }
        
        .reward-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .reward-description {
            font-size: 18px;
            opacity: 0.95;
            margin-bottom: 20px;
        }
        
        .coupon-code {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            border: 2px dashed rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
        }
        
        .instructions {
            background-color: #FFF9E6;
            border-left: 4px solid #FFC107;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .instructions-title {
            font-weight: 600;
            color: #8B1538;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .instructions-text {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .thank-you {
            text-align: center;
            padding: 30px 0;
            color: #666;
        }
        
        .thank-you p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .brand-name {
            font-weight: 700;
            color: #8B1538;
            font-size: 20px;
        }
        
        .footer {
            background-color: #2D2D2D;
            color: #CCCCCC;
            padding: 30px;
            text-align: center;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: 700;
            color: #C7253E;
            margin-bottom: 15px;
        }
        
        .footer-info {
            font-size: 14px;
            line-height: 1.8;
            margin: 10px 0;
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            color: #C7253E;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .header p {
                font-size: 16px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .greeting {
                font-size: 20px;
            }
            
            .visits-counter {
                font-size: 36px;
            }
            
            .reward-title {
                font-size: 20px;
            }
            
            .achievement-box,
            .reward-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="celebration-icon">
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="white" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h1>¡Felicidades!</h1>
                <p>Has alcanzado un logro especial</p>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <p class="greeting">Hola {{ $turno->tur_nombre }},</p>
            
            <p style="font-size: 16px; color: #666; text-align: center; margin-bottom: 20px;">
                Queremos reconocer tu lealtad y preferencia por H Barber Shop
            </p>
            
            <!-- Achievement Box -->
            <div class="achievement-box">
                <p class="visits-label">Has completado</p>
                <div class="visits-counter">{{ $fidelizacion->visitas_acumuladas }}</div>
                <p class="visits-label">Cortes en H Barber Shop</p>
            </div>
            
            <!-- Reward Card -->
            <div class="reward-card">
                <div class="reward-content">
                    <svg class="reward-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 12V22H4V12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 7H2V12H22V7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 22V7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 7H7.5C6.83696 7 6.20107 6.73661 5.73223 6.26777C5.26339 5.79893 5 5.16304 5 4.5C5 3.83696 5.26339 3.20107 5.73223 2.73223C6.20107 2.26339 6.83696 2 7.5 2C11 2 12 7 12 7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 7H16.5C17.163 7 17.7989 6.73661 18.2678 6.26777C18.7366 5.79893 19 5.16304 19 4.5C19 3.83696 18.7366 3.20107 18.2678 2.73223C17.7989 2.26339 17.163 2 16.5 2C13 2 12 7 12 7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h2 class="reward-title">Tu Recompensa</h2>
                    <p class="reward-description">Tu próximo corte es</p>
                    <p style="font-size: 28px; font-weight: 700; margin-bottom: 15px;">TOTALMENTE GRATIS</p>
                    <div class="coupon-code">CLIENTE FIDELIZADO</div>
                </div>
            </div>
            
            <!-- Instructions -->
            <div class="instructions">
                <p class="instructions-title">¿Cómo usar tu corte gratis?</p>
                <p class="instructions-text">
                    Simplemente menciona que eres un cliente fidelizado en tu próxima visita 
                    o muestra este correo electrónico. Nuestro equipo aplicará tu descuento 
                    automáticamente.
                </p>
            </div>
            
            <!-- Thank You -->
            <div class="thank-you">
                <p>Gracias por tu preferencia y lealtad</p>
                <p class="brand-name">H Barber Shop</p>
                <p style="font-size: 14px; color: #999; margin-top: 15px;">
                    Seguimos comprometidos con brindarte el mejor servicio
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">H Barber Shop</div>
            <div class="footer-info">
                Tu barbería de confianza<br>
                Estilo, calidad y profesionalismo
            </div>
            <div class="social-links">
                <a href="#">Instagram</a> | 
                <a href="#">Facebook</a> | 
                <a href="#">WhatsApp</a>
            </div>
            <p style="font-size: 12px; color: #999; margin-top: 20px;">
                © 2025 H Barber Shop. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>
