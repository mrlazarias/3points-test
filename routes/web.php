<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityFollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubredditController;
use App\Http\Controllers\VoteController;
use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

// Home - Lista posts das comunidades seguidas (ou todos se não logado)
Route::get('/', function (): View|Factory {
    $user = auth()->user();

    if ($user) {
        // Se logado, mostrar apenas posts das comunidades que o usuário segue
        $followedCommunityIds = $user->followedCommunities()->pluck('subreddits.id');

        if ($followedCommunityIds->isNotEmpty()) {
            $posts = Post::query()
                ->with(['subreddit', 'user'])
                ->whereIn('subreddit_id', $followedCommunityIds)
                ->orderByDesc('is_pinned')
                ->orderByDesc('vote_score')
                ->orderByDesc('created_at')
                ->paginate(20);
        } else {
            // Se não segue nenhuma comunidade, mostrar posts vazios com mensagem
            $posts = Post::query()
                ->with(['subreddit', 'user'])
                ->whereRaw('1 = 0') // Query que nunca retorna resultados
                ->orderByDesc('is_pinned')
                ->orderByDesc('vote_score')
                ->orderByDesc('created_at')
                ->paginate(20);
        }
    } else {
        // Se não logado, mostrar todos os posts
        $posts = Post::query()
            ->with(['subreddit', 'user'])
            ->whereNotNull('subreddit_id')
            ->orderByDesc('is_pinned')
            ->orderByDesc('vote_score')
            ->orderByDesc('created_at')
            ->paginate(20);
    }

    // Carregar comunidades para a sidebar
    if ($user) {
        // Se logado, mostrar apenas comunidades que o usuário criou ou segue
        $subreddits = Subreddit::query()
            ->where('is_active', true)
            ->where(function ($query) use ($user): void {
                $query->where('created_by', $user->id)
                    ->orWhereHas('followers', function ($followQuery) use ($user): void {
                        $followQuery->where('user_id', $user->id);
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

    // Carregar comunidades sugeridas (aleatórias)
    $suggestedSubreddits = Subreddit::query()
        ->where('is_active', true)
        ->withCount(['posts', 'followers'])
        ->inRandomOrder()
        ->limit(5)
        ->get();

    return view('home', [
        'posts' => $posts,
        'subreddits' => $subreddits,
        'suggestedSubreddits' => $suggestedSubreddits,
    ]);
})->name('home');

// Rota para buscar sugestões de comunidades (AJAX)
Route::get('/suggested-communities', function () {
    $suggestedSubreddits = Subreddit::query()
        ->where('is_active', true)
        ->withCount(['posts', 'followers'])
        ->inRandomOrder()
        ->limit(5)
        ->get();

    return response()->json([
        'suggestedSubreddits' => $suggestedSubreddits,
    ]);
});

// Rota de teste
Route::get('/test', fn () => 'Teste funcionando!');

// Rota de teste para criação de posts
Route::get('/test-create', function (): Factory|View {
    $subreddit = Subreddit::query()->where('slug', 'laravel')->first();

    return view('post.create', ['subreddit' => $subreddit]);
});

// Subreddit - Posts de uma comunidade específica
Route::get('/r/{subreddit:slug}', [SubredditController::class, 'show'])->name('subreddit.show');

// Criação de comunidades (protegida por autenticação)
Route::middleware('auth')->group(function (): void {
    Route::get('/create-community', [SubredditController::class, 'create'])->name('subreddit.create');
    Route::post('/create-community', [SubredditController::class, 'store'])->name('subreddit.store');
});

// Criação de posts (protegida por autenticação)
Route::get('/r/{subreddit:slug}/create', [PostController::class, 'create'])->name('post.create');
Route::post('/r/{subreddit:slug}/create', [PostController::class, 'store'])->name('post.store');

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

    // Rotas de Votação
    Route::post('/vote', [VoteController::class, 'vote'])->name('vote');
    Route::delete('/vote', [VoteController::class, 'removeVote'])->name('vote.remove');
    Route::get('/vote/user', [VoteController::class, 'getUserVote'])->name('vote.user');

    // Rotas de Comentários
    Route::get('/posts/{subreddit:slug}/{post:slug}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/posts/{subreddit:slug}/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Rotas de Follow de Comunidades
    Route::post('/communities/{subreddit:slug}/follow', [CommunityFollowController::class, 'follow'])->name('communities.follow');
    Route::delete('/communities/{subreddit:slug}/follow', [CommunityFollowController::class, 'unfollow'])->name('communities.unfollow');
    Route::get('/communities/{subreddit:slug}/follow-status', [CommunityFollowController::class, 'check'])->name('communities.follow-status');
});
