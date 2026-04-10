<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = 'en';

        if (auth()->check() && auth()->user()->locale) {
            $locale = auth()->user()->locale;
        }

        if (!in_array($locale, ['en', 'ur', 'ar'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}