<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeFeaturedEventResource\Pages;
use App\Models\HomeFeaturedEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeFeaturedEventResource extends Resource
{
    protected static ?string $model = HomeFeaturedEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'فعالية مميزة في الرئيسية';

    protected static ?string $pluralModelLabel = 'فعاليات الرئيسية';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('event_id')
                ->label('الفعالية')
                ->relationship('event', 'title')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title')->label('الفعالية'),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeFeaturedEvents::route('/'),
            'create' => Pages\CreateHomeFeaturedEvent::route('/create'),
            'edit' => Pages\EditHomeFeaturedEvent::route('/{record}/edit'),
        ];
    }
}
