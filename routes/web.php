<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanySwitchController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\FinalPayController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::post('/switch-company', [CompanySwitchController::class, 'switch'])
        ->name('company.switch');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('tax-rates', TaxRateController::class);
        
        // ADDED: Toggle route for tax rates
        Route::post('tax-rates/{taxRate}/toggle', [TaxRateController::class, 'toggleActive'])
            ->name('tax-rates.toggle');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tax Table Group Routes (using description)
    Route::get('admin/tax-rates/group/{description}/edit', [TaxRateController::class, 'editGroup'])
        ->name('admin.tax-rates.edit-group');
    Route::put('admin/tax-rates/group/{description}', [TaxRateController::class, 'updateGroup'])
        ->name('admin.tax-rates.update-group');
    Route::delete('admin/tax-rates/group/{description}', [TaxRateController::class, 'destroyGroup'])
        ->name('admin.tax-rates.destroy-group');

    Route::prefix('final-pay')->name('final-pay.')->group(function () {
        Route::get('/', [FinalPayController::class, 'index'])->name('index');
        Route::get('/create', [FinalPayController::class, 'create'])->name('create');
        Route::post('/', [FinalPayController::class, 'store'])->name('store');
        Route::get('/{id}', [FinalPayController::class, 'show'])->name('show');
        Route::delete('/{id}', [FinalPayController::class, 'destroy'])->name('destroy');
    });

    Route::post('admin/tax-rates/store-multiple', [TaxRateController::class, 'storeMultiple'])
    ->name('admin.tax-rates.store-multiple');

    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('index');
        Route::get('/create', [PayrollController::class, 'create'])->name('create');
        Route::post('/', [PayrollController::class, 'store'])->name('store');
        Route::get('/{id}', [PayrollController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PayrollController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PayrollController::class, 'update'])->name('update');
        Route::delete('/{id}', [PayrollController::class, 'destroy'])->name('destroy');
    });
    
});

require __DIR__.'/auth.php';