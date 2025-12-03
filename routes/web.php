<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TipoCanchaController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ComprobanteController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

// rutas protegidas
Route::middleware(['auth'])->group(function () {
    
    Route::get('/admin', function () {
        $stats = [
            'canchas' => \App\Models\Cancha::count(),
            'clientes' => \App\Models\Cliente::count(),
            'reservas' => \App\Models\Reserva::count(),
            'pagos' => \App\Models\Pago::count(),
        ];

        $recentReservas = \App\Models\Reserva::with(['cancha', 'cliente', 'estado'])
            ->latest()
            ->take(5)
            ->get();

        $recentPagos = \App\Models\Pago::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        $tipos = \App\Models\TipoCancha::all();
        $recentUsuarios = \App\Models\Usuario::with('rol')
            ->latest()
            ->take(10)
            ->get(['id', 'nombre_usuario', 'rol_id', 'created_at']);

        $rolesDisponibles = \App\Models\Roles::query()
            ->whereIn('nombre', \App\Models\Roles::PERMITTED_ROLES)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return view('admin.dashboard', compact('stats', 'recentReservas', 'recentPagos', 'tipos', 'rolesDisponibles', 'recentUsuarios'));
    })->name('admin.dashboard');

    // solo admin (configuración y reportes)
    Route::middleware(['role:Administrador'])->group(function () {
        Route::resource('tipo_canchas', TipoCanchaController::class);
        Route::resource('canchas', CanchaController::class);
        Route::resource('usuarios', UsuariosController::class);
        Route::resource('roles', RolesController::class);
        Route::resource('bloqueos', \App\Http\Controllers\BloqueoController::class)->except(['show', 'edit', 'update']);
        Route::get('/reportes/export', [\App\Http\Controllers\ReporteController::class, 'export'])->name('reportes.export');
        Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/historial/cancha/{id}', [\App\Http\Controllers\HistorialController::class, 'porCancha'])->name('historial.porCancha');
        Route::get('/historial/clientes-frecuentes', [\App\Http\Controllers\HistorialController::class, 'clientesFrecuentes'])->name('historial.clientesFrecuentes');
        Route::resource('grupos', \App\Http\Controllers\GrupoController::class);
        Route::resource('estados_reserva', \App\Http\Controllers\EstadoReservaController::class);
    });

    // admin + empleado (operación día a día)
    Route::middleware(['role:Administrador,Empleado'])->group(function () {
        Route::get('/empleado', function () {
            $stats = [
                'reservas_hoy' => \App\Models\Reserva::whereDate('fecha', today())->count(),
                'reservas_pendientes' => \App\Models\Reserva::whereHas('estado', fn($q) => $q->where('nombre', 'Pendiente'))->count(),
                'ingresos_hoy' => \App\Models\Pago::whereDate('fecha_pago', today())->sum('monto'),
                'clientes_total' => \App\Models\Cliente::count(),
            ];

            $reservasHoy = \App\Models\Reserva::with(['cancha', 'cliente', 'estado'])
                ->whereDate('fecha', today())
                ->orderBy('hora_inicio')
                ->get();

            return view('empleado.dashboard', compact('stats', 'reservasHoy'));
        })->name('empleado.dashboard');

        Route::get('/reservas/calendar', function () {
            return view('admin.reservas.calendar');
        })->name('reservas.calendar');
        
        Route::resource('reservas', ReservaController::class);
        Route::resource('clientes', ClienteController::class);
        Route::resource('pagos', PagoController::class);
        Route::resource('comprobantes', ComprobanteController::class);
    });

});
