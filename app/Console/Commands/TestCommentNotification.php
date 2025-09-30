<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\CommentNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;

final class TestCommentNotification extends Command
{
    protected $signature = 'test:comment-notification {post_id} {commenter_id}';

    protected $description = 'Test comment notification event';

    public function handle(): int
    {
        $postId = (int) $this->argument('post_id');
        $commenterId = (int) $this->argument('commenter_id');

        $post = Post::with('subreddit')->findOrFail($postId);
        $commenter = User::query()->findOrFail($commenterId);
        $comment = Comment::with('user')->where('post_id', $postId)->first();

        if (! $comment) {
            $this->error('No comment found for post '.$postId);

            return 1;
        }

        $this->info('Testing comment notification...');
        $this->info('Post: '.$post->title);
        $this->info('Post Owner: '.$post->user_id);
        $this->info('Commenter: '.$commenter->name.' (ID: '.$commenter->id.')');

        broadcast(new CommentNotification($commenter, $post, $comment));

        $this->info('Comment notification broadcasted!');

        return 0;
    }
}
