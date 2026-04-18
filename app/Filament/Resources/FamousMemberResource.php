<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamousMemberResource\Pages;
use App\Models\FamousMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FamousMemberResource extends Resource
{
    protected static ?string $model = FamousMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'العائلة والشجرة';

    protected static ?string $modelLabel = 'مشهور';

    protected static ?string $pluralModelLabel = 'من مشاهير العائلة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('الاسم')->required()->maxLength(500),
            Forms\Components\Textarea::make('line_one')->label('سطر 1')->rows(2),
            Forms\Components\Textarea::make('line_two')->label('سطر 2')->rows(2),
            Forms\Components\FileUpload::make('photo')->label('صورة')->image()->disk('public')->directory('famous'),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamousMembers::route('/'),
            'create' => Pages\CreateFamousMember::route('/create'),
            'edit' => Pages\EditFamousMember::route('/{record}/edit'),
        ];
    }
}
