<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsBannerResource\Pages;
use App\Models\NewsBanner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsBannerResource extends Resource
{
    protected static ?string $model = NewsBanner::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'بانر أخبار';

    protected static ?string $pluralModelLabel = 'بانرات أعلى صفحة الأخبار';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('slot')
                ->label('الموضع')
                ->options([1 => 'البانر 1', 2 => 'البانر 2'])
                ->required()
                ->native(false),
            Forms\Components\FileUpload::make('image')->label('الصورة')->image()->disk('public')->directory('news-banners'),
            Forms\Components\TextInput::make('caption')->label('النص على الصورة')->maxLength(500),
            Forms\Components\TextInput::make('link')->label('الرابط')->url()->maxLength(500),
            Forms\Components\Toggle::make('is_active')->label('مفعّل')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slot')->label('الموضع'),
                Tables\Columns\ImageColumn::make('image')->label('معاينة')->disk('public'),
                Tables\Columns\TextColumn::make('caption')->label('النص')->limit(40),
                Tables\Columns\IconColumn::make('is_active')->label('مفعّل')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsBanners::route('/'),
            'create' => Pages\CreateNewsBanner::route('/create'),
            'edit' => Pages\EditNewsBanner::route('/{record}/edit'),
        ];
    }
}
