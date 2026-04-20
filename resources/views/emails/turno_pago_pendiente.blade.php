<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>🔔 Turno con Pago Pendiente - H Barber Shop</title>
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
			background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
			color: #ffffff; 
			padding: 30px 20px; 
			text-align: center;
			border-bottom: 4px solid #d55a26;
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
		.alert-badge {
			background: #ff4444;
			color: white;
			display: inline-block;
			padding: 8px 16px;
			border-radius: 20px;
			font-size: 14px;
			font-weight: 600;
			margin-top: 15px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			animation: pulse 2s infinite;
		}
		@keyframes pulse {
			0% { transform: scale(1); }
			50% { transform: scale(1.05); }
			100% { transform: scale(1); }
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
			color: #ff6b35;
			margin: 25px 0 15px 0;
			padding-bottom: 8px;
			border-bottom: 2px solid #ff6b35;
		}
		.details { 
			background: #fff9f5; 
			border-left: 4px solid #ff6b35;
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
		.payment-info {
			background: #fff3cd;
			border: 2px solid #ffc107;
			border-radius: 6px;
			padding: 20px;
			margin: 25px 0;
		}
		.payment-amount {
			font-size: 24px;
			font-weight: 700;
			color: #856404;
			text-align: center;
			margin-bottom: 10px;
		}
		.action-section {
			background: #e8f5e8;
			border: 2px solid #28a745;
			border-radius: 6px;
			padding: 20px;
			margin: 25px 0;
			text-align: center;
		}
		.action-section p {
			margin: 0 0 15px 0;
			font-size: 16px;
			font-weight: 600;
			color: #155724;
		}
		.btn {
			display: inline-block;
			background: #28a745;
			color: #ffffff;
			padding: 14px 32px;
			text-decoration: none;
			border-radius: 6px;
			font-weight: 600;
			font-size: 15px;
			margin: 5px 10px;
			transition: background 0.3s ease;
		}
		.btn:hover {
			background: #218838;
		}
		.btn-reject {
			background: #dc3545;
		}
		.btn-reject:hover {
			background: #c82333;
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
			.btn {
				display: block;
				margin: 10px 0;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>🔔 Pago Pendiente de Confirmación</h1>
			<p>Sistema de Gestión - H Barber Shop</p>
			<div class="alert-badge">Requiere Acción</div>
		</div>

		<div class="content">
			<p class="intro-text">
				<strong>¡Atención Administrador!</strong><br>
				Se ha registrado un nuevo turno con pago por anticipo que requiere tu confirmación.
			</p>

			<h2 class="section-title">📋 Detalles del Turno</h2>
			<div class="details">
				<div class="detail-row">
					<span class="detail-label">Cliente:</span>
					<span class="detail-value">{{ $turno->tur_nombre }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Cédula:</span>
					<span class="detail-value">{{ $turno->tur_cedula }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Teléfono:</span>
					<span class="detail-value">{{ $turno->tur_celular }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Email:</span>
					<span class="detail-value">{{ $turno->tur_correo ?: 'No proporcionado' }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Fecha:</span>
					<span class="detail-value">{{ \Carbon\Carbon::parse($turno->tur_fecha)->format('d/m/Y') }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Hora:</span>
					<span class="detail-value">{{ \Carbon\Carbon::parse($turno->tur_hora)->format('H:i') }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Servicio:</span>
					<span class="detail-value">{{ $servicio->serv_nombre ?? 'No especificado' }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Duración:</span>
					<span class="detail-value">{{ $turno->tur_duracion }} minutos</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Barbero:</span>
					<span class="detail-value">{{ $barbero->persona->per_nombre ?? 'Cualquier barbero' }}</span>
				</div>
			</div>

			<h2 class="section-title">💰 Información de Pago</h2>
			<div class="payment-info">
				<div class="payment-amount">Anticipo: ${{ number_format($turno->tur_anticipo, 0, ',', '.') }}</div>
				<div class="detail-row">
					<span class="detail-label">Referencia de Transacción:</span>
					<span class="detail-value"><strong>{{ $turno->tur_referencia_pago }}</strong></span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Estado:</span>
					<span class="detail-value" style="color: #856404; font-weight: 600;">Pendiente de Confirmación</span>
				</div>
			</div>

			<div class="action-section">
				<p>🎯 Accede al panel de administración para confirmar o rechazar el pago</p>
				<a href="{{ url('/admin/turnos') }}" class="btn">✅ Ir a Panel Admin</a>
			</div>

			<h2 class="section-title">⏰ Próximos Pasos</h2>
			<p>1. <strong>Verificar el pago</strong> con la referencia proporcionada</p>
			<p>2. <strong>Confirmar o rechazar</strong> desde el panel de administración</p>
			<p>3. <strong>Email automático</strong> se enviará al cliente una vez confirmes</p>
		</div>

		<div class="footer">
			<p><strong>H Barber Shop</strong> - Sistema de Gestión</p>
			<p>Este email fue generado automáticamente. No responder.</p>
		</div>
	</div>
</body>
</html>