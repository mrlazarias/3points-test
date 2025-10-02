<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\CommentCreated;
use App\Events\CommentNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;

final class TestBroadcastingCommand extends Command
{
    protected $signature = 'test:broadcasting {post_id}';

    protected $description = 'Test broadcasting by creating a test comment';

    public function handle(): int
    {
        $postId = $this->argument('post_id');

        $post = Post::query()->find($postId);
        if (! $post) {
            $this->error(sprintf('Post with ID %s not found', $postId));

            return 1;
        }

        $user = User::query()->first();
        if (! $user) {
            $this->error('No users found in database');

            return 1;
        }

        $this->info('Testing broadcasting for post: '.$post->title);
        $this->info('Using user: '.$user->name);

        // Criar um comentário de teste
        $comment = Comment::query()->create([
            'content' => 'Comentário de teste para broadcasting - '.now(),
            'post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => null,
            'vote_score' => 0,
            'depth' => 0,
            'is_deleted' => false,
        ]);

        $comment->load('user');

        $post->load('subreddit');

        $this->info('Comment created with ID: '.$comment->id);

        // Disparar eventos
        $this->info('Broadcasting CommentCreated event...');
        broadcast(new CommentCreated($comment, $post));

        $this->info('Broadcasting CommentNotification event...');
        broadcast(new CommentNotification($user, $post, $comment));

        $this->info('Broadcast completed. Check logs for details.');

        return 0;
    }
}
