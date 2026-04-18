<?php

namespace App\Filament\Widgets;

use App\Models\ArchiveSubmission;
use App\Models\ContactMessage;
use App\Models\NewsPost;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('طلبات أرشيف قيد المراجعة', (string) ArchiveSubmission::query()->where('status', 'pending')->count()),
            Stat::make('أخبار منشورة', (string) NewsPost::query()->where('published', true)->count()),
            Stat::make('رسائل تواصل غير مقروءة', (string) ContactMessage::query()->whereNull('read_at')->count()),
        ];
    }
}
