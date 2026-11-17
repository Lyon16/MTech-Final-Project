<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SalesController;

// =====================================
// PUBLIC AUTHENTICATION ROUTES
// =====================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

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

    // Staff Management
    Route::resource('staff', StaffController::class);

    // Sales History
    Route::get('/sales', [SalesController::class, 'index'])
        ->name('sales.index');

    // Record Sale Form
    Route::get('/sales/create', [SalesController::class, 'create'])
        ->name('sales.create');

    // Process Sale
    Route::post('/sales', [SalesController::class, 'store'])
        ->name('sales.store');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
