<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

// Abrir el login siempre pide los datos otra vez (cierra la sesión si había una)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Rutas para visitantes (si ya iniciaste sesión, te manda a la lista de clientes)
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rutas protegidas (si no iniciaste sesión, te manda al login)
Route::middleware('auth')->group(function () {
    Route::redirect('/', '/clientes');

    Route::resource('clientes', ClienteController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
