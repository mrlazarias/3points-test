<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

final class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Usuários', User::query()->count())
                ->description('Usuários registrados')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Comunidades Ativas', Subreddit::query()->where('is_active', true)->count())
                ->description('Subreddits ativos')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('info')
                ->chart([3, 7, 2, 8, 4, 6, 3, 5]),

            Stat::make('Posts Publicados', Post::query()->count())
                ->description('Total de posts')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('warning')
                ->chart([2, 4, 6, 8, 3, 5, 7, 4]),

            Stat::make('Comentários', Comment::query()->count())
                ->description('Interações da comunidade')
                ->descriptionIcon('heroicon-o-chat-bubble-left-right')
                ->color('primary')
                ->chart([5, 3, 8, 2, 6, 4, 7, 3]),
        ];
    }
}
