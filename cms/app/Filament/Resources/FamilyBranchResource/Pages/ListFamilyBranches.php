<?php

namespace App\Filament\Resources\FamilyBranchResource\Pages;

use App\Filament\Resources\FamilyBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyBranches extends ListRecords
{
    protected static string $resource = FamilyBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
