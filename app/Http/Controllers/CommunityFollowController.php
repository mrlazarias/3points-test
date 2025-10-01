<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Subreddit;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class CommunityFollowController extends Controller
{
    /**
     * Seguir uma comunidade
     */
    public function store(Subreddit $subreddit): JsonResponse
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado',
            ], 401);
        }

        $followed = $subreddit->follow($user);

        if (! $followed) {
            return response()->json([
                'success' => false,
                'message' => 'Você já está seguindo esta comunidade',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Comunidade seguida com sucesso!',
            'followers_count' => $subreddit->followersCount(),
            'is_following' => true,
        ]);
    }

    /**
     * Deixar de seguir uma comunidade
     */
    public function destroy(Subreddit $subreddit): JsonResponse
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado',
            ], 401);
        }

        $unfollowed = $subreddit->unfollow($user);

        if (! $unfollowed) {
            return response()->json([
                'success' => false,
                'message' => 'Você não está seguindo esta comunidade',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Comunidade deixada de seguir com sucesso!',
            'followers_count' => $subreddit->followersCount(),
            'is_following' => false,
        ]);
    }

    /**
     * Verificar se o usuário está seguindo uma comunidade
     */
    public function show(Subreddit $subreddit): JsonResponse
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'is_following' => $subreddit->isFollowedBy($user),
            'followers_count' => $subreddit->followersCount(),
        ]);
    }
}
