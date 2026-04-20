<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>✅ Pago Confirmado - Tu Turno está Listo</title>
	<style>
		/* Diseño profesional y accesible optimizado para lectores de pantalla */
		body { 
			background: #f5f5f5; 
			margin: 0; 
			padding: 0; 
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			line-height: 1.6;
			color: #333;
		}
		.container { 
			max-width: 650px; 
			margin: 20px auto; 
			background: #ffffff; 
			border-radius: 8px; 
			box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
			overflow: hidden;
			border: 1px solid #e0e0e0;
		}
		.header { 
			background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
			color: #ffffff; 
			padding: 30px 20px; 
			text-align: center;
			border-bottom: 4px solid #1e7e34;
		}
		.header h1 { 
			margin: 0 0 8px 0; 
			font-size: 26px; 
			font-weight: 700;
			letter-spacing: 0.5px;
		}
		.header p {
			margin: 0;
			font-size: 14px;
			opacity: 0.95;
		}
		.success-badge {
			background: #ffffff;
			color: #28a745;
			display: inline-block;
			padding: 8px 16px;
			border-radius: 20px;
			font-size: 14px;
			font-weight: 600;
			margin-top: 15px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.content { 
			padding: 35px 30px;
		}
		.intro-text {
			font-size: 16px;
			margin-bottom: 25px;
			color: #555;
		}
		.section-title {
			font-size: 18px;
			font-weight: 700;
			color: #28a745;
			margin: 25px 0 15px 0;
			padding-bottom: 8px;
			border-bottom: 2px solid #28a745;
		}
		.details { 
			background: #f8fff9; 
			border-left: 4px solid #28a745;
			border-radius: 6px; 
			padding: 20px 24px; 
			margin: 20px 0;
		}
		.detail-row { 
			margin: 14px 0;
			font-size: 15px;
			display: flex;
			flex-wrap: wrap;
		}
		.detail-label { 
			font-weight: 700;
			color: #333;
			min-width: 150px;
			margin-right: 10px;
		}
		.detail-value { 
			color: #555;
			flex: 1;
		}
		.payment-confirmation {
			background: #d4edda;
			border: 2px solid #28a745;
			border-radius: 6px;
			padding: 20px;
			margin: 25px 0;
			text-align: center;
		}
		.payment-amount {
			font-size: 24px;
			font-weight: 700;
			color: #155724;
			margin-bottom: 10px;
		}
		.confirmation-text {
			font-size: 16px;
			color: #155724;
			font-weight: 600;
		}
		.highlight-box {
			background: #fff3cd;
			border: 2px solid #ffc107;
			border-radius: 6px;
			padding: 20px;
			margin: 25px 0;
			text-align: center;
		}
		.highlight-box h3 {
			margin: 0 0 10px 0;
			color: #856404;
			font-size: 18px;
		}
		.highlight-box p {
			margin: 5px 0;
			color: #856404;
			font-size: 16px;
		}
		.info-box {
			background: #e8f4fd;
			border: 2px solid #007bff;
			border-radius: 6px;
			padding: 18px;
			margin: 25px 0;
		}
		.footer { 
			background: #f8f9fa; 
			color: #6c757d; 
			text-align: center; 
			padding: 20px; 
			border-top: 1px solid #dee2e6;
			font-size: 13px;
		}
		.footer p { 
			margin: 5px 0; 
		}
		.footer a {
			color: #007bff;
			text-decoration: none;
		}
		.footer a:hover {
			text-decoration: underline;
		}
		@media (max-width: 480px) {
			.container { 
				margin: 10px; 
				border-radius: 4px; 
			}
			.content { 
				padding: 20px; 
			}
			.detail-row { 
				flex-direction: column; 
			}
			.detail-label { 
				min-width: auto; 
				margin-bottom: 5px; 
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>✅ ¡Pago Confirmado!</h1>
			<p>Tu turno ha sido confirmado exitosamente</p>
			<div class="success-badge">Confirmado</div>
		</div>

		<div class="content">
			<p class="intro-text">
				¡Hola <strong>{{ $turno->tur_nombre }}</strong>!<br><br>
				Nos complace informarte que hemos confirmado tu pago y tu turno está oficialmente reservado. 🎉
			</p>

			<div class="payment-confirmation">
				<div class="payment-amount">✅ Anticipo Confirmado: ${{ number_format($turno->tur_anticipo, 0, ',', '.') }}</div>
				<div class="confirmation-text">Referencia: {{ $turno->tur_referencia_pago }}</div>
			</div>

			<h2 class="section-title">📅 Detalles de tu Turno</h2>
			<div class="details">
				<div class="detail-row">
					<span class="detail-label">📅 Fecha:</span>
					<span class="detail-value">{{ \Carbon\Carbon::parse($turno->tur_fecha)->format('l, d \d\e F \d\e Y') }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">⏰ Hora:</span>
					<span class="detail-value">{{ \Carbon\Carbon::parse($turno->tur_hora)->format('H:i') }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">✂️ Servicio:</span>
					<span class="detail-value">{{ $servicio->serv_nombre ?? 'Servicio seleccionado' }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">⏱️ Duración:</span>
					<span class="detail-value">{{ $turno->tur_duracion }} minutos</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">👨‍💼 Barbero:</span>
					<span class="detail-value">{{ $barbero->persona->per_nombre ?? 'Nuestro equipo te atenderá' }}</span>
				</div>
			</div>

			<div class="highlight-box">
				<h3>🎯 ¿Qué sigue?</h3>
				<p>Solo presenta tu cédula el día de la cita</p>
				<p>El saldo restante se paga al finalizar el servicio</p>
			</div>

			<div class="info-box">
				<h3 style="color: #004085; margin: 0 0 15px 0;">📋 Información Importante</h3>
				<p style="color: #004085; margin: 5px 0;"><strong>Saldo pendiente:</strong> ${{ number_format(($servicio->serv_precio ?? 0) - $turno->tur_anticipo, 0, ',', '.') }}</p>
				<p style="color: #004085; margin: 5px 0;"><strong>Llega 10 minutos antes</strong> de tu cita</p>
				<p style="color: #004085; margin: 5px 0;"><strong>Cancelaciones:</strong> Con al menos 2 horas de anticipación</p>
				<p style="color: #004085; margin: 5px 0;"><strong>Ubicación:</strong> H Barber Shop - Tu dirección aquí</p>
			</div>

			<h2 class="section-title">📞 ¿Necesitas ayuda?</h2>
			<p>Si tienes alguna pregunta o necesitas reprogramar tu cita, contáctanos:</p>
			<p>📱 <strong>WhatsApp:</strong> +57 123 456 7890</p>
			<p>📧 <strong>Email:</strong> info@hbarbershop.com</p>
		</div>

		<div class="footer">
			<p><strong>H Barber Shop</strong></p>
			<p>Síguenos en redes sociales para tips y promociones</p>
			<p><a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">WhatsApp</a></p>
		</div>
	</div>
</body>
</html>