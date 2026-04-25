<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Allow Spatie permission names to be used directly with Gate::authorize()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true; // admin bypasses all checks
            }
        });
    }
}
