<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

// Public Login Routes
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

});

// Protected POS Routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Customer Management (CRUD)
    Route::resource('customers', CustomerController::class);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});
