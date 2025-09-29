<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class PostController extends Controller
{
    public function show(Subreddit $subreddit, Post $post): View
    {
        // Verificar se o post pertence ao subreddit
        abort_if($post->subreddit_id !== $subreddit->id, 404);

        $post->load(['subreddit', 'user']);

        $comments = Comment::query()
            ->with(['user', 'replies.user'])
            ->where('post_id', $post->id)
            ->whereNull('parent_id')
            ->where('is_deleted', false)
            ->orderByDesc('vote_score')
            ->orderByDesc('created_at')
            ->get();

        return view('post.show', ['post' => $post, 'comments' => $comments]);
    }

    public function create(Subreddit $subreddit): View
    {
        return view('post.create', ['subreddit' => $subreddit]);
    }

    public function store(Request $request, Subreddit $subreddit): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['text', 'link', 'image'])],
            'content' => ['required_if:type,text', 'nullable', 'string'],
            'url' => ['required_if:type,link,image', 'nullable', 'url'],
        ]);

        $post = Post::query()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'type' => $validated['type'],
            'content' => $validated['content'] ?? null,
            'url' => $validated['url'] ?? null,
            'subreddit_id' => $subreddit->id,
            'user_id' => Auth::id(),
            'vote_score' => 0,
            'comment_count' => 0,
        ]);

        return redirect()
            ->route('post.show', ['subreddit' => $subreddit->slug, 'post' => $post->slug])
            ->with('success', 'Post criado com sucesso!');
    }
}
