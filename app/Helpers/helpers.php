<?php

use App\Models\Setting;

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null) {
        return Setting::where('key', $key)->value('value') ?? $default;
    }
}

if (!function_exists('adjustColorBrightness')) {
    function adjustColorBrightness($hex, $percent) {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $r = max(0, min(255, $r + ($percent * 255)));
        $g = max(0, min(255, $g + ($percent * 255)));
        $b = max(0, min(255, $b + ($percent * 255)));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}