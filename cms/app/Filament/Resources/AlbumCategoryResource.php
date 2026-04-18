<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumCategoryResource\Pages;
use App\Models\AlbumCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AlbumCategoryResource extends Resource
{
    protected static ?string $model = AlbumCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'الوسائط';

    protected static ?string $modelLabel = 'تصنيف ألبوم';

    protected static ?string $pluralModelLabel = 'تصنيفات الألبوم';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('الاسم')->required()->maxLength(255),
            Forms\Components\TextInput::make('slug')->label('المسار')->required()->unique(ignoreRecord: true)->maxLength(120),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم'),
                Tables\Columns\TextColumn::make('slug')->label('المسار'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlbumCategories::route('/'),
            'create' => Pages\CreateAlbumCategory::route('/create'),
            'edit' => Pages\EditAlbumCategory::route('/{record}/edit'),
        ];
    }
}
