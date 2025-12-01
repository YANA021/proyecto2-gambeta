<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte - Gambeta</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #0c8a5f; }
        .section-title { font-size: 16px; font-weight: bold; margin-top: 30px; margin-bottom: 10px; border-bottom: 2px solid #0c8a5f; padding-bottom: 5px; }
        .kpi-container { display: table; width: 100%; margin-bottom: 20px; }
        .kpi-box { display: table-cell; width: 33%; text-align: center; padding: 10px; background: #f9f9f9; border: 1px solid #eee; }
        .kpi-value { font-size: 20px; font-weight: bold; color: #0c8a5f; }
        .kpi-label { font-size: 12px; color: #666; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        .table th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">GAMBETA</div>
        <p>Reporte {{ ucfirst($type) }} - {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @if($type === 'general')
        <div class="kpi-container">
            <div class="kpi-box">
                <div class="kpi-value">${{ number_format($ingresosHoy, 2) }}</div>
                <div class="kpi-label">Ingresos Hoy</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-value">${{ number_format($ingresosMes, 2) }}</div>
                <div class="kpi-label">Ingresos Mes</div>
            </div>
            <div class="kpi-box">
                <div class="kpi-value">{{ $reservasMes }}</div>
                <div class="kpi-label">Reservas Mes</div>
            </div>
        </div>
    @endif

    @if($type === 'general' || $type === 'ingresos')
        <div class="section-title">Ingresos Mensuales (Últimos 6 meses)</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Total Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingresosPorMes as $ingreso)
                    <tr>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $ingreso->mes)->format('F Y') }}</td>
                        <td>${{ number_format($ingreso->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($type === 'general' || $type === 'canchas')
        <div class="section-title">Canchas Más Populares</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cancha</th>
                    <th>Total Reservas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($canchasPopulares as $cancha)
                    <tr>
                        <td>{{ $cancha->cancha->nombre ?? 'Desconocida' }}</td>
                        <td>{{ $cancha->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
