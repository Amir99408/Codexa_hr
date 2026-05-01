<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanySettings extends Component
{
    use WithFileUploads;

    public string $company_name    = '';
    public string $company_email   = '';
    public string $company_phone   = '';
    public string $company_address = '';
    public string $company_website = '';
    public string $currency        = '';
    public string $timezone        = '';
    public string $date_format     = '';
    public string $working_days    = '';
    public bool   $device_enabled  = false;
    public string $device_secret   = '';
    public string $message         = '';

    // Branding
    public        $logo_file    = null;
    public        $favicon_file = null;
    public string $logo_path    = '';
    public string $favicon_path = '';

    public function mount(): void
    {
        $this->company_name    = Setting::get('company_name', '');
        $this->company_email   = Setting::get('company_email', '');
        $this->company_phone   = Setting::get('company_phone', '');
        $this->company_address = Setting::get('company_address', '');
        $this->company_website = Setting::get('company_website', '');
        $this->currency        = Setting::get('currency', 'PKR');
        $this->timezone        = Setting::get('timezone', 'Asia/Karachi');
        $this->date_format     = Setting::get('date_format', 'd M Y');
        $this->working_days    = Setting::get('working_days', '22');
        $this->device_enabled  = (bool) Setting::get('device_enabled', false);
        $this->device_secret   = Setting::get('device_secret') ?: \Illuminate\Support\Str::random(32);
        $this->logo_path       = Setting::get('company_logo', '');
        $this->favicon_path    = Setting::get('company_favicon', '');
    }

    public function save(): void
    {
        $this->validate([
            'company_name'  => 'required|string|max:100',
            'company_email' => 'nullable|email',
            'working_days'  => 'required|integer|min:1|max:31',
            'logo_file'     => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'favicon_file'  => 'nullable|image|mimes:png,jpg,jpeg,ico|max:512',
        ]);

        Setting::set('company_name',    $this->company_name);
        Setting::set('company_email',   $this->company_email);
        Setting::set('company_phone',   $this->company_phone);
        Setting::set('company_address', $this->company_address);
        Setting::set('company_website', $this->company_website);
        Setting::set('currency',        $this->currency);
        Setting::set('timezone',        $this->timezone);
        Setting::set('date_format',     $this->date_format);
        Setting::set('working_days',    $this->working_days);
        Setting::set('device_enabled',  $this->device_enabled ? '1' : '0');
        Setting::set('device_secret',   $this->device_secret);

        if ($this->logo_file) {
            $path = $this->logo_file->storeAs('branding', 'logo.' . $this->logo_file->getClientOriginalExtension(), 'public');
            Setting::set('company_logo', \Illuminate\Support\Facades\Storage::url($path));
            $this->logo_path = \Illuminate\Support\Facades\Storage::url($path);
            $this->logo_file = null;
        }

        if ($this->favicon_file) {
            $path = $this->favicon_file->storeAs('branding', 'favicon.' . $this->favicon_file->getClientOriginalExtension(), 'public');
            Setting::set('company_favicon', \Illuminate\Support\Facades\Storage::url($path));
            $this->favicon_path = \Illuminate\Support\Facades\Storage::url($path);
            $this->favicon_file = null;
        }

        $this->message = 'Company settings saved successfully.';
    }

    public function render()
    {
        return view('livewire.settings.company-settings')
            ->layout('layouts.app', ['title' => 'Company Settings']);
    }
}