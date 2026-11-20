<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\DashboardController;

// =====================================
// PUBLIC PRODUCT AND AVATAR IMAGES
// =====================================

Route::get('/storage/{type}/{filename}', function (
    string $type,
    string $filename
) {
    abort_unless(
        in_array($type, ['products', 'avatars'], true),
        404
    );

    abort_unless(
        preg_match(
            '/\A[a-zA-Z0-9_-]+\.(?:jpg|jpeg|png|webp)\z/i',
            $filename
        ),
        404
    );

    $path = $type . '/' . $filename;
    $disk = Storage::disk('public');

    abort_unless($disk->exists($path), 404);

    return response()->file(
        $disk->path($path),
        [
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'public, max-age=3600',
        ]
    );
})->middleware('auth')->name('storage.image');


// =====================================
// PUBLIC AUTHENTICATION ROUTES
// =====================================

Route::middleware('guest')->group(function () {

    // Login page
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    // Process login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

});


// =====================================
// PROTECTED POS MANAGEMENT ROUTES
// =====================================

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Customer Management
    Route::resource('customers', CustomerController::class);

    // Product Management
    Route::resource('products', ProductController::class);

    // Administrator-only Staff Management
    Route::resource('staff', StaffController::class)
        ->middleware('can:manage-staff');

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
