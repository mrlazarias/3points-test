<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

final class ProfileController extends Controller
{
    /**
     * Mostra a página de perfil do usuário
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        $user->update($request->only('name', 'email'));

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
}
