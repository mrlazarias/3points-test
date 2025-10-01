<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Comments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label('Comentário')
                    ->limit(100)
                    ->tooltip(fn ($record) => $record->content)
                    ->html(),

                TextColumn::make('post.title')
                    ->label('Post')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->post->title)
                    ->sortable(),

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

                TextColumn::make('replies_count')
                    ->label('Respostas')
                    ->counts('replies')
                    ->sortable(),

                IconColumn::make('is_deleted')
                    ->label('Deletado')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('post_id')
                    ->label('Post')
                    ->relationship('post', 'title'),

                SelectFilter::make('is_deleted')
                    ->label('Status')
                    ->options([
                        0 => 'Ativo',
                        1 => 'Deletado',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
