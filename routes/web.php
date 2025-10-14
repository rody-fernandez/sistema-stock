<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('purchases', \App\Http\Controllers\PurchaseController::class);
});

// 🔹 Página inicial → redirige al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 🔹 Rutas protegidas por login y verificación
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Panel de usuario general
    Route::get('/user', function () {
        return view('users.dashboard');
    })->name('user.dashboard');

    // 🔹 Rutas principales de gestión (productos, ventas, compras, clientes, proveedores)
    Route::resource('products', ProductController::class);
    //Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
});

// 🔹 Rutas de autenticación (login, registro, etc.)
require __DIR__.'/auth.php';

// 🔹 Ruta temporal de prueba para crear ventas (solo desarrollo)
Route::get('/ventas-test', function () {
    $customers = [
        (object)['id' => 1, 'name' => 'Cliente Prueba'],
        (object)['id' => 2, 'name' => 'Cliente Demo'],
    ];

    $products = [
        (object)['id' => 1, 'name' => 'Producto A', 'price' => 100],
        (object)['id' => 2, 'name' => 'Producto B', 'price' => 250],
    ];

    return view('sales.create', compact('customers', 'products'));
});
