<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubredditController;
use Illuminate\Support\Facades\Route;

// Home - Lista todos os posts
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rota de teste
Route::get('/test', fn () => 'Teste funcionando!');

// Subreddit - Posts de uma comunidade específica
Route::get('/r/{subreddit:slug}', [SubredditController::class, 'show'])->name('subreddit.show');

// Post - Visualização de um post específico
Route::get('/r/{subreddit:slug}/{post:slug}', [PostController::class, 'show'])->name('post.show');
