<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nuevo Turno Registrado - H Barber Shop</title>
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
			background: linear-gradient(135deg, #7d2a3d 0%, #a83850 100%);
			color: #ffffff; 
			padding: 30px 20px; 
			text-align: center;
			border-bottom: 4px solid #5a1f2e;
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
			background: #ff6b6b;
			color: white;
			display: inline-block;
			padding: 6px 14px;
			border-radius: 20px;
			font-size: 13px;
			font-weight: 600;
			margin-top: 10px;
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
			color: #7d2a3d;
			margin: 25px 0 15px 0;
			padding-bottom: 8px;
			border-bottom: 2px solid #7d2a3d;
		}
		.details { 
			background: #f9f9f9; 
			border-left: 4px solid #7d2a3d;
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
		.action-section {
			background: #fff8e1;
			border: 2px solid #ffc107;
			border-radius: 6px;
			padding: 18px;
			margin: 25px 0;
			text-align: center;
		}
		.action-section p {
			margin: 0 0 12px 0;
			font-size: 15px;
			color: #333;
		}
		.btn {
			display: inline-block;
			background: #7d2a3d;
			color: #ffffff;
			padding: 14px 32px;
			text-decoration: none;
			border-radius: 6px;
			font-weight: 600;
			font-size: 15px;
			margin-top: 8px;
			transition: background 0.3s ease;
		}
		.btn:hover {
			background: #5a1f2e;
		}
		.footer { 
			background: #2c2c2c; 
			color: #cccccc; 
			text-align: center; 
			padding: 25px 20px; 
			font-size: 14px;
			line-height: 1.8;
		}
		.footer strong {
			color: #ffffff;
		}
		.footer p {
			margin: 8px 0;
		}
		.divider {
			height: 1px;
			background: #e0e0e0;
			margin: 25px 0;
		}
		@media (max-width: 600px) {
			.container { 
				margin: 10px; 
				border-radius: 0;
			}
			.content { 
				padding: 25px 18px;
			}
			.header h1 {
				font-size: 22px;
			}
			.detail-row {
				flex-direction: column;
			}
			.detail-label {
				margin-bottom: 4px;
			}
			.btn {
				padding: 12px 24px;
				font-size: 14px;
			}
		}
	</style>
</head>
<body>
	<div class="container" role="article" aria-label="Notificación de nuevo turno">
		<header class="header" role="banner">
			<h1>Nuevo Turno Registrado</h1>
			<p>H Barber Shop - Sistema de Gestión</p>
			<span class="alert-badge" role="status" aria-live="polite">Requiere Atención</span>
		</header>
		
		<main class="content" role="main">
			<p class="intro-text">
				<strong>Estimada Administradora:</strong><br>
				Se ha registrado un nuevo turno en el sistema que requiere su revisión y gestión.
			</p>

			<h2 class="section-title">Información del Cliente</h2>
			<div class="details" role="region" aria-label="Detalles del cliente">
				<div class="detail-row">
					<span class="detail-label">Nombre completo:</span>
					<span class="detail-value">{{ $turno->tur_nombre }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Correo electrónico:</span>
					<span class="detail-value">{{ $turno->tur_correo }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Teléfono de contacto:</span>
					<span class="detail-value">{{ $turno->tur_celular ?? 'No proporcionado' }}</span>
				</div>
			</div>

			<h2 class="section-title">Detalles del Turno</h2>
			<div class="details" role="region" aria-label="Detalles del turno programado">
				<div class="detail-row">
					<span class="detail-label">Fecha programada:</span>
					<span class="detail-value">{{ $turno->tur_fecha }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Hora programada:</span>
					<span class="detail-value">{{ $turno->tur_hora }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Barbero asignado:</span>
					<span class="detail-value">{{ $turno->barbero ? $turno->barbero->per_nombre : 'Pendiente de asignación' }}</span>
				</div>
				<div class="detail-row">
					<span class="detail-label">Estado del turno:</span>
					<span class="detail-value">Pendiente</span>
				</div>
			</div>

			<div class="divider" role="separator"></div>

			<div class="action-section" role="complementary" aria-label="Acciones requeridas">
				<p><strong>Acción Requerida:</strong> Por favor revise este turno en el panel de administración para confirmar o gestionar la cita.</p>
				<a href="{{ url('/admin/turnos') }}" class="btn" role="button" aria-label="Ir al panel de administración de turnos">
					Ir al Panel de Administración
				</a>
			</div>

			<p style="font-size: 14px; color: #666; margin-top: 25px;">
				<strong>Nota:</strong> Este es un correo automático generado por el sistema de gestión de turnos. 
				Si tiene alguna consulta, por favor acceda al panel de administración.
			</p>
		</main>
		
		<footer class="footer" role="contentinfo">
			<p><strong>H Barber Shop</strong></p>
			<p>Sistema de Gestión de Turnos y Citas</p>
			<p style="margin-top: 15px; font-size: 13px;">
				Este correo es confidencial y está destinado únicamente para uso administrativo.
			</p>
		</footer>
	</div>
</body>
</html>
