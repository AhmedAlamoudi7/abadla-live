<?php

namespace App\Filament\Resources\NewsBannerResource\Pages;

use App\Filament\Resources\NewsBannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsBanners extends ListRecords
{
    protected static string $resource = NewsBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
