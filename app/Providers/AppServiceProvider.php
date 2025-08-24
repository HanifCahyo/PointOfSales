<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\StockMovement;
use App\Models\StockOpname;
use App\Observers\ProductObserver;
use App\Observers\TransactionObserver;
use App\Observers\StockMovementObserver;
use App\Observers\StockOpnameObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Transaction::observe(TransactionObserver::class);
        StockMovement::observe(StockMovementObserver::class);
        StockOpname::observe(StockOpnameObserver::class);
    }
}
