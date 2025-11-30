<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | Gambeta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0f172a;
            color: #e2e8f0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .glass {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.35);
        }
        .accent {
            color: #7dd3fc;
        }
        .stat-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 50px rgba(0,0,0,0.4);
        }
        .pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            font-size: 0.8rem;
            color: #cbd5e1;
        }
        .table thead {
            color: #cbd5e1;
        }
        .table>:not(caption)>*>* {
            background-color: transparent;
            border-color: rgba(255,255,255,0.08);
        }
        a.btn-link {
            color: #7dd3fc;
        }
    </style>
</head>
<body class="py-4">
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-uppercase text-secondary mb-1" style="letter-spacing: .12em;">Panel administrador</p>
            <h1 class="fw-bold mb-0">Gambeta Dashboard</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('canchas.create') }}" class="btn btn-sm btn-outline-info">Nueva cancha</a>
            <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-outline-info">Nuevo cliente</a>
            <a href="{{ route('reservas.create') }}" class="btn btn-sm btn-info text-dark fw-semibold">Crear reserva</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="glass p-3 stat-card">
                <p class="text-secondary mb-1">Canchas</p>
                <h3 class="fw-bold">{{ $stats['canchas'] ?? 0 }}</h3>
                <span class="pill">Inventario</span>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="glass p-3 stat-card">
                <p class="text-secondary mb-1">Clientes</p>
                <h3 class="fw-bold">{{ $stats['clientes'] ?? 0 }}</h3>
                <span class="pill">Contactos</span>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="glass p-3 stat-card">
                <p class="text-secondary mb-1">Reservas</p>
                <h3 class="fw-bold">{{ $stats['reservas'] ?? 0 }}</h3>
                <span class="pill">Calendario</span>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="glass p-3 stat-card">
                <p class="text-secondary mb-1">Pagos</p>
                <h3 class="fw-bold">{{ $stats['pagos'] ?? 0 }}</h3>
                <span class="pill">Cobros</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h5 class="mb-0">Reservas recientes</h5>
                        <small class="text-secondary">Últimas 5 reservas creadas</small>
                    </div>
                    <a class="btn btn-sm btn-outline-info" href="{{ route('reservas.index') }}">Ver todas</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle text-white mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Cancha</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentReservas as $reserva)
                            <tr>
                                <td>{{ $reserva->id }}</td>
                                <td>{{ $reserva->cancha->nombre ?? 'N/D' }}</td>
                                <td>{{ $reserva->cliente->nombre ?? 'N/D' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }} {{ $reserva->hora_inicio }}</td>
                                <td><span class="pill text-capitalize">{{ $reserva->estado->nombre ?? 'pendiente' }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-secondary">Sin reservas todavía.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h5 class="mb-0">Pagos recientes</h5>
                        <small class="text-secondary">Últimos 5 pagos registrados</small>
                    </div>
                    <a class="btn btn-sm btn-outline-info" href="{{ route('pagos.index') }}">Ver pagos</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle text-white mb-0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Método</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentPagos as $pago)
                            <tr>
                                <td>{{ $pago->id }}</td>
                                <td>{{ $pago->cliente->nombre ?? 'N/D' }}</td>
                                <td>{{ $pago->metodo ?? '—' }}</td>
                                <td>${{ number_format($pago->monto ?? 0, 2) }}</td>
                                <td><span class="pill text-capitalize">{{ $pago->estado_pago ?? 'pendiente' }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-secondary">Sin pagos registrados.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Tipos de cancha</h5>
                    <a class="btn btn-sm btn-outline-info" href="{{ route('tipo_canchas.index') }}">Ver</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($tipos as $tipo)
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <span>{{ $tipo->nombre }}</span>
                            <span class="badge bg-info text-dark">{{ $tipo->precio_hora ?? '—' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent text-secondary">Sin tipos registrados.</li>
                    @endforelse
                </ul>
            </div>

            <div class="glass p-3">
                <h5 class="mb-2">Accesos rápidos</h5>
                <div class="d-grid gap-2">
                    <a class="btn btn-outline-light" href="{{ route('canchas.index') }}">Gestionar canchas</a>
                    <a class="btn btn-outline-light" href="{{ route('clientes.index') }}">Gestionar clientes</a>
                    <a class="btn btn-outline-light" href="{{ route('grupos.index') }}">Gestionar grupos</a>
                    <a class="btn btn-outline-light" href="{{ route('estados_reserva.index') }}">Estados de reserva</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
