<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia; // ✅ add this
use Illuminate\Support\Facades\Auth;

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
        Inertia::share('canViewAdmin', fn () => Auth::check()
            ? Auth::user()->can('viewAdmin', \App\Models\User::class)
            : false
        );
    }
}
