<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class ProfileController extends Controller
{
    /**
     * Faz upload da foto de perfil
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user->addMediaFromRequest('photo')
            ->toMediaCollection('profile-pictures');

        return redirect()->route('profile.show')
            ->with('success', 'Foto de perfil atualizada com sucesso!');
    }

    /**
     * Mostra a página de perfil do usuário logado
     */
    public function show(): View
    {
        $user = Auth::user();

        // Buscar posts do usuário
        $posts = Post::query()
            ->with(['subreddit'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        // Buscar comunidades seguidas
        $followedCommunities = Subreddit::query()
            ->whereHas('followers', function ($query) use ($user): void {
                $query->where('user_id', $user->id);
            })
            ->orderBy('name')
            ->get();

        // Buscar usuários seguidos
        $following = User::query()
            ->whereHas('followers', function ($query) use ($user): void {
                $query->where('follower_id', $user->id);
            })
            ->orderBy('name')
            ->get();

        // Buscar seguidores
        $followers = User::query()
            ->whereHas('following', function ($query) use ($user): void {
                $query->where('following_id', $user->id);
            })
            ->orderBy('name')
            ->get();

        return view('profile.show', ['user' => $user, 'posts' => $posts, 'followedCommunities' => $followedCommunities, 'following' => $following, 'followers' => $followers]);
    }

    /**
     * Mostra a página de perfil de outro usuário
     */
    public function index(string $username): View
    {
        $user = User::query()->where('username', $username)->firstOrFail();
        $currentUser = Auth::user();
        $isOwnProfile = $currentUser && $currentUser->id === $user->id;

        // Se for o próprio perfil, redirecionar para a rota de perfil
        if ($isOwnProfile) {
            return redirect()->route('profile.show');
        }

        // Buscar posts do usuário (apenas públicos se não for o próprio perfil)
        $posts = Post::query()
            ->with(['subreddit'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        // Verificar se o usuário atual está seguindo este usuário
        $isFollowing = false;
        if ($currentUser) {
            $isFollowing = $user->isFollowedBy($currentUser);
        }

        return view('profile.show', ['user' => $user, 'posts' => $posts, 'isFollowing' => $isFollowing, 'isOwnProfile' => $isOwnProfile]);
    }

    /**
     * Mostra o formulário de edição do perfil
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Atualiza o perfil do usuário
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'min:3', 'unique:users,username,'.$user->id],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'is_public' => ['boolean'],
        ]);

        $user->update($request->only([
            'name', 'username', 'bio', 'location', 'website', 'birth_date', 'is_public',
        ]));

        return redirect()->route('profile.show')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Mostra o formulário de alteração de senha
     */
    public function create(): View
    {
        return view('profile.edit-password');
    }

    /**
     * Atualiza a senha do usuário
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Senha alterada com sucesso!');
    }

    /**
     * Remove a foto de perfil
     */
    public function destroy(): RedirectResponse
    {
        $user = Auth::user();

        $user->clearMediaCollection('profile-pictures');

        return redirect()->route('profile.show')
            ->with('success', 'Foto de perfil removida com sucesso!');
    }
}
