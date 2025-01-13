<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KasirMiddleware;

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
    public function boot()
    {
        // Registrasi middleware 'admin' dan 'kasir'
        $this->app->singleton('admin', function () {
            return new AdminMiddleware;
        });

        $this->app->singleton('kasir', function () {
            return new KasirMiddleware;
        });
    }
}
