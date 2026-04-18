<?php

namespace App\Filament\Resources\SocialCategoryResource\Pages;

use App\Filament\Resources\SocialCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialCategories extends ListRecords
{
    protected static string $resource = SocialCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
