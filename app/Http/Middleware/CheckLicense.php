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
        // Only cache valid (true) results — never cache false, so re-activation takes effect immediately
        if (Cache::get('devstaq_license') === true) {
            return $next($request);
        }

        try {
            $response = Http::timeout(5)->post(config('services.devstaq.url').'/api/verify', [
                'license_key' => config('services.devstaq.key'),
                'domain'      => config('services.devstaq.domain') ?: $request->getHost(),
                'app_type'    => 'hr_management',
            ]);

            $valid  = $response->successful() && $response->json('valid') === true;
            $reason = $response->json('status') ?? 'expired'; // 'suspended' or 'expired'
        } catch (\Exception $e) {
            $valid  = true;
            $reason = null;
        }

        if (! $valid) {
            $status = $reason === 'suspended' ? 'suspended' : 'expired';
            return response(view('errors.license', compact('status')), 200);
        }

        Cache::put('devstaq_license', true, now()->addHours(6));

        return $next($request);
    }
}
