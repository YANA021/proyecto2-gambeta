<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Empleado - Gambeta</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Manrope', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .glass { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 16px; }
        .action-card { transition: all 0.3s ease; cursor: pointer; padding: 1.5rem; text-align: center; }
        .action-card:hover { transform: translateY(-5px); background: rgba(255, 255, 255, 0.2); }
        .action-card .icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .quick-stat { background: rgba(255, 255, 255, 0.95); border-radius: 12px; padding: 1.5rem; }
        .stat-value { font-size: 2rem; font-weight: 800; color: #667eea; }
        .stat-label { font-size: 0.875rem; color: #666; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body class="py-4">
    @php
        $user = auth()->user();
        $userName = $user->nombre_usuario ?? 'Empleado';
    @endphp
    
    <div class="container-xxl">
        <!-- Header -->
        <div class="glass p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-white">
                    <h1 class="mb-1 fw-bold">¡Hola, {{ $userName }}! 👋</h1>
                    <p class="mb-0 opacity-75">Panel de Recepción - Gambeta</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ url('/') }}" class="btn btn-light">🏠 Inicio</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger">🚪 Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <a href="{{ route('reservas.create') }}" class="text-decoration-none">
                    <div class="glass action-card text-white">
                        <div class="icon">⚡</div>
                        <div class="fw-bold">Nueva Reserva</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('reservas.calendar') }}" class="text-decoration-none">
                    <div class="glass action-card text-white">
                        <div class="icon">📅</div>
                        <div class="fw-bold">Calendario</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('pagos.create') }}" class="text-decoration-none">
                    <div class="glass action-card text-white">
                        <div class="icon">💰</div>
                        <div class="fw-bold">Registrar Pago</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('clientes.create') }}" class="text-decoration-none">
                    <div class="glass action-card text-white">
                        <div class="icon">👥</div>
                        <div class="fw-bold">Nuevo Cliente</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Stats Today -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="quick-stat">
                    <div class="stat-value">{{ $stats['reservas_hoy'] }}</div>
                    <div class="stat-label">Reservas Hoy</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="quick-stat">
                    <div class="stat-value">{{ $stats['reservas_pendientes'] }}</div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="quick-stat">
                    <div class="stat-value">${{ number_format($stats['ingresos_hoy'], 2) }}</div>
                    <div class="stat-label">Ingresos Hoy</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="quick-stat">
                    <div class="stat-value">{{ $stats['clientes_total'] }}</div>
                    <div class="stat-label">Clientes</div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-3">
            <!-- Reservas de Hoy -->
            <div class="col-lg-8">
                <div class="quick-stat">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">📋 Reservas de Hoy</h5>
                        <a href="{{ route('reservas.index') }}" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Cancha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservasHoy as $reserva)
                                    <tr>
                                        <td class="fw-bold">{{ $reserva->hora_inicio }}</td>
                                        <td>{{ $reserva->cliente->nombre ?? 'N/D' }}</td>
                                        <td>{{ $reserva->cancha->nombre ?? 'N/D' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $reserva->estado->nombre === 'Confirmada' ? 'success' : ($reserva->estado->nombre === 'Pendiente' ? 'warning' : 'secondary') }}">
                                                {{ $reserva->estado->nombre }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('reservas.show', $reserva) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay reservas para hoy</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4">
                <div class="quick-stat mb-3">
                    <h5 class="mb-3 fw-bold">🔗 Acceso Rápido</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('reservas.index') }}" class="btn btn-outline-primary">Ver Todas las Reservas</a>
                        <a href="{{ route('pagos.index') }}" class="btn btn-outline-success">Ver Pagos</a>
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-info">Ver Clientes</a>
                        <a href="{{ route('bloqueos.index') }}" class="btn btn-outline-danger">🚫 Bloqueos</a>
                        <a href="{{ route('historial.clientesFrecuentes') }}" class="btn btn-outline-warning">🏆 TOP Clientes</a>
                    </div>
                </div>

                <div class="quick-stat">
                    <h5 class="mb-3 fw-bold">ℹ️ Información</h5>
                    <p class="small mb-2"><strong>Rol:</strong> Empleado de Recepción</p>
                    <p class="small mb-2"><strong>Usuario:</strong> {{ $userName }}</p>
                    <p class="small mb-0 text-muted">Panel limitado a operaciones de recepción</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
