<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Pago</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #0c8a5f; }
        .info { margin-bottom: 20px; }
        .info p { margin: 5px 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .table th { background-color: #f9f9f9; }
        .total { text-align: right; margin-top: 20px; font-size: 18px; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">GAMBETA</div>
        <p>Comprobante de Pago</p>
    </div>

    <div class="info">
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</p>
        <p><strong>Comprobante #:</strong> {{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Cliente:</strong> {{ $pago->cliente->nombre }}</p>
        <p><strong>Método de Pago:</strong> {{ ucfirst($pago->metodo) }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Pago de Reserva #{{ $pago->reserva_id }}<br>
                    <small>
                        Cancha: {{ $pago->reserva->cancha->nombre ?? 'N/D' }}<br>
                        Fecha Reserva: {{ \Carbon\Carbon::parse($pago->reserva->fecha)->format('d/m/Y') }} {{ $pago->reserva->hora_inicio }}
                    </small>
                </td>
                <td>${{ number_format($pago->monto, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        Total Pagado: ${{ number_format($pago->monto, 2) }}
    </div>

    <div class="footer">
        <p>Gracias por su preferencia.</p>
        <p>Gambeta Sports Center</p>
    </div>
</body>
</html>
