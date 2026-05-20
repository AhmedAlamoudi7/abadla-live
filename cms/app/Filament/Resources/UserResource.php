<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'الصلاحيات';

    protected static ?string $modelLabel = 'مستخدم';

    protected static ?string $pluralModelLabel = 'المستخدمون';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('الاسم')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            Forms\Components\TextInput::make('password')
                ->label('كلمة المرور')
                ->password()
                ->revealable()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $operation): bool => $operation === 'create')
                ->minLength(8)
                ->helperText('اتركها فارغة عند التعديل للإبقاء على كلمة المرور الحالية.'),
            Forms\Components\Select::make('roles')
                ->label('الأدوار')
                ->multiple()
                ->relationship('roles', 'name')
                ->options(fn () => Role::query()->pluck('name', 'id'))
                ->preload()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('الأدوار')
                    ->badge()
                    ->separator(','),
                Tables\Columns\TextColumn::make('created_at')->label('أُنشئ')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->label('دور')
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
