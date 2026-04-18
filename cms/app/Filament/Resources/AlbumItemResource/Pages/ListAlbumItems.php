<?php

namespace App\Filament\Resources\AlbumItemResource\Pages;

use App\Filament\Resources\AlbumItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlbumItems extends ListRecords
{
    protected static string $resource = AlbumItemResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
