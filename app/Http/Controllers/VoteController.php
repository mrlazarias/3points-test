<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

final class VoteController extends Controller
{
    /**
     * Vota em um post ou comentário
     */
    public function vote(Request $request): JsonResponse
    {
        $request->validate([
            'voteable_type' => ['required', 'string', 'in:post,comment'],
            'voteable_id' => ['required', 'integer'],
            'vote_type' => ['required', 'string', 'in:up,down'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Buscar o modelo votável
        $voteable = match ($request->voteable_type) {
            'post' => Post::query()->findOrFail($request->voteable_id),
            'comment' => Comment::query()->findOrFail($request->voteable_id),
            default => throw new InvalidArgumentException('Tipo de votação inválido'),
        };

        // Verificar se o usuário já votou
        $existingVote = Vote::query()->where('user_id', $user->id)
            ->where('voteable_type', $voteable::class)
            ->where('voteable_id', $request->voteable_id)
            ->first();

        if ($existingVote) {
            // Se o voto é o mesmo, remover o voto
            if ($existingVote->vote_type === $request->vote_type) {
                $existingVote->delete();

                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'vote_score' => $voteable->fresh()->vote_score,
                ]);
            }

            // Se o voto é diferente, atualizar
            $existingVote->update(['vote_type' => $request->vote_type]);

            return response()->json([
                'success' => true,
                'action' => 'updated',
                'vote_type' => $request->vote_type,
                'vote_score' => $voteable->fresh()->vote_score,
            ]);
        }

        // Criar novo voto
        Vote::query()->create([
            'user_id' => $user->id,
            'voteable_type' => $voteable::class,
            'voteable_id' => $request->voteable_id,
            'vote_type' => $request->vote_type,
        ]);

        return response()->json([
            'success' => true,
            'action' => 'created',
            'vote_type' => $request->vote_type,
            'vote_score' => $voteable->fresh()->vote_score,
        ]);
    }

    /**
     * Remove o voto do usuário
     */
    public function removeVote(Request $request): JsonResponse
    {
        $request->validate([
            'voteable_type' => ['required', 'string', 'in:post,comment'],
            'voteable_id' => ['required', 'integer'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Buscar o modelo votável para obter o nome da classe
        $voteableClass = match ($request->voteable_type) {
            'post' => Post::class,
            'comment' => Comment::class,
            default => throw new InvalidArgumentException('Tipo de votação inválido'),
        };

        $vote = Vote::query()->where('user_id', $user->id)
            ->where('voteable_type', $voteableClass)
            ->where('voteable_id', $request->voteable_id)
            ->first();

        if (! $vote) {
            return response()->json([
                'success' => false,
                'message' => 'Voto não encontrado',
            ], 404);
        }

        $voteable = $vote->voteable;
        $vote->delete();

        return response()->json([
            'success' => true,
            'action' => 'removed',
            'vote_score' => $voteable->fresh()->vote_score,
        ]);
    }

    /**
     * Obtém o voto do usuário para um item específico
     */
    public function getUserVote(Request $request): JsonResponse
    {
        $request->validate([
            'voteable_type' => ['required', 'string', 'in:post,comment'],
            'voteable_id' => ['required', 'integer'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Buscar o modelo votável para obter o nome da classe
        $voteableClass = match ($request->voteable_type) {
            'post' => Post::class,
            'comment' => Comment::class,
            default => throw new InvalidArgumentException('Tipo de votação inválido'),
        };

        $vote = Vote::query()->where('user_id', $user->id)
            ->where('voteable_type', $voteableClass)
            ->where('voteable_id', $request->voteable_id)
            ->first();

        return response()->json([
            'success' => true,
            'vote' => $vote ? [
                'id' => $vote->id,
                'vote_type' => $vote->vote_type,
            ] : null,
        ]);
    }
}
