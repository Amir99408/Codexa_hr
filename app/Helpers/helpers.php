<?php

if (!function_exists('currency')) {
    function currency(float|int|string|null $amount): string
    {
        $symbol = \App\Models\Setting::get('currency', 'PKR');
        return $symbol . ' ' . number_format((float)($amount ?? 0));
    }
}