<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

final class SubredditController extends Controller
{
    public function show(Subreddit $subreddit): View
    {
        $posts = Post::query()
            ->with(['user'])
            ->where('subreddit_id', $subreddit->id)
            ->orderByDesc('is_pinned')
            ->orderByDesc('vote_score')
            ->orderByDesc('created_at')
            ->paginate(20);

        // Carregar informações de follow se usuário estiver logado
        $isFollowing = false;
        $followersCount = 0;

        if (Auth::check()) {
            $isFollowing = $subreddit->isFollowedBy(Auth::user());
            $followersCount = $subreddit->followersCount();
        } else {
            $followersCount = $subreddit->followersCount();
        }

        return view('subreddit.show', [
            'subreddit' => $subreddit,
            'posts' => $posts,
            'isFollowing' => $isFollowing,
            'followersCount' => $followersCount,
        ]);
    }

    /**
     * Exibe o formulário para criar uma nova comunidade
     */
    public function create(): View
    {
        return view('subreddit.create');
    }

    /**
     * Armazena uma nova comunidade no banco de dados
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:subreddits,name'],
            'description' => ['required', 'string', 'max:500'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        // Gerar slug único se necessário
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;

        while (Subreddit::query()->where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $subreddit = Subreddit::query()->create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'color' => $validated['color'],
            'created_by' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()
            ->route('subreddit.show', $subreddit)
            ->with('success', 'Comunidade criada com sucesso!');
    }
}
