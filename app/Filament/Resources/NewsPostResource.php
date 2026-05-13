<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsPostResource\Pages;
use App\Models\NewsPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsPostResource extends Resource
{
    protected static ?string $model = NewsPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?string $modelLabel = 'خبر';

    protected static ?string $pluralModelLabel = 'أخبار العائلة';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('العنوان')
                    ->required()
                    ->maxLength(500),
                Forms\Components\TextInput::make('slug')
                    ->label('المسار')
                    ->required()
                    ->maxLength(500)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('excerpt')->label('المقدمة')->rows(3),
                Forms\Components\RichEditor::make('body')->label('المحتوى')->columnSpanFull(),
                Forms\Components\FileUpload::make('featured_image')
                    ->label('صورة مميزة')
                    ->image()
                    ->disk('public')
                    ->directory('news')
                    ->visibility('public'),
                Forms\Components\DateTimePicker::make('published_at')->label('تاريخ النشر')->default(now()),
                Forms\Components\Select::make('type')
                    ->label('نوع المنشور')
                    ->options([
                        NewsPost::TYPE_NEWS => 'خبر',
                        NewsPost::TYPE_ARTICLE => 'مقال',
                    ])
                    ->default(NewsPost::TYPE_NEWS)
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('category')->label('التصنيف')->maxLength(120),
                Forms\Components\TagsInput::make('tags')->label('وسوم'),
                Forms\Components\Toggle::make('is_breaking')->label('خبر عاجل'),
                Forms\Components\Toggle::make('show_on_home')->label('يظهر في الرئيسية'),
                Forms\Components\Toggle::make('is_hourly_featured')->label('أخبار الساعة'),
                Forms\Components\TextInput::make('layout_role')->label('دور التخطيط (banner/list/...)')->maxLength(60),
                Forms\Components\TextInput::make('mosaic_slot')->label('موضع الموزاييك')->maxLength(60),
                Forms\Components\TextInput::make('important_sort')->label('ترتيب أهم الأخبار')->numeric()->default(0),
                Forms\Components\Toggle::make('published')->label('منشور')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn (?string $state): string => $state === NewsPost::TYPE_ARTICLE ? 'مقال' : 'خبر')
                    ->badge()
                    ->color(fn (?string $state): string => $state === NewsPost::TYPE_ARTICLE ? 'info' : 'gray'),
                Tables\Columns\TextColumn::make('category')->label('التصنيف'),
                Tables\Columns\IconColumn::make('published')->label('منشور')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('النشر')->dateTime()->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        NewsPost::TYPE_NEWS => 'خبر',
                        NewsPost::TYPE_ARTICLE => 'مقال',
                    ]),
                Tables\Filters\TernaryFilter::make('published')->label('منشور'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsPosts::route('/'),
            'create' => Pages\CreateNewsPost::route('/create'),
            'edit' => Pages\EditNewsPost::route('/{record}/edit'),
        ];
    }
}
