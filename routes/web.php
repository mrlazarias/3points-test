<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubredditController;
use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas de Perfil (protegidas por autenticação)
Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
    Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.remove-photo');
});
