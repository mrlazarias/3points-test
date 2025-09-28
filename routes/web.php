<?php

declare(strict_types=1);

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Models\Post;
use App\Models\Subreddit;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubredditController;
use Illuminate\Support\Facades\Route;

// Home - Lista todos os posts
Route::get('/', function (): View|Factory {
    $posts = Post::query()
        ->with(['subreddit', 'user'])
        ->whereNotNull('subreddit_id')
        ->orderByDesc('is_pinned')
        ->orderByDesc('vote_score')
        ->orderByDesc('created_at')
        ->paginate(20);

    $subreddits = Subreddit::query()
        ->where('is_active', true)
        ->withCount('posts')
        ->orderByDesc('posts_count')
        ->limit(10)
        ->get();

    return view('home', ['posts' => $posts, 'subreddits' => $subreddits]);
})->name('home');

// Rota de teste
Route::get('/test', fn () => 'Teste funcionando!');

// Subreddit - Posts de uma comunidade específica
Route::get('/r/{subreddit:slug}', [SubredditController::class, 'show'])->name('subreddit.show');

// Post - Visualização de um post específico
Route::get('/r/{subreddit:slug}/{post:slug}', [PostController::class, 'show'])->name('post.show');
