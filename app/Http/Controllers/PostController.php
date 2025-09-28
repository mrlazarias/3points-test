<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;

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
}
