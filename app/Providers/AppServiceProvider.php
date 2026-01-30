<?php

namespace App\Providers;

use App\Models\DirectOrder;
use App\Observers\DirectOrderObserver;
use Illuminate\Support\ServiceProvider;

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
        DirectOrder::observe(DirectOrderObserver::class);
    }
}
