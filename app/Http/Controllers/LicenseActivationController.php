<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LicenseActivationController extends Controller
{
    public function show()
    {
        // Already has a valid license → go to dashboard
        $licenseKey = Setting::get('license_key') ?: config('services.devstaq.key');
        if ($licenseKey) {
            $cacheKey = 'devstaq_license_' . config('services.devstaq.domain');
            if (Cache::get($cacheKey) === true) {
                return redirect()->route('dashboard');
            }
        }

        return view('license.activate');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string',
        ]);

        $key = strtoupper(trim($request->license_key));

        try {
            $response = Http::timeout(8)->post(config('services.devstaq.url') . '/api/verify', [
                'license_key' => $key,
                'domain'      => config('services.devstaq.domain') ?: $request->getHost(),
                'app_type'    => config('services.devstaq.app_type'),
            ]);

            $valid  = $response->successful() && $response->json('valid') === true;
            $reason = $response->json('reason') ?? 'invalid';
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Could not reach the license server. Please try again.');
        }

        if (! $valid) {
            $messages = [
                'suspended'      => 'This license key has been suspended. Please contact support.',
                'expired'        => 'This license key has expired. Please renew your license.',
                'domain_mismatch'=> 'This license key is not registered for this domain.',
                'invalid_key'    => 'Invalid license key. Please check and try again.',
            ];

            return back()->withInput()->with('error', $messages[$reason] ?? 'Invalid license key. Please check and try again.');
        }

        // Save to DB and cache
        Setting::set('license_key', $key);
        $cacheKey = 'devstaq_license_' . (config('services.devstaq.domain') ?: $request->getHost());
        Cache::put($cacheKey, true, now()->addMinutes(15));

        return redirect()->route('dashboard')->with('success', 'License activated successfully. Welcome to HRFlow!');
    }
}
