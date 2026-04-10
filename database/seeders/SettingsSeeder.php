<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'company_name'    => 'HRFlow',
            'company_email'   => 'hr@company.com',
            'company_phone'   => '',
            'company_address' => '',
            'company_website' => '',
            'currency'        => 'PKR',
            'timezone'        => 'Asia/Karachi',
            'date_format'     => 'd M Y',
            'working_days'    => '22',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}