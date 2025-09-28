<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Subreddits\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

final class SubredditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
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
                    ->helperText('Usado na URL. Ex: r/meu-subreddit'),

                Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(1000)
                    ->rows(3)
                    ->helperText('Descreva o propósito desta comunidade'),

                ColorPicker::make('color')
                    ->label('Cor do tema')
                    ->default('#0ea5e9')
                    ->helperText('Cor principal da comunidade'),

                Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true)
                    ->helperText('Comunidades inativas não aparecem para usuários'),

                Hidden::make('created_by')
                    ->default(auth()->id()),
            ]);
    }
}
