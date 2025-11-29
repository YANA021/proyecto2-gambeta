<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoCanchaController;

Route::get('/', function () {
    return view('welcome');
});


// Rutas para Tipos de Canchas
Route::resource('tipo_canchas', TipoCanchaController::class);