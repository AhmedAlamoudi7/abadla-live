<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialCategoryResource\Pages;
use App\Models\SocialCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialCategoryResource extends Resource
{
    protected static ?string $model = SocialCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'الوسائط';

    protected static ?string $modelLabel = 'تصنيف إجتماعي';

    protected static ?string $pluralModelLabel = 'تصنيفات الإجتماعيات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('الاسم')->required()->maxLength(255),
            Forms\Components\TextInput::make('slug')->label('المسار')->required()->unique(ignoreRecord: true)->maxLength(120),
            Forms\Components\FileUpload::make('icon_image')->label('أيقونة')->image()->disk('public')->directory('social-icons'),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم'),
                Tables\Columns\ImageColumn::make('icon_image')->label('أيقونة')->disk('public')->square(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialCategories::route('/'),
            'create' => Pages\CreateSocialCategory::route('/create'),
            'edit' => Pages\EditSocialCategory::route('/{record}/edit'),
        ];
    }
}
