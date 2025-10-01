<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Events\CommentDeleted;
use App\Events\CommentNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class CommentController extends Controller
{
    public function index(Request $request, Post $post): JsonResponse
    {
        $comments = $post->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'comments' => $comments,
        ]);
    }

    public function store(Request $request, Subreddit $subreddit, Post $post): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:10000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        $comment = Comment::query()->create([
            'content' => $validated['content'],
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'vote_score' => 0,
            'likes_count' => 0,
            'dislikes_count' => 0,
            'depth' => 0,
            'is_deleted' => false,
        ]);

        $comment->load('user');

        $post->load('subreddit');

        $post->updateCommentCount();

        broadcast(new CommentCreated($comment, $post));

        // Disparar notificação para o dono do post
        broadcast(new CommentNotification(Auth::user(), $post, $comment));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comentário adicionado com sucesso!',
                'comment_count' => $post->fresh()->comment_count,
            ]);
        }

        return redirect()
            ->route('post.show', ['subreddit' => $post->subreddit->slug, 'post' => $post->slug])
            ->with('success', 'Comentário adicionado com sucesso!')
            ->with('commented', true);
    }

    public function create(Request $request, Comment $comment): RedirectResponse|JsonResponse
    {
        // Verificar se o usuário pode responder ao comentário
        abort_if(! $comment->canBeRepliedToBy(Auth::user()), 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:10000'],
        ]);

        $reply = Comment::query()->create([
            'content' => $validated['content'],
            'post_id' => $comment->post_id,
            'user_id' => Auth::id(),
            'parent_id' => $comment->id,
            'vote_score' => 0,
            'likes_count' => 0,
            'dislikes_count' => 0,
            'depth' => $comment->depth + 1,
            'is_deleted' => false,
        ]);

        // Carregar relacionamentos para o broadcast
        $reply->load('user');

        // Atualizar contador de comentários do post
        $comment->post->updateCommentCount();

        // Disparar evento de broadcast
        broadcast(new CommentCreated($reply, $comment->post));

        // Se for requisição AJAX, retornar JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Resposta adicionada com sucesso!',
                'comment_count' => $comment->post->fresh()->comment_count,
            ]);
        }

        return redirect()
            ->route('post.show', ['subreddit' => $comment->post->subreddit->slug, 'post' => $comment->post->slug])
            ->with('success', 'Resposta adicionada com sucesso!')
            ->with('commented', true);
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        // Verificar se o usuário é o dono do comentário
        abort_if($comment->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:10000'],
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('post.show', ['subreddit' => $comment->post->subreddit->slug, 'post' => $comment->post->slug])
            ->with('success', 'Comentário atualizado com sucesso!');
    }

    public function destroy(Request $request, Comment $comment): RedirectResponse|JsonResponse
    {
        // Verificar se o usuário pode deletar o comentário
        abort_if(! $comment->canBeDeletedBy(Auth::user()), 403);

        // Soft delete para manter a thread
        $comment->softDelete();

        // Atualizar contador de comentários do post
        $comment->post->updateCommentCount();

        // Disparar evento de broadcast
        broadcast(new CommentDeleted($comment, $comment->post));

        // Se for requisição AJAX, retornar JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comentário excluído com sucesso!',
                'comment_count' => $comment->post->fresh()->comment_count,
            ]);
        }

        return redirect()
            ->route('post.show', ['subreddit' => $comment->post->subreddit->slug, 'post' => $comment->post->slug])
            ->with('success', 'Comentário excluído com sucesso!');
    }
}
