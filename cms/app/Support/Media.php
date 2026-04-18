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
}
