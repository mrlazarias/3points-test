<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
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
    }
}
