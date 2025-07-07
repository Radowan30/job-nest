<?php
//! modify this later
namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
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
    public function boot()
    {
        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }
        Inertia::share('auth.user', function () {
            $user = auth()->user();
            return $user ? ['id' => $user->id, 'role' => $user->role, 'name' => $user->name] : null;
        });
    }
}
