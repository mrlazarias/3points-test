<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $feedType = $request->get('feed', 'all'); // all, following

        $query = Post::query()
            ->with(['subreddit', 'user']);

        // Se o usuário está logado e quer ver posts de usuários seguidos
        if ($user && $feedType === 'following') {
            $followingIds = $user->following()->pluck('users.id');

            if ($followingIds->isNotEmpty()) {
                $query->whereIn('user_id', $followingIds);
            } else {
                // Se não está seguindo ninguém, mostrar mensagem
                $posts = collect();
                $subreddits = Subreddit::query()
                    ->where('is_active', true)
                    ->withCount('posts')
                    ->orderByDesc('posts_count')
                    ->limit(10)
                    ->get();

                return view('home', [
                    'posts' => $posts,
                    'subreddits' => $subreddits,
                    'feedType' => $feedType,
                    'isEmpty' => true,
                ]);
            }
        } else {
            // Posts de todos os usuários (feed padrão)
            $query->whereNotNull('subreddit_id');
        }

        $posts = $query
            ->with(['user', 'subreddit'])
            ->withCount('comments')
            ->orderByDesc('is_pinned')
            ->orderByDesc('vote_score')
            ->orderByDesc('created_at')
            ->paginate(20);

        // Adicionar informações de votação do usuário logado
        if (Auth::check()) {
            $userVotes = Auth::user()->votes()
                ->whereIn('voteable_id', $posts->pluck('id'))
                ->where('voteable_type', Post::class)
                ->get()
                ->keyBy('voteable_id');

            $posts->getCollection()->transform(function ($post) use ($userVotes): Post {
                $vote = $userVotes->get($post->id);
                $post->user_vote_type = $vote ? $vote->vote_type : null;

                return $post;
            });
        }

        $subreddits = Subreddit::query()
            ->where('is_active', true)
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(10)
            ->get();

        return view('home', [
            'posts' => $posts,
            'subreddits' => $subreddits,
            'feedType' => $feedType,
            'isEmpty' => false,
        ]);
    }
}
