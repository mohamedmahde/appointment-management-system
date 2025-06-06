<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
        if (auth()->check()) {
            auth()->user()->update(['last_seen' => now()]);
            Schema::defaultStringLength(191);

        }
        //
    }
}
