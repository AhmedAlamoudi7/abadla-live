<?php

namespace App\Filament\Resources\AlbumCategoryResource\Pages;

use App\Filament\Resources\AlbumCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlbumCategories extends ListRecords
{
    protected static string $resource = AlbumCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
