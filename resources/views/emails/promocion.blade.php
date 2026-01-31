<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Nueva promoción disponible!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #8B1538 0%, #A61E4D 50%, #C2255C 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .discount-badge {
            display: inline-block;
            background-color: #FFD700;
            color: #8B1538;
            font-size: 18px;
            font-weight: bold;
            padding: 8px 20px;
            border-radius: 25px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .header h1 {
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }

        .content {
            padding: 40px 30px;
        }

        .promo-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #8B1538;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .item-name {
            font-size: 24px;
            font-weight: 700;
            color: #8B1538;
            margin-bottom: 20px;
            text-align: center;
        }

        .price-comparison {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 25px 0;
            flex-wrap: wrap;
            gap: 20px;
        }

        .price-box {
            text-align: center;
            flex: 1;
            min-width: 150px;
        }

        .price-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .original-price {
            font-size: 22px;
            color: #999;
            text-decoration: line-through;
            font-weight: 600;
        }

        .discount-price {
            font-size: 32px;
            color: #8B1538;
            font-weight: 700;
        }

        .arrow {
            font-size: 32px;
            color: #8B1538;
        }

        .savings-badge {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: #8B1538;
            padding: 12px 25px;
            border-radius: 8px;
            text-align: center;
            font-weight: 700;
            font-size: 18px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
        }

        .cta-section {
            background: linear-gradient(135deg, #8B1538 0%, #A61E4D 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-top: 30px;
        }

        .cta-section p {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .cta-text {
            font-size: 16px;
            opacity: 0.95;
            margin-top: 10px;
        }

        .info-box {
            background-color: #fff8e1;
            border-left: 4px solid #FFD700;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-box p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .footer {
            background-color: #2c2c2c;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .footer-brand {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #8B1538;
        }

        .footer-info {
            font-size: 14px;
            color: #cccccc;
            margin: 5px 0;
        }

        .footer-divider {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #8B1538 0%, #A61E4D 100%);
            margin: 20px auto;
            border-radius: 2px;
        }

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

            .content {
                padding: 25px 20px;
            }

            .item-name {
                font-size: 20px;
            }

            .price-comparison {
                flex-direction: column;
            }

            .arrow {
                transform: rotate(90deg);
                font-size: 24px;
            }

            .discount-price {
                font-size: 28px;
            }

            .original-price {
                font-size: 20px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .discount-badge {
                animation: none;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                @if($tipo === 'servicio')
                    <div class="discount-badge">🎉 {{ $item->serv_descuento }}% OFF</div>
                @else
                    <div class="discount-badge">🎉 {{ $item->pro_descuento }}% OFF</div>
                @endif
                <h1>¡Oferta Especial para Ti!</h1>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="promo-card">
                @if($tipo === 'servicio')
                    <div class="item-name">{{ $item->serv_nombre }}</div>
                    
                    <div class="price-comparison">
                        <div class="price-box">
                            <div class="price-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Precio regular
                            </div>
                            <div class="original-price">${{ number_format($item->serv_precio, 2) }}</div>
                        </div>

                        <div class="arrow">→</div>

                        <div class="price-box">
                            <div class="price-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Precio promocional
                            </div>
                            <div class="discount-price">${{ number_format($item->serv_precio * (1 - $item->serv_descuento/100), 2) }}</div>
                        </div>
                    </div>

                    <div class="savings-badge">
                        ¡Ahorras ${{ number_format($item->serv_precio * ($item->serv_descuento/100), 2) }}!
                    </div>
                @else
                    <div class="item-name">{{ $item->pro_nombre }}</div>
                    
                    <div class="price-comparison">
                        <div class="price-box">
                            <div class="price-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                Precio regular
                            </div>
                            <div class="original-price">${{ number_format($item->pro_precio, 2) }}</div>
                        </div>

                        <div class="arrow">→</div>

                        <div class="price-box">
                            <div class="price-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Precio promocional
                            </div>
                            <div class="discount-price">${{ number_format($item->pro_precio * (1 - $item->pro_descuento/100), 2) }}</div>
                        </div>
                    </div>

                    <div class="savings-badge">
                        ¡Ahorras ${{ number_format($item->pro_precio * ($item->pro_descuento/100), 2) }}!
                    </div>
                @endif
            </div>

            <div class="info-box">
                <p><strong>💡 Importante:</strong> Menciona esta promoción al momento de tu visita para aplicar el descuento.</p>
            </div>

            <div class="cta-section">
                <p>🎯 ¡No dejes pasar esta oportunidad única!</p>
                <p class="cta-text">Visítanos en cualquiera de nuestras sedes y pregunta por esta promoción especial.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">H Barber Shop</div>
            <div class="footer-divider"></div>
            <p class="footer-info">Tu barbería de confianza</p>
            <p class="footer-info">Estilo, calidad y profesionalismo</p>
            <p class="footer-info" style="margin-top: 15px; font-size: 12px; opacity: 0.8;">
                Este es un correo promocional de H Barber Shop<br>
                Gracias por tu preferencia
            </p>
        </div>
    </div>
</body>
</html>
