<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\CommentDeleted;
use App\Models\Post;
use Illuminate\Console\Command;

final class TestCommentDeletion extends Command
{
    protected $signature = 'test:comment-deletion {post_id}';

    protected $description = 'Testa a remoção de comentários com broadcast';

    public function handle(): int
    {
        $postId = $this->argument('post_id');
        $post = Post::query()->findOrFail($postId);

        $this->info('Testing comment deletion for post: ' . $post->title);

        // Buscar um comentário para deletar
        $comment = $post->comments()->first();

        if (! $comment) {
            $this->error('No comments found to delete');

            return 1;
        }

        $this->info('Deleting comment ID: ' . $comment->id);
        $this->info('Comment content: ' . $comment->content);

        // Deletar o comentário
        $comment->delete();

        // Atualizar contador do post
        $post->updateCommentCount();

        // Disparar evento de broadcast
        broadcast(new CommentDeleted($comment, $post));

        $this->info('Comment deleted and broadcast sent!');
        $this->info('New comment count: ' . $post->fresh()->comment_count);

        return 0;
    }
}
