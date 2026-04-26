<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class SetAppSettings
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $timezone = Setting::get('timezone', config('app.timezone'));
            if ($timezone) {
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
            }
        } catch (\Throwable) {
            // DB not ready yet (migrations not run)
        }

        return $next($request);
    }
}
