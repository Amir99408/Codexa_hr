<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsCaches
{
    public static function bootClearsCaches(): void
    {
        static::saved(fn()   => static::flushCaches());
        static::deleted(fn() => static::flushCaches());
    }

    protected static function flushCaches(): void
    {
        foreach (static::$cacheKeys ?? [] as $key) {
            Cache::forget($key);
        }
    }
}
