<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\UserRelationManager;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use League\CommonMark\Input\MarkdownInput;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make(
                    [
                        TextInput::make('title')->required(),
                        TextInput::make('image'),
                        MarkdownEditor::make('body')->required(),
                        Select::make('user_id')->relationship('user', 'name')->preload()->required(),
                        MultiSelect::make('category_id')->relationship('categories', 'title')->preload()->required(),

                    ]
                )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
            TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('body')->sortable()->searchable(),
                TextColumn::make('image')->sortable()->searchable(),
                TextColumn::make('user_id'),
                TagsColumn::make('category_id')->separator(','),
                TextColumn::make('updated_at')->sortable()->searchable()->dateTime('D-M-Y  h:m:s'),
                TextColumn::make('created_at')->sortable()->searchable()->dateTime('D-M-Y  h:m:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
            UserRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
