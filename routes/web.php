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
    return view('pages.home');
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
    $companyId = auth('company')->id();

    $employees = \App\Models\Employee::where('company_id', $companyId)->get();
    $buses = \App\Models\Bus::where('company_id', $companyId)->get();

    return view('company.dashboard.dashboard', [
        'employees' => $employees,
        'buses' => $buses,
        'totalBuses' => $buses->count(),
        'activeBuses' => $buses->where('status', 'active')->count(),
        'employeesCount' => $employees->count(),
    ]);
})->name('company.dashboard');
        // Employee Management
        Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::put('employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        
        // Bus Management (KËTU - NUK DUPLIKAT)
        Route::get('buses', [BusController::class, 'index'])->name('buses.index');
        Route::post('buses', [BusController::class, 'store'])->name('buses.store');
    Route::put('buses/{bus}', [BusController::class, 'update'])->name('buses.update');
Route::delete('buses/{bus}', [BusController::class, 'destroy'])->name('buses.destroy');
    });

    // ===== EMPLOYEE ONLY ROUTES =====
    Route::middleware(CheckEmployee::class)->group(function () {
        Route::get('profile', [EmployeeProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile', [EmployeeProfileController::class, 'update'])->name('profile.update');
    });
});
Route::get('test-modal', function() {
    return view('test-bus-modal');
})->name('test-modal');