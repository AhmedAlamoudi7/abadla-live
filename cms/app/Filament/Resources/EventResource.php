<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'فعالية';

    protected static ?string $pluralModelLabel = 'الفعاليات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('العنوان')->required()->maxLength(500),
                Forms\Components\TextInput::make('slug')->label('المسار')->required()->unique(ignoreRecord: true)->maxLength(500),
                Forms\Components\Textarea::make('description')->label('وصف مختصر')->rows(3),
                Forms\Components\DateTimePicker::make('starts_at')->label('البداية'),
                Forms\Components\DateTimePicker::make('ends_at')->label('النهاية'),
                Forms\Components\TextInput::make('location')->label('المكان')->maxLength(500),
                Forms\Components\FileUpload::make('cover_image')->label('صورة الغلاف')->image()->disk('public')->directory('events'),
                Forms\Components\RichEditor::make('body')->label('تفاصيل')->columnSpanFull(),
                Forms\Components\TextInput::make('detail_url')->label('رابط تفاصيل خارجي')->url()->maxLength(500),
                Forms\Components\Toggle::make('is_published')->label('منشور')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('starts_at')->label('البداية')->dateTime()->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
