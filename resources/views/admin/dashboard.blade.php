<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | Gambeta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-start: #0f1e3c;
            --bg-end: #0c8a5f;
            --card: rgba(255, 255, 255, 0.07);
            --stroke: rgba(255, 255, 255, 0.16);
            --text-primary: #e8edf5;
            --text-muted: #aab8d6;
            --accent: #30d18a;
            --accent-2: #52a9ff;
            --danger: #f55d5d;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }
        * { font-family: 'Manrope', 'Segoe UI', sans-serif; }
        body {
            background: radial-gradient(circle at 10% 20%, rgba(102, 255, 204, 0.18), transparent 25%),
                        radial-gradient(circle at 80% 0%, rgba(82, 169, 255, 0.18), transparent 25%),
                        linear-gradient(135deg, var(--bg-start), var(--bg-end));
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
        }
        .backdrop {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 15% 80%, rgba(255, 255, 255, 0.06), transparent 40%),
                radial-gradient(circle at 70% 40%, rgba(255, 255, 255, 0.04), transparent 35%);
        }
        .card-shell {
            background: var(--card);
            border: 1px solid var(--stroke);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }
        .glass-hero {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
            border: 1px solid var(--stroke);
            border-radius: 24px;
            padding: 22px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .glass-hero:after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(48, 209, 138, 0.18), transparent 55%);
            top: -40px;
            right: -60px;
        }
        .muted { color: var(--text-muted); }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid var(--stroke);
            background: rgba(255, 255, 255, 0.06);
            font-size: 0.9rem;
            color: var(--text-primary);
        }
        .chip .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent);
            display: inline-block;
        }
        .btn-ghost {
            border: 1px solid var(--stroke);
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 9px 16px;
        }
        .btn-ghost:hover { background: rgba(255, 255, 255, 0.12); color: #fff; }
        .btn-solid {
            background: linear-gradient(135deg, #20d1a2, #35c27c);
            color: #0a1a2a;
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 700;
        }
        .btn-solid:hover { opacity: 0.92; color: #05101c; }
        .stat-card {
            padding: 18px;
            border-radius: 16px;
            border: 1px solid var(--stroke);
            background: rgba(255, 255, 255, 0.06);
            transition: transform .2s ease, box-shadow .2s ease;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
        .icon-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--stroke);
            font-size: 1.15rem;
        }
        .section-card {
            padding: 18px;
            border-radius: 18px;
            border: 1px solid var(--stroke);
            background: rgba(10, 23, 41, 0.75);
            box-shadow: var(--shadow);
            height: 100%;
        }
        .table thead { color: var(--text-muted); }
        .table>:not(caption)>*>* {
            background-color: transparent;
            border-color: rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
        }
        .pill {
            border-radius: 10px;
            padding: 5px 10px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(48, 209, 138, 0.12);
            color: #5df1b3;
            border: 1px solid rgba(48, 209, 138, 0.35);
        }
        .pill.warning {
            background: rgba(255, 192, 67, 0.12);
            border-color: rgba(255, 192, 67, 0.4);
            color: #ffde83;
        }
        .pill.danger {
            background: rgba(245, 93, 93, 0.12);
            border-color: rgba(245, 93, 93, 0.4);
            color: #ff9b9b;
        }
        .list-clean { list-style: none; padding-left: 0; margin: 0; }
        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #20d1a2, #3cd1ef);
            display: grid;
            place-items: center;
            color: #0c1b2a;
            font-weight: 800;
            letter-spacing: .03em;
            border: 2px solid rgba(255, 255, 255, 0.55);
        }
        .quick-item {
            border: 1px solid var(--stroke);
            background: rgba(255, 255, 255, 0.04);
            border-radius: 12px;
            padding: 10px 12px;
            transition: transform .15s ease, background .15s ease;
        }
        .quick-item:hover { transform: translateY(-2px); background: rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="py-4">
<div class="backdrop"></div>
@php
    $user = auth()->user();
    $userName = $user->name ?? $user->email ?? 'Administrador';
    $initial = strtoupper(substr($userName, 0, 1));
@endphp
<div class="container-xxl position-relative">
    <div class="glass-hero mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 position-relative">
            <div>
                <div class="chip mb-2">
                    <span class="dot"></span>
                    Panel de administración activo
                </div>
                <h1 class="fw-bold mb-1">Gambeta Operations</h1>
                <p class="muted mb-0">Gestiona canchas, clientes y cobros desde una sola vista.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('canchas.create') }}" class="btn-ghost d-flex align-items-center gap-2">
                    <span>🏟️</span> Nueva cancha
                </a>
                <a href="{{ route('clientes.create') }}" class="btn-ghost d-flex align-items-center gap-2">
                    <span>👥</span> Nuevo cliente
                </a>
                <a href="{{ route('reservas.create') }}" class="btn-solid d-flex align-items-center gap-2">
                    <span>⚡</span> Crear reserva
                </a>
            </div>
        </div>
        <div class="row g-3 mt-3">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="muted">Canchas activas</span>
                        <span class="icon-badge">🏟️</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['canchas'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="muted">Clientes</span>
                        <span class="icon-badge">🧑‍🤝‍🧑</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['clientes'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="muted">Reservas</span>
                        <span class="icon-badge">📅</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['reservas'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="muted">Pagos</span>
                        <span class="icon-badge">💳</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['pagos'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="section-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-uppercase mb-1" style="letter-spacing:.14em;">Reservas</p>
                        <h5 class="mb-0">Últimas reservas creadas</h5>
                        <small class="muted">Revisa la disponibilidad y estados recientes.</small>
                    </div>
                    <a class="btn-ghost" href="{{ route('reservas.index') }}">Ver todas</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
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
                                <td>
                                    <span class="pill {{ ($reserva->estado->nombre ?? '') === 'cancelada' ? 'danger' : (($reserva->estado->nombre ?? '') === 'pendiente' ? 'warning' : '') }}">
                                        {{ $reserva->estado->nombre ?? 'pendiente' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="muted">Sin reservas todavía.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="text-uppercase mb-1" style="letter-spacing:.14em;">Pagos</p>
                        <h5 class="mb-0">Pagos recientes</h5>
                        <small class="muted">Últimos movimientos registrados en el sistema.</small>
                    </div>
                    <a class="btn-ghost" href="{{ route('pagos.index') }}">Ver pagos</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($recentPagos as $pago)
                        <div class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="icon-badge">💰</span>
                                <div>
                                    <div class="fw-semibold">{{ $pago->cliente->nombre ?? 'Cliente' }}</div>
                                    <small class="muted">{{ $pago->metodo ?? 'Método no especificado' }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">${{ number_format($pago->monto ?? 0, 2) }}</div>
                                <div class="pill {{ ($pago->estado_pago ?? '') === 'fallido' ? 'danger' : (($pago->estado_pago ?? '') === 'pendiente' ? 'warning' : '') }}">
                                    {{ $pago->estado_pago ?? 'pendiente' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="muted">Sin pagos registrados.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="section-card mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="avatar">{{ $initial }}</div>
                    <div>
                        <p class="text-uppercase mb-1" style="letter-spacing:.14em;">Mi perfil</p>
                        <h6 class="mb-0">{{ $userName }}</h6>
                        <small class="muted">{{ $user->email ?? 'Administrador' }}</small>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a class="btn-ghost w-100 text-start" href="{{ route('clientes.index') }}">📇 Lista de clientes</a>
                    <a class="btn-ghost w-100 text-start" href="{{ route('canchas.index') }}">🏟️ Gestión de canchas</a>
                    <a class="btn-ghost w-100 text-start" href="{{ route('grupos.index') }}">👥 Grupos y equipos</a>
                    <a class="btn-ghost w-100 text-start" href="{{ route('estados_reserva.index') }}">📌 Estados de reserva</a>
                </div>
            </div>

            <div class="section-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Tipos de cancha</h6>
                    <a class="btn-ghost btn-sm py-1" href="{{ route('tipo_canchas.index') }}">Ver</a>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($tipos as $tipo)
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-badge">🧭</span>
                                <span>{{ $tipo->nombre }}</span>
                            </div>
                            <span class="pill">{{ $tipo->precio_hora ?? '—' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent muted">Sin tipos registrados.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
