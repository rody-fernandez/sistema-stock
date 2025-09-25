<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Estas rutas están pensadas para tu sistema de stock:
| - Login / Register → Breeze (require __DIR__.'/auth.php')
| - Dashboard general
| - Panel Admin (solo rol admin)
| - Panel Usuario normal
| - Perfil de usuario
*/

// Página principal → redirige al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Grupo de rutas protegidas (auth + email verificado)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard general
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Panel Admin (solo usuarios con rol admin)
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    // Panel Usuario (cualquier usuario logueado)
    Route::get('/user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Rutas de autenticación (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
