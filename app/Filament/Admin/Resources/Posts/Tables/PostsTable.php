<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Tables;

use App\Filament\Admin\Resources\Posts\Actions\BulkPinAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->title),

                TextColumn::make('subreddit.name')
                    ->label('Subreddit')
                    ->badge()
                    ->prefix('r/')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'info',
                        'link' => 'success',
                        'image' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('user.name')
                    ->label('Autor')
                    ->sortable(),

                TextColumn::make('vote_score')
                    ->label('Score')
                    ->sortable()
                    ->color(fn ($record): string => match (true) {
                        $record->vote_score > 0 => 'success',
                        $record->vote_score < 0 => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('comment_count')
                    ->label('Comentários')
                    ->sortable(),

                IconColumn::make('is_pinned')
                    ->label('Fixado')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_locked')
                    ->label('Bloqueado')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'text' => 'Texto',
                        'link' => 'Link',
                        'image' => 'Imagem',
                    ]),

                SelectFilter::make('subreddit_id')
                    ->label('Subreddit')
                    ->relationship('subreddit', 'name'),

                SelectFilter::make('is_pinned')
                    ->label('Status')
                    ->options([
                        1 => 'Fixado',
                        0 => 'Normal',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkPinAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
