<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;

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

        return view('subreddit.show', ['subreddit' => $subreddit, 'posts' => $posts]);
    }
}
