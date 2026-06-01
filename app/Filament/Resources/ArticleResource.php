<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'مقال';

    protected static ?string $pluralModelLabel = 'المقالات';

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
                    ->directory('articles')
                    ->visibility('public'),
                Forms\Components\DateTimePicker::make('published_at')->label('تاريخ النشر')->default(now()),
                Forms\Components\TextInput::make('category')->label('التصنيف')->maxLength(120),
                Forms\Components\TagsInput::make('tags')->label('وسوم'),
                Forms\Components\Toggle::make('published')->label('منشور')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('category')->label('التصنيف'),
                Tables\Columns\IconColumn::make('published')->label('منشور')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('النشر')->dateTime()->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
