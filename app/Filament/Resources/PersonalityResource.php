<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalityResource\Pages;
use App\Models\Personality;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PersonalityResource extends Resource
{
    protected static ?string $model = Personality::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'العائلة والشجرة';

    protected static ?string $modelLabel = 'شخصية';

    protected static ?string $pluralModelLabel = 'شخصيات إعتبارية';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('family_branch_id')
                ->label('الفرع')
                ->relationship('branch', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\TextInput::make('full_name')->label('الاسم الكامل')->required()->maxLength(500),
            Forms\Components\FileUpload::make('photo')->label('الصورة')->image()->disk('public')->directory('personalities'),
            Forms\Components\TextInput::make('birth_gregorian')->label('تاريخ الميلاد (ميلادي)')->maxLength(120),
            Forms\Components\TextInput::make('birth_hijri')->label('تاريخ الميلاد (هجري)')->maxLength(120),
            Forms\Components\TextInput::make('location')->label('المكان')->maxLength(255),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            Forms\Components\Toggle::make('published')->label('منشور')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('branch.name')->label('الفرع'),
                Tables\Columns\IconColumn::make('published')->label('منشور')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersonalities::route('/'),
            'create' => Pages\CreatePersonality::route('/create'),
            'edit' => Pages\EditPersonality::route('/{record}/edit'),
        ];
    }
}
