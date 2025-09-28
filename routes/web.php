<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;use App\Http\Controllers\SaleController;

Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('sales', SaleController::class)->only(['index','create','store','show']);
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
});
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

    // Panel Usuario (cualquier usuario logueado)
    Route::get('/user', function () {
        return view('users.dashboard');
    })->name('user.dashboard');

    // Panel Admin (solo usuarios con rol admin)
    //Route::middleware('role:admin')->group(function () {
      //  Route::get('/admin', function () {
        //    return view('admin.dashboard');
        ///})->name('admin.dashboard');

       // Route::resource('products', ProductController::class);
   // });
});

// Rutas de autenticación (login, register, forgot password, etc.)
require __DIR__.'/auth.php';


Route::get('/ventas-test', function () {
    // datos simulados
    $customers = [
        (object)['id' => 1, 'name' => 'Cliente Prueba'],
        (object)['id' => 2, 'name' => 'Cliente Demo'],
    ];

    $products = [
        (object)['id' => 1, 'name' => 'Producto A', 'price' => 100],
        (object)['id' => 2, 'name' => 'Producto B', 'price' => 250],
    ];

    return view('sales.create', compact('customers','products'));
});
