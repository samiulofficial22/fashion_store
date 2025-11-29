<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {

    function setting($key, $default = null) {
        return Cache::rememberForever("setting_$key", function () use ($key, $default) {
            $setting = \App\Models\Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

}
