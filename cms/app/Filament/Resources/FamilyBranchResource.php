<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyBranchResource\Pages;
use App\Models\FamilyBranch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FamilyBranchResource extends Resource
{
    protected static ?string $model = FamilyBranch::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'العائلة والشجرة';

    protected static ?string $modelLabel = 'فرع';

    protected static ?string $pluralModelLabel = 'فروع العائلة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('اسم الفرع')->required()->maxLength(255),
            Forms\Components\TextInput::make('slug')->label('المسار')->maxLength(255)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            Forms\Components\TextInput::make('member_count')->label('عدد الأفراد (عرض)')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('member_count')->label('العدد'),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyBranches::route('/'),
            'create' => Pages\CreateFamilyBranch::route('/create'),
            'edit' => Pages\EditFamilyBranch::route('/{record}/edit'),
        ];
    }
}
