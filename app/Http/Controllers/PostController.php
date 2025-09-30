<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\NewPostCreated;
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
    public function show(Subreddit $subreddit, Post $post, Request $request): View
    {
        // Verificar se o post pertence ao subreddit
        abort_if($post->subreddit_id !== $subreddit->id, 404);

        $post->load(['subreddit', 'user']);

        // Carregar contagem de posts do subreddit relacionado ao post
        $post->subreddit->loadCount('posts');

        // Parâmetro de ordenação dos comentários
        $sortBy = $request->get('sort', 'top'); // top, new, old

        $commentsQuery = Comment::query()
            ->with(['user', 'replies.user'])
            ->where('post_id', $post->id)
            ->whereNull('parent_id')
            ->where('is_deleted', false);

        // Aplicar ordenação baseada no parâmetro
        match ($sortBy) {
            'new' => $commentsQuery->orderByDesc('created_at'),
            'old' => $commentsQuery->orderBy('created_at'),
            default => $commentsQuery->orderByDesc('vote_score')->orderByDesc('created_at'),
        };

        $comments = $commentsQuery->get();

        // Adicionar informações de permissão para cada comentário
        $comments->each(function ($comment): void {
            $comment->can_delete = $comment->canBeDeletedBy(Auth::user());
            $comment->can_reply = $comment->canBeRepliedToBy(Auth::user());

            // Aplicar recursivamente para respostas
            $this->addPermissionsToReplies($comment->replies);
        });

        return view('post.show', [
            'post' => $post,
            'comments' => $comments,
            'sortBy' => $sortBy,
        ]);
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
            'likes_count' => 0,
            'dislikes_count' => 0,
            'comment_count' => 0,
        ]);

        // Carregar relacionamentos necessários
        $post->load(['user', 'subreddit']);

        // Disparar evento de notificação para seguidores
        broadcast(new NewPostCreated(Auth::user(), $post));

        return redirect()
            ->route('post.show', ['subreddit' => $subreddit->slug, 'post' => $post->slug])
            ->with('success', 'Post criado com sucesso!');
    }

    /**
     * Adicionar permissões recursivamente para respostas de comentários
     */
    private function addPermissionsToReplies($replies): void
    {
        $replies->each(function ($reply): void {
            $reply->can_delete = $reply->canBeDeletedBy(Auth::user());
            $reply->can_reply = $reply->canBeRepliedToBy(Auth::user());

            if ($reply->replies->isNotEmpty()) {
                $this->addPermissionsToReplies($reply->replies);
            }
        });
    }
}
