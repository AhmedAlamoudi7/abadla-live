<?php

namespace App\Filament\Resources\HomeFeaturedEventResource\Pages;

use App\Filament\Resources\HomeFeaturedEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeFeaturedEvents extends ListRecords
{
    protected static string $resource = HomeFeaturedEventResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
