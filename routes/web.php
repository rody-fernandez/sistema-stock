<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard general (cualquier usuario autenticado)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil de usuario
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard de admin (requiere rol admin)
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Dashboard de usuario normal
Route::get('/user', function () {
    return view('user.dashboard');
})->middleware(['auth'])->name('user.dashboard');

// Autenticación (Breeze/Fortify/Jetstream)
require __DIR__.'/auth.php';
