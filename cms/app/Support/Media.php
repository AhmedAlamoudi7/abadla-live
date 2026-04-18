<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class Media
{
    public static function url(?string $path, ?string $fallback = null): string
    {
        if ($path === null || $path === '') {
            return $fallback ?? asset('legacy/img/banner.jpg');
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Home sections: legacy paths (e.g. img/article.jpg), full URLs, or Filament uploads under public disk (e.g. home-sections/…).
     */
    public static function settingImage(?string $path, string $defaultLegacy = 'img/article.jpg'): string
    {
        if ($path === null || $path === '') {
            return asset('legacy/'.ltrim($defaultLegacy, '/'));
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = ltrim($path, '/');
        if (str_starts_with($path, 'home-sections/')) {
            return Storage::disk('public')->url($path);
        }

        return asset('legacy/'.$path);
    }
}
