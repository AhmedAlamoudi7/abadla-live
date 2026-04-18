<?php

namespace App\Filament\Resources\SocialOccasionResource\Pages;

use App\Filament\Resources\SocialOccasionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialOccasions extends ListRecords
{
    protected static string $resource = SocialOccasionResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
