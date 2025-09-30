<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Subreddit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Composer para o layout app - sempre disponibilizar $subreddits
        View::composer('layouts.app', function ($view): void {
            $subreddits = collect();

            if (Auth::check()) {
                // Se usuário logado, mostrar comunidades que ele segue ou criou
                $subreddits = Subreddit::query()
                    ->where('is_active', true)
                    ->where(function ($query): void {
                        $query->where('created_by', Auth::id())
                            ->orWhereHas('followers', function ($followQuery): void {
                                $followQuery->where('user_id', Auth::id());
                            });
                    })
                    ->withCount(['posts', 'followers'])
                    ->orderByDesc('posts_count')
                    ->limit(10)
                    ->get();
            } else {
                // Se não logado, mostrar as mais populares
                $subreddits = Subreddit::query()
                    ->where('is_active', true)
                    ->withCount(['posts', 'followers'])
                    ->orderByDesc('posts_count')
                    ->limit(10)
                    ->get();
            }

            $view->with('subreddits', $subreddits);
        });
    }
}
