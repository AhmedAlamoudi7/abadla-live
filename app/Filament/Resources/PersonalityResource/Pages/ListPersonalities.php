<?php

namespace App\Filament\Resources\PersonalityResource\Pages;

use App\Filament\Resources\PersonalityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersonalities extends ListRecords
{
    protected static string $resource = PersonalityResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
