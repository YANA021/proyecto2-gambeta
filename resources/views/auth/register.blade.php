<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Gambeta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            padding: 0.8rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: none;
        }

        .form-control::placeholder {
            color: rgba(232, 237, 245, 0.5);
        }

        .btn-primary {
            background: var(--accent);
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            color: #0f1e3c;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #2bc17e;
            color: #0f1e3c;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            color: var(--accent);
        }
        
        .link-text {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .link-text:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-text">GAMBETA</div>
        <h5 class="text-center mb-4">Crear Cuenta</h5>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="nombre_usuario" class="form-control" placeholder="Elija un usuario" value="{{ old('nombre_usuario') }}" required autofocus>
                @error('nombre_usuario')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control" placeholder="Mínimo 8 caracteres" required>
                @error('contrasena')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Confirmar Contraseña</label>
                <input type="password" name="contrasena_confirmation" class="form-control" placeholder="Repita la contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrarse</button>
            
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="link-text">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </form>
    </div>
</body>
</html>
