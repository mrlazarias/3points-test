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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

final class ProfileController extends Controller
{
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

        // Buscar subreddits criados pelo usuário
        $subreddits = Subreddit::query()
            ->where('created_by', $user->id)
            ->withCount('posts')
            ->orderByDesc('created_at')
            ->get();

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
            'subreddits' => $subreddits,
            'isOwnProfile' => true,
        ]);
    }

    /**
     * Mostra a página de perfil de outro usuário
     */
    public function showUser(string $username): View
    {
        $user = User::query()->where('username', $username)->firstOrFail();
        $currentUser = Auth::user();
        $isOwnProfile = $currentUser && $currentUser->id === $user->id;

        // Se não for o próprio perfil e o perfil for privado, verificar se pode ver
        abort_if(! $isOwnProfile && ! $user->is_public, 403, 'Este perfil é privado.');

        // Buscar posts do usuário
        $posts = Post::query()
            ->with(['subreddit'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        // Buscar subreddits criados pelo usuário
        $subreddits = Subreddit::query()
            ->where('created_by', $user->id)
            ->withCount('posts')
            ->orderByDesc('created_at')
            ->get();

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
            'subreddits' => $subreddits,
            'isOwnProfile' => $isOwnProfile,
        ]);
    }

    /**
     * Mostra o formulário de edição do perfil
     */
    public function edit(): View
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Atualiza os dados do perfil
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,'.$user->id, 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'is_public' => ['boolean'],
        ]);

        $user->update($request->only([
            'name',
            'username',
            'email',
            'bio',
            'location',
            'website',
            'birth_date',
            'is_public',
        ]));

        return redirect()->route('profile.show')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Mostra o formulário de alteração de senha
     */
    public function editPassword(): View
    {
        return view('profile.edit-password');
    }

    /**
     * Atualiza a senha do usuário
     */
    public function updatePassword(Request $request): RedirectResponse
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
     * Faz upload da foto de perfil
     */
    public function uploadPhoto(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Remove foto anterior se existir
        $user->clearMediaCollection('profile-pictures');

        // Adiciona nova foto
        $user->addMediaFromRequest('photo')
            ->toMediaCollection('profile-pictures');

        return redirect()->route('profile.show')
            ->with('success', 'Foto de perfil atualizada com sucesso!');
    }

    /**
     * Remove a foto de perfil
     */
    public function removePhoto(): RedirectResponse
    {
        $user = Auth::user();

        $user->clearMediaCollection('profile-pictures');

        return redirect()->route('profile.show')
            ->with('success', 'Foto de perfil removida com sucesso!');
    }

    /**
     * Faz upload da foto de capa
     */
    public function uploadCoverPhoto(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'cover_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        // Remove foto anterior se existir
        $user->clearMediaCollection('cover-photos');

        // Adiciona nova foto
        $user->addMediaFromRequest('cover_photo')
            ->toMediaCollection('cover-photos');

        return redirect()->route('profile.show')
            ->with('success', 'Foto de capa atualizada com sucesso!');
    }

    /**
     * Remove a foto de capa
     */
    public function removeCoverPhoto(): RedirectResponse
    {
        $user = Auth::user();

        $user->clearMediaCollection('cover-photos');

        return redirect()->route('profile.show')
            ->with('success', 'Foto de capa removida com sucesso!');
    }
}
