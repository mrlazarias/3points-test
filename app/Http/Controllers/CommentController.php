<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:10000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        Comment::query()->create([
            'content' => $validated['content'],
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'vote_score' => 0,
            'depth' => 0,
            'is_deleted' => false,
        ]);

        return redirect()
            ->route('post.show', ['subreddit' => $post->subreddit->slug, 'post' => $post->slug])
            ->with('success', 'Comentário adicionado com sucesso!');
    }

    public function reply(Request $request, Comment $comment): RedirectResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:10000'],
        ]);

        Comment::query()->create([
            'content' => $validated['content'],
            'post_id' => $comment->post_id,
            'user_id' => Auth::id(),
            'parent_id' => $comment->id,
            'vote_score' => 0,
            'depth' => $comment->depth + 1,
            'is_deleted' => false,
        ]);

        return redirect()
            ->route('post.show', ['subreddit' => $comment->post->subreddit->slug, 'post' => $comment->post->slug])
            ->with('success', 'Resposta adicionada com sucesso!');
    }
}
