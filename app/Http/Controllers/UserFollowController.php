<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Events\UserFollowed;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final class UserFollowController extends Controller
{
    public function follow(User $user): JsonResponse|RedirectResponse
    {
        $currentUser = Auth::user();

        if (! $currentUser) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }

            return redirect()->route('login');
        }

        if ($currentUser->id === $user->id) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Você não pode seguir a si mesmo'], 400);
            }

            return back()->with('error', 'Você não pode seguir a si mesmo');
        }

        $success = $currentUser->follow($user);

        if (! $success) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Já está seguindo este usuário'], 400);
            }

            return back()->with('error', 'Já está seguindo este usuário');
        }

        // Disparar evento de notificação
        broadcast(new UserFollowed($currentUser, $user));

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Agora você está seguindo ' . $user->getDisplayName(),
                'followers_count' => $user->followers()->count(),
            ]);
        }

        return back()->with('success', 'Agora você está seguindo ' . $user->getDisplayName());
    }

    public function unfollow(User $user): JsonResponse|RedirectResponse
    {
        $currentUser = Auth::user();

        if (! $currentUser) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }

            return redirect()->route('login');
        }

        $success = $currentUser->unfollow($user);

        if (! $success) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Você não está seguindo este usuário'], 400);
            }

            return back()->with('error', 'Você não está seguindo este usuário');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Você parou de seguir ' . $user->getDisplayName(),
                'followers_count' => $user->followers()->count(),
            ]);
        }

        return back()->with('success', 'Você parou de seguir ' . $user->getDisplayName());
    }

    public function followers(User $user): View|Factory
    {
        $followers = $user->followers()->with('media')->paginate(20);

        return view('profile.followers', ['user' => $user, 'followers' => $followers]);
    }

    public function following(User $user): View|Factory
    {
        $following = $user->following()->with('media')->paginate(20);

        return view('profile.following', ['user' => $user, 'following' => $following]);
    }
}
