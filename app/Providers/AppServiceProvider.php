<?php

namespace App\Providers;

use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('update-product', [ProductPolicy::class, 'update']);
        Gate::define('destroy-product', [ProductPolicy::class, 'destroy']);
    }
}
