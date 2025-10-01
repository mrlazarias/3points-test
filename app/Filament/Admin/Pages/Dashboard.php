<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\PostsChart;
use App\Filament\Admin\Widgets\StatsOverview;
use App\Filament\Admin\Widgets\TopSubreddits;
use Filament\Pages\Dashboard as BaseDashboard;

final class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            PostsChart::class,
            TopSubreddits::class,
        ];
    }

    public function getColumns(): int
    {
        return 2;
    }
}
