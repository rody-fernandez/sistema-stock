<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::get('/admin', fn () => view('admin.dashboard'))
  //  ->middleware(['auth', 'role:admin'])
    //->name('admin.dashboard');


Route::get('/admin', fn () => view('admin.dashboard'))
    ->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])
    ->name('admin.dashboard');

Route::get('/user', fn () => view('user.dashboard'))
    ->middleware(['auth'])
    ->name('user.dashboard');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/user', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth','role:admin'])->name('admin.dashboard');


require __DIR__.'/auth.php';
