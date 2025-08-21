<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/profile', 'edit')->name('edit');
        Route::patch('/profile', 'update')->name('update');
        Route::delete('/profile', 'destroy')->name('destroy');
    });

    // Products routes
    Route::controller(ProductController::class)->name('products.')->prefix('products')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::put('/{product}', 'update')->name('update');
        Route::delete('/{product}', 'destroy')->name('destroy');
    });

    // Transactions routes
    Route::controller(TransactionController::class)->name('transactions.')->prefix('transactions')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/invoice', 'invoice')->name('invoice');
    });
});

require __DIR__ . '/auth.php';
