<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyMemberResource\Pages;
use App\Models\FamilyMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FamilyMemberResource extends Resource
{
    protected static ?string $model = FamilyMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'العائلة والشجرة';

    protected static ?string $modelLabel = 'فرد';

    protected static ?string $pluralModelLabel = 'أفراد الشجرة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('parent_id')
                ->label('الأب في الشجرة')
                ->relationship('parent', 'full_name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\Select::make('family_branch_id')
                ->label('الفرع')
                ->relationship('branch', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\TextInput::make('full_name')->label('الاسم الكامل')->required()->maxLength(500),
            Forms\Components\TextInput::make('short_name')->label('الاسم المختصر في العقدة')->maxLength(120),
            Forms\Components\TextInput::make('role')->label('الصفة / المهنة')->maxLength(255),
            Forms\Components\TextInput::make('year_range')->label('سنوات (مثال: 1955 -)')->maxLength(120),
            Forms\Components\Textarea::make('bio')->label('نبذة')->rows(4),
            Forms\Components\TextInput::make('gender')->label('الجنس')->maxLength(20),
            Forms\Components\TextInput::make('sort_order')->label('الترتيب بين الإخوة')->numeric()->default(0),
            Forms\Components\TextInput::make('icon_key')->label('مفتاح أيقونة')->maxLength(60),
            Forms\Components\FileUpload::make('avatar')->label('صورة')->image()->disk('public')->directory('members'),
            Forms\Components\Toggle::make('is_public')->label('ظاهر للعامة / API')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('branch.name')->label('الفرع'),
                Tables\Columns\IconColumn::make('is_public')->label('عام')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('ترتيب')->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyMembers::route('/'),
            'create' => Pages\CreateFamilyMember::route('/create'),
            'edit' => Pages\EditFamilyMember::route('/{record}/edit'),
        ];
    }
}
