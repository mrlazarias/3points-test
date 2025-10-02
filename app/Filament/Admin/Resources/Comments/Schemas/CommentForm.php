<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Comments\Schemas;

use App\Models\Post;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

final class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('post_id')
                    ->label('Post')
                    ->required()
                    ->searchable()
                    ->options(Post::query()->pluck('title', 'id'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title),

                MarkdownEditor::make('content')
                    ->label('Comentário')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'codeBlock',
                    ])
                    ->helperText('Suporte completo ao Markdown'),

                Hidden::make('user_id')
                    ->default(auth()->id()),

                Hidden::make('parent_id')
                    ->default(null),

                Hidden::make('depth')
                    ->default(0),

                Hidden::make('vote_score')
                    ->default(0),

                Hidden::make('likes_count')
                    ->default(0),

                Hidden::make('dislikes_count')
                    ->default(0),
            ]);
    }
}
