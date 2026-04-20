<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nuevo Turno Asignado - H Barber Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Header con gradiente elegante */
        .header {
            background: linear-gradient(135deg, #7d1935 0%, #a8203e 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        
        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            font-weight: 400;
        }
        
        /* Contenido principal */
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 24px;
            line-height: 1.5;
        }
        
        .greeting strong {
            color: #7d1935;
            font-weight: 600;
        }
        
        /* Tarjeta de detalles del turno */
        .appointment-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
        }
        
        .appointment-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px dashed #dee2e6;
        }
        
        .appointment-header h2 {
            color: #7d1935;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .detail-row {
            display: flex;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #f1f3f5;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #7d1935 0%, #a8203e 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            flex-shrink: 0;
        }
        
        .detail-content {
            flex: 1;
        }
        
        .detail-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .detail-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        /* Mensaje motivacional */
        .motivation-box {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            border-left: 4px solid #7d1935;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
        }
        
        .motivation-box p {
            color: #495057;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }
        
        .motivation-box strong {
            color: #7d1935;
        }
        
        /* Botón de acción */
        .cta-container {
            text-align: center;
            margin: 32px 0 24px;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #7d1935 0%, #a8203e 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 12px rgba(125, 25, 53, 0.3);
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(125, 25, 53, 0.4);
        }
        
        /* Footer */
        .footer {
            background: #2c3e50;
            padding: 30px;
            text-align: center;
        }
        
        .footer-brand {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }
        
        .footer-info {
            color: #95a5a6;
            font-size: 14px;
            margin: 8px 0;
        }
        
        .footer-divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #7d1935 0%, #a8203e 100%);
            margin: 16px auto;
            border-radius: 2px;
        }
        
        .footer-copyright {
            color: #7f8c8d;
            font-size: 13px;
            margin-top: 16px;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 0;
            }
            
            .email-container {
                border-radius: 0;
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
            
            .greeting {
                font-size: 16px;
            }
            
            .appointment-card {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
                text-align: center;
                padding: 16px 0;
            }
            
            .detail-icon {
                margin: 0 0 12px 0;
            }
            
            .footer {
                padding: 24px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>📋 Nuevo Turno Asignado</h1>
                <p>H Barber Shop - Sistema de Gestión</p>
            </div>
        </div>
        
        <!-- Contenido principal -->
        <div class="content">
            <div class="greeting">
                Hola <strong>{{ $turno->barbero ? $turno->barbero->per_nombre : 'Barbero' }}</strong>,<br>
                Se te ha asignado un nuevo turno. A continuación, encontrarás todos los detalles:
            </div>
            
            <!-- Tarjeta de detalles -->
            <div class="appointment-card">
                <div class="appointment-header">
                    <h2>Detalles del Turno</h2>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon">
                        <svg width="20" height="20" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Cliente</div>
                        <div class="detail-value">{{ $turno->tur_nombre }}</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon">
                        <svg width="20" height="20" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Fecha</div>
                        <div class="detail-value">{{ $turno->tur_fecha }}</div>
                    </div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-icon">
                        <svg width="20" height="20" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Hora</div>
                        <div class="detail-value">{{ $turno->tur_hora }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Mensaje motivacional -->
            <div class="motivation-box">
                <p>
                    <strong>💈 Recuerda:</strong> Prepara tus herramientas y revisa tu agenda para ofrecer el mejor servicio. 
                    Tu profesionalismo y dedicación hacen la diferencia en la experiencia de nuestros clientes.
                </p>
            </div>
            
            <!-- Botón de acción -->
            <div class="cta-container">
                <a href="#" class="cta-button">Ver Mi Agenda Completa</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">H Barber Shop</div>
            <div class="footer-divider"></div>
            <div class="footer-info">Sistema de Gestión de Turnos</div>
            <div class="footer-info">Excelencia en cada servicio</div>
            <div class="footer-copyright">
                © {{ date('Y') }} H Barber Shop. Todos los derechos reservados.
            </div>
        </div>
    </div>
</body>
</html>
