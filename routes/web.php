<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoCanchaController;
use App\Http\Controllers\CanchaController;
use App\Models\TipoCancha;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    $tipos = TipoCancha::latest()->take(5)->get();

    $stats = [
        'canchas' => $tipos->count(),
        'reservasHoy' => null,
        'ingresosSemana' => null,
        'ocupacion' => null,
    ];

    $actividades = [];

    return view('admin.dashboard', compact('tipos', 'stats', 'actividades'));
})->name('admin.dashboard');


// Rutas para Tipos de Canchas
Route::resource('tipo_canchas', TipoCanchaController::class);
Route::resource('canchas', CanchaController::class);
