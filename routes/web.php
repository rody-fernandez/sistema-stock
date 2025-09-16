<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;

Route::resource('products', ProductController::class);
Route::resource('purchases', PurchaseController::class)->only(['index','create','store','show']);
