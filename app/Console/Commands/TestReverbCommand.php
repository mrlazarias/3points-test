<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\CommentCreated;
use App\Events\SimpleTestEvent;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;

final class TestReverbCommand extends Command
{
    protected $signature = 'test:reverb';

    protected $description = 'Testa o Reverb com evento simples';

    public function handle(): int
    {
        $this->info('Testando Reverb...');

        // Teste 1: Evento simples
        $this->info('Enviando evento simples...');
        broadcast(new SimpleTestEvent('TESTE REVERB - '.now()));

        // Teste 2: Evento de comentário
        $this->info('Enviando evento de comentário...');
        $post = Post::query()->find(7);
        $user = User::query()->first();

        $comment = Comment::query()->create([
            'content' => 'TESTE REVERB COMENTÁRIO - '.now(),
            'post_id' => $post->id,
            'user_id' => $user->id,
            'parent_id' => null,
            'vote_score' => 0,
            'depth' => 0,
            'is_deleted' => false,
        ]);

        $comment->load('user');

        $post->updateCommentCount();

        broadcast(new CommentCreated($comment, $post));

        $this->info('Eventos enviados! Verifique o console do navegador.');

        return 0;
    }
}
