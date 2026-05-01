<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class LicenseSettings extends Component
{
    public string $license_key  = '';
    public string $message      = '';
    public string $messageType  = 'success';
    public ?array $licenseInfo  = null;

    public function mount(): void
    {
        $stored = Setting::get('license_key') ?: config('services.devstaq.key', '');
        $this->license_key = $stored ? $this->maskKey($stored) : '';
        $this->loadLicenseInfo();
    }

    public function save(): void
    {
        $this->validate(['license_key' => 'required|string|min:10']);

        $key = strtoupper(trim($this->license_key));

        try {
            $response = Http::timeout(8)->post(config('services.devstaq.url') . '/api/verify', [
                'license_key' => $key,
                'domain'      => config('services.devstaq.domain'),
                'app_type'    => config('services.devstaq.app_type'),
            ]);

            $valid  = $response->successful() && $response->json('valid') === true;
            $reason = $response->json('reason') ?? 'invalid';
        } catch (\Exception $e) {
            $this->message     = 'Could not reach the license server. Please try again.';
            $this->messageType = 'error';
            return;
        }

        if (! $valid) {
            $messages = [
                'suspended'       => 'This license has been suspended.',
                'expired'         => 'This license has expired.',
                'domain_mismatch' => 'This key is not registered for this domain.',
                'invalid_key'     => 'Invalid license key.',
            ];
            $this->message     = $messages[$reason] ?? 'Invalid license key.';
            $this->messageType = 'error';
            return;
        }

        Setting::set('license_key', $key);

        $cacheKey = 'devstaq_license_' . config('services.devstaq.domain');
        Cache::put($cacheKey, true, now()->addMinutes(15));

        $this->license_key  = $this->maskKey($key);
        $this->licenseInfo  = $response->json();
        $this->message      = 'License updated successfully.';
        $this->messageType  = 'success';
    }

    public function refresh(): void
    {
        $this->loadLicenseInfo();

        $cacheKey = 'devstaq_license_' . config('services.devstaq.domain');

        if (! empty($this->licenseInfo['valid'])) {
            // License is active — extend cache
            Cache::put($cacheKey, true, now()->addMinutes(15));
        }
        // If invalid, leave cache alone — let it expire naturally (max 15 min)
        // so the admin isn't locked out just by checking the status

        $this->message     = 'License status refreshed.';
        $this->messageType = 'success';
    }

    private function loadLicenseInfo(): void
    {
        $key = Setting::get('license_key') ?: config('services.devstaq.key');
        if (! $key) return;

        try {
            $response = Http::timeout(5)->post(config('services.devstaq.url') . '/api/verify', [
                'license_key' => $key,
                'domain'      => config('services.devstaq.domain'),
                'app_type'    => config('services.devstaq.app_type'),
            ]);
            $this->licenseInfo = $response->json();
        } catch (\Exception $e) {
            $this->licenseInfo = null;
        }
    }

    private function maskKey(string $key): string
    {
        // Show first segment clearly, mask the rest: XXXX-****-****-****
        $parts = explode('-', $key);
        if (count($parts) === 4) {
            return $parts[0] . '-****-****-' . $parts[3];
        }
        return substr($key, 0, 4) . str_repeat('*', strlen($key) - 4);
    }

    public function render()
    {
        return view('livewire.settings.license-settings')
            ->layout('layouts.app', ['title' => 'License Settings']);
    }
}
