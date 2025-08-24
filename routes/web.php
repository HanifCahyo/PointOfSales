<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
});

Route::middleware('auth')->group(function () {

    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::controller(ProductController::class)->name('admin.products.')->prefix('products')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{product}', 'show')->name('show');
            Route::get('/{product}/edit', 'edit')->name('edit');
            Route::put('/{product}', 'update')->name('update');
            Route::delete('/{product}', 'destroy')->name('destroy');
        });

        Route::controller(CategoryController::class)->name('admin.category.')->prefix('categories')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{category}/edit', 'edit')->name('edit');
            Route::put('/{category}', 'update')->name('update');
            Route::delete('/{category}', 'destroy')->name('destroy');
        });

        Route::controller(StockMovementController::class)->name('admin.stock-movements.')->prefix('stock-movements')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });

        Route::controller(StockOpnameController::class)->name('admin.stock-opnames.')->prefix('stock-opnames')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });

        Route::controller(AuditLogController::class)->name('admin.audit-logs.')->prefix('audit-logs')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/export-excel', 'exportExcel')->name('exportExcel');
            Route::get('/export-pdf', 'exportPdf')->name('exportPdf');
        });

        Route::controller(UserController::class)->name('admin.users.')->prefix('users')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}', 'update')->name('update');
            Route::delete('/{user}', 'destroy')->name('destroy');
        });

    });

    Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'kasirDashboard'])->name('kasir.dashboard');

        // Transactions routes - hanya untuk kasir
        Route::controller(TransactionController::class)->name('kasir.transactions.')->prefix('transactions')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{trx}/receipt', 'receipt')->name('receipt');
            Route::get('/{trx}/invoice', 'invoice')->name('invoice');
        });
    });
});

require __DIR__ . '/auth.php';
