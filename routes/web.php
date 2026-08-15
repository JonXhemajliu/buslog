<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\BusController;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\CheckCompany;
use App\Http\Middleware\CheckEmployee;

// ===== PUBLIC ROUTES (NO MIDDLEWARE) =====
Route::get('/', function () {
    // Nëse je logged in, shfaq home page normalisht (jo redirect)
    // Nëse nuk je logged in, shfaq home page
    return view('pages.home');  // ← NDRYSHOJI NGA 'home' NË 'pages.home'
})->name('home');

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::post('register', [AuthController::class, 'registerCompany'])->name('register.store');

// ===== PROTECTED ROUTES (WITH AuthCheck MIDDLEWARE) =====
Route::middleware(AuthCheck::class)->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Generic dashboard (keep for compatibility)
    Route::get('dashboard', function () {
        return view('app', ['page' => 'dashboard']);
    })->name('dashboard');
    
    Route::get('track-buses', function () {
        return view('app', ['page' => 'track-buses']);
    })->name('track-buses');

    // ===== COMPANY ONLY ROUTES =====
    Route::middleware(CheckCompany::class)->group(function () {
        // Company Dashboard
      Route::get('company/dashboard', function () {
    return view('company.dashboard.dashboard');
})->name('company.dashboard');

        // Employee Management
        Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::put('employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        
        // Bus Management
        Route::get('buses', [BusController::class, 'index'])->name('buses.index');
        Route::post('buses', [BusController::class, 'store'])->name('buses.store');
        Route::put('buses/{id}', [BusController::class, 'update'])->name('buses.update');
        Route::delete('buses/{id}', [BusController::class, 'destroy'])->name('buses.destroy');
    });

    // ===== EMPLOYEE ONLY ROUTES =====
    Route::middleware(CheckEmployee::class)->group(function () {
        Route::get('profile', [EmployeeProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [EmployeeProfileController::class, 'update'])->name('profile.update');
    });
});