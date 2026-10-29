
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

// =====================================
// PUBLIC AUTHENTICATION ROUTES
// =====================================

Route::middleware('guest')->group(function () {

    // Login Page
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    // Process Login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

});

// =====================================
// PROTECTED POS MANAGEMENT ROUTES
// =====================================

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Customer Management
    Route::resource('customers', CustomerController::class);

    // Product Management
    Route::resource('products', ProductController::class);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
