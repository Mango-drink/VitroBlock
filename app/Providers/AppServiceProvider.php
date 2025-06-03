<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

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
        //

        Inertia::share([
            'appName' => config('app.name'),
            'flash' => fn () => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);


        Schema::defaultStringLength(191);//Migraciones a la base de datos
    }
}

