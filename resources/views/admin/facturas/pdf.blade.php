<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $factura->fac_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            padding: 20px;
            background: #fff;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #7d1935;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #7d1935 0%, #a82647 100%);
            color: #fff;
            padding: 25px;
            text-align: center;
            border-bottom: 4px solid #5d1325;
        }

        .company-logo {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 8px;
            text-transform: uppercase;
            color: #111;
        }

        .company-info {
            font-size: 10px;
            opacity: 0.95;
            margin-top: 5px;
            color: #111;
        }

        /* Invoice Details Section */
        .invoice-header {
            display: table;
            width: 100%;
            padding: 20px 25px;
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .invoice-header-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .invoice-header-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #7d1935;
            margin-bottom: 10px;
        }

        .info-line {
            padding: 4px 0;
            border-bottom: 1px dotted #cbd5e0;
        }

        .info-line:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .info-value {
            display: inline-block;
        }

        /* Services Table */
        .services-section {
            padding: 20px 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #7d1935;
            text-transform: uppercase;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #7d1935;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background: #2d3748;
            color: #fff;
        }

        th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th.text-right, td.text-right {
            text-align: right;
        }

        th.text-center, td.text-center {
            text-align: center;
        }

        tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr:last-child {
            border-bottom: 2px solid #cbd5e0;
        }

        td {
            padding: 12px 8px;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background: #f7fafc;
        }

        /* Summary Section */
        .summary-section {
            padding: 20px 25px;
            background: #f8f9fa;
            border-top: 2px solid #dee2e6;
        }

        .summary-table {
            width: 100%;
            max-width: 400px;
            margin-left: auto;
        }

        .summary-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px dotted #cbd5e0;
        }

        .summary-row.total {
            border-top: 2px solid #7d1935;
            border-bottom: 2px solid #7d1935;
            margin-top: 10px;
            padding: 12px 0;
            font-size: 14px;
            font-weight: bold;
            background: #fff;
        }

        .summary-row.payment {
            background: #e6f7ff;
            padding: 10px 8px;
            margin: 5px 0;
            border-radius: 4px;
            border: 1px solid #91d5ff;
        }

        .summary-label {
            display: table-cell;
            text-align: left;
            font-weight: bold;
            width: 60%;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            width: 40%;
        }

        .total .summary-label,
        .total .summary-value {
            color: #7d1935;
        }

        /* Footer Section */
        .footer {
            padding: 20px 25px;
            background: #2d3748;
            color: #cbd5e0;
            text-align: center;
            border-top: 4px solid #1a202c;
        }

        .footer-title {
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .footer-text {
            font-size: 9px;
            line-height: 1.6;
            margin: 5px 0;
        }

        .dotted-line {
            border-top: 2px dotted #cbd5e0;
            margin: 15px 0;
        }

        /* Barcode Section */
        .barcode-section {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-top: 2px dashed #cbd5e0;
        }

        .barcode-placeholder {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            letter-spacing: 2px;
            color: #718096;
            margin-top: 8px;
        }

        /* Print Styles */
        @media print {
            body {
                padding: 0;
            }
            
            .invoice-container {
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div style="width:100%; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <img src="{{ public_path('img/1.png') }}" alt="Logo" style="height:55px; margin-bottom:6px; display:block;">
            </div>
            <div class="company-logo">H BARBER SHOP</div>
            <div class="company-info">
                Tu barbería de confianza<br>
                Tel: {{ $factura->sede->sede_telefono ?? '(000) 000-0000' }}<br>
                {{ $factura->sede->sede_direccion ?? 'Dirección no disponible' }}
            </div>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="invoice-header-left">
                <div class="info-line">
                    <span class="info-label">Cliente:</span>
                    <span class="info-value">{{ $factura->turno->tur_nombre ?? '' }}</span>
                </div>
                <div class="info-line">
                    <span class="info-label">Cédula:</span>
                    <span class="info-value">{{ $factura->turno->tur_cedula ?? '' }}</span>
                </div>
                <div class="info-line">
                    <span class="info-label">Barbero:</span>
                    <span class="info-value">{{ $factura->turno->disponibilidad->persona->per_nombre ?? '' }} {{ $factura->turno->disponibilidad->persona->per_apellido ?? '' }}</span>
                </div>
            </div>
            <div class="invoice-header-right">
                <div class="invoice-number">Factura #{{ $factura->fac_id }}</div>
                <div class="info-line">
                    <span class="info-label">Fecha:</span>
                    <span class="info-value">{{ $factura->fac_fecha }}</span>
                </div>
                <div class="info-line">
                    <span class="info-label">Sede:</span>
                    <span class="info-value">{{ $factura->sede->sede_nombre ?? 'No especificada' }}</span>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="services-section">
            <div class="section-title">Servicios Facturados</div>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 50%;">Servicio</th>
                        <th class="text-right" style="width: 20%;">Valor original</th>
                        <th class="text-center" style="width: 15%;">Descuento (%)</th>
                        <th class="text-right" style="width: 15%;">Valor final</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->servicios->serv_nombre ?? '' }}</td>
                        <td class="text-right">${{ number_format($detalle->servicios->serv_precio ?? $detalle->serv_precio,2) }}</td>
                        <td class="text-center">{{ $detalle->servicios->serv_descuento ?? 0 }}%</td>
                        <td class="text-right">${{ number_format($detalle->serv_precio,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="section-title">Resumen</div>
            @php
                $subtotal = 0;
                $totalDescuento = 0;
                $porcentajeTotal = 0;
                $serviciosConDescuento = 0;
                foreach($factura->detalles as $detalle) {
                    $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                    $descuento = $detalle->servicios->serv_descuento ?? 0;
                    $subtotal += $precioOriginal;
                    $totalDescuento += ($precioOriginal - $detalle->serv_precio);
                    if($descuento > 0) {
                        $porcentajeTotal += $descuento;
                        $serviciosConDescuento++;
                    }
                }
                $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
                $totalFinal = $subtotal - $totalDescuento;
            @endphp
            <div class="summary-table">
                <div class="summary-row">
                    <span class="summary-label">Subtotal:</span>
                    <span class="summary-value">${{ number_format($subtotal,2) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Descuento promedio aplicado:</span>
                    <span class="summary-value">{{ number_format($porcentajePromedio,2) }}%</span>
                </div>
                <div class="summary-row total">
                    <span class="summary-label">Valor final con descuento:</span>
                    <span class="summary-value">${{ number_format($totalFinal,2) }}</span>
                </div>
                <div class="dotted-line"></div>
                <div class="summary-row payment">
                    <span class="summary-label">Abono:</span>
                    <span class="summary-value">${{ number_format($factura->fac_abono,2) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Saldo:</span>
                    <span class="summary-value">${{ number_format($totalFinal - $factura->fac_abono,2) }}</span>
                </div>
            </div>
        </div>

        <!-- Barcode Section -->
        <div class="barcode-section">
            <div class="footer-text">FACTURA ELECTRÓNICA</div>
            <div class="barcode-placeholder">
                |||| || |||| | || ||| |||| || | ||| || ||||<br>
                FAC-{{ str_pad($factura->fac_id, 8, '0', STR_PAD_LEFT) }}
            </div>
            <div class="footer-text" style="margin-top: 10px;">
                Fecha y hora de validación: {{ now()->format('Y-m-d H:i:s') }}
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-title">¡Gracias por tu preferencia!</div>
            <div class="footer-text">
                Este documento es una factura válida y puede ser utilizado como comprobante de pago.
            </div>
            <div class="footer-text">
                Para consultas o reclamos, contáctanos a través de nuestros canales oficiales.
            </div>
            <div class="footer-text" style="margin-top: 10px; opacity: 0.7;">
                © {{ date('Y') }} H Barber Shop - Todos los derechos reservados
            </div>
        </div>
    </div>
</body>
</html>
