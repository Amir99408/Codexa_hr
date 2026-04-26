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
    }

    public function save(): void
    {
        $this->validate([
            'company_name'  => 'required|string|max:100',
            'company_email' => 'nullable|email',
            'working_days'  => 'required|integer|min:1|max:31',
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

        $this->message = 'Company settings saved successfully.';
    }

    public function render()
    {
        return view('livewire.settings.company-settings')
            ->layout('layouts.app', ['title' => 'Company Settings']);
    }
}