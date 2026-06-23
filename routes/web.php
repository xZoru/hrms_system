<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanySwitchController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return redirect()->route('login');
});

// ===== AUTHENTICATED ROUTES =====
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    // ===== EMPLOYEE ROUTES =====
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    // ===== COMPANY SWITCHER =====
    Route::post('/switch-company', [CompanySwitchController::class, 'switch'])
        ->name('company.switch');

    // ===== ADMIN ROUTES (Super Admin Only) =====
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ===== PROFILE ROUTES =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== AUTH ROUTES (Login, Register, etc.) =====
require __DIR__.'/auth.php';