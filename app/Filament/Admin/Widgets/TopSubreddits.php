<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\Subreddit;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

final class TopSubreddits extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Top 10 Comunidades por Atividade';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Subreddit::query()
                    ->withCount(['posts', 'followers'])
                    ->where('is_active', true)
                    ->orderBy('posts_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Comunidade')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('posts_count')
                    ->label('Posts')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('followers_count')
                    ->label('Seguidores')
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('creator.name')
                    ->label('Criador')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
