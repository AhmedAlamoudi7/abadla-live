<?php

namespace App\Filament\Resources\FamousMemberResource\Pages;

use App\Filament\Resources\FamousMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamousMembers extends ListRecords
{
    protected static string $resource = FamousMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
