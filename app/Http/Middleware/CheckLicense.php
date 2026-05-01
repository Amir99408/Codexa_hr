<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        // Skip license check on the activation route itself
        if ($request->routeIs('license.activate') || $request->routeIs('license.activate.submit')) {
            return $next($request);
        }

        $cacheKey   = 'devstaq_license_' . (config('services.devstaq.domain') ?: $request->getHost());
        $licenseKey = Setting::get('license_key') ?: config('services.devstaq.key');

        // No license key configured at all → send to activation page
        if (! $licenseKey) {
            return redirect()->route('license.activate');
        }

        // Only cache valid (true) results — never cache false, so re-activation takes effect immediately
        if (Cache::get($cacheKey) === true) {
            return $next($request);
        }

        try {
            $response = Http::timeout(5)->post(config('services.devstaq.url') . '/api/verify', [
                'license_key' => $licenseKey,
                'domain'      => config('services.devstaq.domain') ?: $request->getHost(),
                'app_type'    => config('services.devstaq.app_type'),
            ]);

            $valid  = $response->successful() && $response->json('valid') === true;
            $reason = $response->json('reason') ?? 'expired';
        } catch (\Exception $e) {
            $valid  = true;
            $reason = null;
        }

        if (! $valid) {
            $status = $reason === 'suspended' ? 'suspended' : 'expired';
            return response(view('errors.license', compact('status')), 200);
        }

        Cache::put($cacheKey, true, now()->addMinutes(15));

        return $next($request);
    }
}
