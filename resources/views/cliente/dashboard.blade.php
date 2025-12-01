<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel | Gambeta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-start: #0f1e3c;
            --bg-end: #0c8a5f;
            --card: rgba(255, 255, 255, 0.07);
            --stroke: rgba(255, 255, 255, 0.16);
            --text-primary: #e8edf5;
            --text-muted: #aab8d6;
            --accent: #30d18a;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }
        body {
            font-family: 'Manrope', sans-serif;
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
            min-height: 100vh;
            color: var(--text-primary);
        }
        .glass-card {
            background: var(--card);
            border: 1px solid var(--stroke);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 2rem;
        }
        .btn-accent {
            background: var(--accent);
            color: #0f1e3c;
            font-weight: 600;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .btn-accent:hover {
            transform: translateY(-2px);
            background: #2bc17e;
            color: #0f1e3c;
        }
        .btn-ghost {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: 1px solid var(--stroke);
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
        }
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold">GAMBETA</h2>
            <div class="d-flex gap-2">
                <a href="{{ url('/') }}" class="btn btn-ghost btn-sm">🏠 Inicio</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">🚪 Cerrar Sesión</button>
                </form>
            </div>
        </div>

        <div class="glass-card mb-4">
            <h1 class="mb-3">Hola, {{ auth()->user()->nombre_usuario }} 👋</h1>
            <p class="text-muted fs-5">Bienvenido a tu panel de cliente. ¿Qué te gustaría hacer hoy?</p>
            
            <div class="d-flex gap-3 mt-4">
                <a href="#" class="btn-accent">⚽ Reservar Cancha</a>
                <a href="#" class="btn-ghost">📅 Mis Reservas</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="glass-card h-100">
                    <h4 class="mb-3">Mis Próximos Partidos</h4>
                    <p class="text-muted">No tienes reservas próximas.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass-card h-100">
                    <h4 class="mb-3">Historial</h4>
                    <p class="text-muted">Aún no has jugado partidos.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
