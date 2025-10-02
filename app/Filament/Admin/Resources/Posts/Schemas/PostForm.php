<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Schemas;

use App\Models\Subreddit;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subreddit_id')
                    ->label('Subreddit')
                    ->required()
                    ->searchable()
                    ->options(Subreddit::query()->where('is_active', true)->pluck('name', 'id'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => 'r/' . $record->slug),

                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null
                    ),

                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                    ->helperText('Usado na URL do post'),

                Select::make('type')
                    ->label('Tipo')
                    ->required()
                    ->options([
                        'text' => 'Texto',
                        'link' => 'Link',
                        'image' => 'Imagem',
                    ])
                    ->default('text')
                    ->live(),

                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->visible(fn (callable $get) => in_array($get('type'), ['link', 'image']))
                    ->required(fn (callable $get) => in_array($get('type'), ['link', 'image'])),

                MarkdownEditor::make('content')
                    ->label('Conteúdo')
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

                Toggle::make('is_pinned')
                    ->label('Fixado')
                    ->helperText('Posts fixados aparecem no topo'),

                Toggle::make('is_locked')
                    ->label('Bloqueado')
                    ->helperText('Posts bloqueados não permitem novos comentários'),

                Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }
}
