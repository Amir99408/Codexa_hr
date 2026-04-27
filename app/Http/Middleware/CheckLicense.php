<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        $valid = Cache::remember('devstaq_license', now()->addHours(6), function () use ($request) {
            try {
                $response = Http::timeout(5)->post(config('services.devstaq.url').'/api/verify', [
                    'license_key' => config('services.devstaq.key'),
                    'domain'      => $request->getHost(),
                    'app_type'    => 'hr_management',
                ]);

                return $response->successful() && $response->json('valid') === true;
            } catch (\Exception $e) {
                return true; // don't block users if license server is temporarily down
            }
        });

        if (! $valid) {
            abort(403, 'Your license is invalid or has expired. Please contact DevStaq.');
        }

        return $next($request);
    }
}
