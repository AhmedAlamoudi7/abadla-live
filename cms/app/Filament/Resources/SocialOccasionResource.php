<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialOccasionResource\Pages;
use App\Models\SocialOccasion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialOccasionResource extends Resource
{
    protected static ?string $model = SocialOccasion::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'مناسبة';

    protected static ?string $pluralModelLabel = 'إجتماعيات (مناسبات)';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('social_category_id')
                ->label('التصنيف')
                ->relationship('category', 'name')
                ->required()
                ->preload(),
            Forms\Components\TextInput::make('title')->label('العنوان')->required()->maxLength(500),
            Forms\Components\DatePicker::make('occurred_on')->label('التاريخ'),
            Forms\Components\FileUpload::make('image')->label('صورة')->image()->disk('public')->directory('social'),
            Forms\Components\Textarea::make('excerpt')->label('نبذة')->rows(3),
            Forms\Components\Toggle::make('published')->label('منشور')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->label('التصنيف'),
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('occurred_on')->label('التاريخ')->date(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialOccasions::route('/'),
            'create' => Pages\CreateSocialOccasion::route('/create'),
            'edit' => Pages\EditSocialOccasion::route('/{record}/edit'),
        ];
    }
}
