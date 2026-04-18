<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumItemResource\Pages;
use App\Models\AlbumItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AlbumItemResource extends Resource
{
    protected static ?string $model = AlbumItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'الوسائط';

    protected static ?string $modelLabel = 'صورة ألبوم';

    protected static ?string $pluralModelLabel = 'صور الألبوم';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('album_category_id')
                ->label('التصنيف')
                ->relationship('category', 'name')
                ->required()
                ->preload(),
            Forms\Components\FileUpload::make('image')->label('الصورة')->image()->disk('public')->directory('album'),
            Forms\Components\TextInput::make('caption')->label('التعليق')->maxLength(500),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            Forms\Components\Toggle::make('published')->label('منشور')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->label('التصنيف'),
                Tables\Columns\ImageColumn::make('image')->label('معاينة')->disk('public'),
                Tables\Columns\TextColumn::make('caption')->label('التعليق')->limit(30),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlbumItems::route('/'),
            'create' => Pages\CreateAlbumItem::route('/create'),
            'edit' => Pages\EditAlbumItem::route('/{record}/edit'),
        ];
    }
}
