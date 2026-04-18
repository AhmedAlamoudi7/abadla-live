<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArchiveSubmissionResource\Pages;
use App\Models\ArchiveSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArchiveSubmissionResource extends Resource
{
    protected static ?string $model = ArchiveSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'التفاعل والرسائل';

    protected static ?string $modelLabel = 'طلب أرشيف';

    protected static ?string $pluralModelLabel = 'طلبات أضف بياناتك';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('type')->label('النوع')->disabled(),
            Forms\Components\TextInput::make('full_name')->label('الاسم')->disabled(),
            Forms\Components\TextInput::make('phone_country')->label('رمز الدولة')->disabled(),
            Forms\Components\TextInput::make('phone_number')->label('الجوال')->disabled(),
            Forms\Components\TextInput::make('email')->label('البريد')->disabled(),
            Forms\Components\Select::make('status')
                ->label('الحالة')
                ->options([
                    'pending' => 'قيد المراجعة',
                    'approved' => 'مقبول',
                    'rejected' => 'مرفوض',
                ])
                ->required(),
            Forms\Components\Textarea::make('admin_notes')->label('ملاحظات الإدارة')->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('النوع'),
                Tables\Columns\TextColumn::make('status')->label('الحالة')->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('الاستلام')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchiveSubmissions::route('/'),
            'edit' => Pages\EditArchiveSubmission::route('/{record}/edit'),
        ];
    }
}
