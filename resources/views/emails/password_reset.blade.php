<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f5f5f5;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f5f5f5;">
        <tr>
            <td style="padding: 40px 20px;">
                <!-- Contenedor principal -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header con branding -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #8b1538 0%, #6b1028 100%); padding: 40px 30px; text-align: center;">
                            <div style="width: 80px; height: 80px; background-color: rgba(255, 255, 255, 0.15); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; border: 3px solid rgba(255, 255, 255, 0.3);">
                                <svg width="40" height="40" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="fill: white;">
                                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.18-.92-6-4.42-6-8V8.3l6-3.27 6 3.27V12c0 3.58-2.82 7.08-6 8z"/>
                                    <path d="M10.5 13l-2.12-2.12-1.42 1.42L10.5 16l6-6-1.42-1.42z"/>
                                </svg>
                            </div>
                            <h1 style="margin: 0; color: white; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">Recuperar Contraseña</h1>
                        </td>
                    </tr>

                    <!-- Contenido principal -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #1a1a1a; font-size: 22px; font-weight: 600;">Hola,</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #333; font-size: 16px; line-height: 1.6;">
                                Recibimos una solicitud para restablecer la contraseña de su cuenta. Si no realizó esta solicitud, puede ignorar este correo de forma segura.
                            </p>

                            <p style="margin: 0 0 30px 0; color: #333; font-size: 16px; line-height: 1.6;">
                                Para restablecer su contraseña, haga clic en el botón a continuación:
                            </p>

                            <!-- Botón principal -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: center; padding: 0 0 30px 0;">
                                        <a href="{{ $url }}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #8b1538 0%, #6b1028 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(139, 21, 56, 0.3);">
                                            Restablecer Contraseña
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Información de seguridad -->
                            <div style="background-color: #f8f9fa; border-left: 4px solid #8b1538; padding: 20px; margin: 0 0 30px 0; border-radius: 4px;">
                                <p style="margin: 0 0 10px 0; color: #333; font-size: 14px; font-weight: 600;">
                                    ⏱️ Este enlace expirará en 60 minutos
                                </p>
                                <p style="margin: 0; color: #666; font-size: 14px; line-height: 1.5;">
                                    Por seguridad, este enlace solo puede usarse una vez y caduca después de una hora.
                                </p>
                            </div>

                            <!-- Link alternativo -->
                            <p style="margin: 0 0 10px 0; color: #666; font-size: 14px; line-height: 1.6;">
                                Si el botón no funciona, copie y pegue el siguiente enlace en su navegador:
                            </p>
                            <p style="margin: 0 0 30px 0; padding: 12px; background-color: #f5f5f5; border-radius: 6px; word-break: break-all; font-size: 13px; color: #555; font-family: monospace;">
                                {{ $url }}
                            </p>

                            <!-- Consejos de seguridad -->
                            <div style="border-top: 2px solid #e0e0e0; padding-top: 30px;">
                                <h3 style="margin: 0 0 15px 0; color: #1a1a1a; font-size: 18px; font-weight: 600;">
                                    💡 Consejos de seguridad
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #666; font-size: 14px; line-height: 1.8;">
                                    <li style="margin-bottom: 8px;">Use una contraseña única y segura de al menos 8 caracteres</li>
                                    <li style="margin-bottom: 8px;">Combine letras mayúsculas, minúsculas, números y símbolos</li>
                                    <li style="margin-bottom: 8px;">No comparta su contraseña con nadie</li>
                                    <li>Nunca responda a correos que soliciten su contraseña</li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Advertencia de seguridad -->
                    <tr>
                        <td style="background-color: #fff8f0; padding: 20px 30px; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0; color: #8b6914; font-size: 14px; line-height: 1.6;">
                                <strong>⚠️ ¿No solicitó este cambio?</strong><br>
                                Si no reconoce esta actividad, su cuenta podría estar en riesgo. Contáctenos inmediatamente en <a href="mailto:soporte@hbarbershop.com" style="color: #8b1538; text-decoration: none; font-weight: 600;">soporte@hbarbershop.com</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1a1a1a; padding: 30px; text-align: center;">
                            <p style="margin: 0 0 10px 0; color: #999; font-size: 14px;">
                                © 2025 H Barber Shop. Todos los derechos reservados.
                            </p>
                            <p style="margin: 0 0 15px 0; color: #999; font-size: 12px;">
                                Este es un correo automático, por favor no responda a este mensaje.
                            </p>
                            <div style="margin: 20px 0 0 0;">
                                <a href="#" style="color: #8b1538; text-decoration: none; font-size: 13px; margin: 0 10px;">Política de Privacidad</a>
                                <span style="color: #555;">•</span>
                                <a href="#" style="color: #8b1538; text-decoration: none; font-size: 13px; margin: 0 10px;">Términos de Servicio</a>
                                <span style="color: #555;">•</span>
                                <a href="#" style="color: #8b1538; text-decoration: none; font-size: 13px; margin: 0 10px;">Centro de Ayuda</a>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>