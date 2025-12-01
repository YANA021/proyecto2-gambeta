<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gambeta | Reserva tu cancha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-start: #0f1e3c;
            --bg-end: #0c8a5f;
            --accent: #30d18a;
            --text-primary: #e8edf5;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 4rem 2rem;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .brand-title {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-subtitle {
            font-size: 1.5rem;
            color: rgba(232, 237, 245, 0.8);
            margin-bottom: 3rem;
            font-weight: 500;
        }

        .btn-custom {
            padding: 1rem 2.5rem;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        .btn-primary-custom {
            background: var(--accent);
            color: #0f1e3c;
            border: none;
            box-shadow: 0 10px 20px rgba(48, 209, 138, 0.2);
        }

        .btn-primary-custom:hover {
            background: #2bc17e;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(48, 209, 138, 0.3);
            color: #0f1e3c;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
            transform: translateY(-3px);
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
        }

        .shape-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(48, 209, 138, 0.2);
        }

        .shape-2 {
            bottom: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(15, 30, 60, 0.5);
        }
    </style>
</head>
<body>
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>

    <div class="hero-section">
        <div class="glass-card">
            <h1 class="brand-title">GAMBETA</h1>
            <p class="brand-subtitle">La mejor forma de reservar tu cancha y jugar tu pasión.</p>

            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center align-items-center">
                @auth
                    @php
                        $dashboardRoute = 'cliente.dashboard';
                        if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Empleado')) {
                            $dashboardRoute = 'admin.dashboard';
                        }
                    @endphp
                    
                    <a href="{{ route($dashboardRoute) }}" class="btn btn-custom btn-primary-custom text-decoration-none">
                        Ir al Panel
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-custom btn-outline-custom">
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-custom btn-primary-custom text-decoration-none">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-custom btn-outline-custom text-decoration-none">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
