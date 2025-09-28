<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Perfil - {{ $user->name }} - 3Pontos Community</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background-color: #111827; color: #f9fafb; min-height: 100vh">
        <!-- Header -->
        <header style="background-color: #1f2937; border-bottom: 1px solid #374151; padding: 1rem 1.5rem">
            <div
                style="
                    max-width: 80rem;
                    margin: 0 auto;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >
                <div style="display: flex; align-items: center; gap: 1rem">
                    <a
                        href="/"
                        style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit"
                    >
                        <div
                            style="
                                width: 2rem;
                                height: 2rem;
                                background-color: #f97316;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <span style="color: white; font-weight: bold; font-size: 0.875rem">3P</span>
                        </div>
                        <span style="font-size: 1.25rem; font-weight: 600">3Pontos</span>
                        <span style="color: #9ca3af; font-size: 0.875rem">Community</span>
                    </a>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem">
                    <button
                        style="padding: 0.5rem; color: #9ca3af; border-radius: 0.5rem; background: none; border: none"
                    >
                        <svg
                            style="width: 1.25rem; height: 1.25rem"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            ></path>
                        </svg>
                    </button>

                    <!-- User Menu -->
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <a
                            href="{{ route('profile.show') }}"
                            style="color: #d1d5db; text-decoration: none; font-size: 0.875rem"
                            onmouseover="this.style.color='#f9fafb'"
                            onmouseout="this.style.color='#d1d5db'"
                        >
                            Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0">
                            @csrf
                            <button
                                type="submit"
                                style="
                                    padding: 0.5rem 1rem;
                                    background-color: #dc2626;
                                    color: white;
                                    border: none;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    cursor: pointer;
                                    transition: background-color 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                onmouseout="this.style.backgroundColor='#dc2626'"
                            >
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div style="max-width: 80rem; margin: 0 auto; padding: 2rem 1.5rem">
            <!-- Success Message -->
            @if (session('success'))
                <div
                    style="
                        background-color: #16a34a;
                        border: 1px solid #22c55e;
                        border-radius: 0.5rem;
                        padding: 1rem;
                        margin-bottom: 2rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.5rem">
                        <svg
                            style="width: 1.25rem; height: 1.25rem; color: white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            ></path>
                        </svg>
                        <span style="color: white; font-weight: 500">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem">
                <!-- Sidebar - Profile Info -->
                <div>
                    <!-- Profile Card -->
                    <div
                        style="
                            background-color: #1f2937;
                            border: 1px solid #374151;
                            border-radius: 0.75rem;
                            padding: 2rem;
                            margin-bottom: 1.5rem;
                        "
                    >
                        <div style="text-align: center; margin-bottom: 1.5rem">
                            <div style="position: relative; display: inline-block; margin-bottom: 1rem">
                                @if ($user->getFirstMedia('profile-pictures'))
                                    <img
                                        src="{{ $user->getFirstMedia('profile-pictures')->getUrl() }}"
                                        alt="Foto de perfil"
                                        style="
                                            width: 4rem;
                                            height: 4rem;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 2px solid #374151;
                                        "
                                    />
                                @else
                                    <div
                                        style="
                                            width: 4rem;
                                            height: 4rem;
                                            background-color: #2563eb;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 1.5rem;
                                            font-weight: bold;
                                            color: white;
                                        "
                                    >
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <!-- Upload/Remove Photo Buttons -->
                                <div
                                    style="
                                        position: absolute;
                                        bottom: -0.5rem;
                                        right: -0.5rem;
                                        display: flex;
                                        gap: 0.25rem;
                                    "
                                >
                                    <form
                                        method="POST"
                                        action="{{ route('profile.upload-photo') }}"
                                        enctype="multipart/form-data"
                                        style="margin: 0"
                                    >
                                        @csrf
                                        <input
                                            type="file"
                                            name="photo"
                                            id="photo-upload"
                                            accept="image/*"
                                            style="display: none"
                                            onchange="this.form.submit()"
                                        />
                                        <label
                                            for="photo-upload"
                                            style="
                                                width: 1.5rem;
                                                height: 1.5rem;
                                                background-color: #2563eb;
                                                border-radius: 50%;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                cursor: pointer;
                                                border: 2px solid #1f2937;
                                            "
                                            title="Alterar foto"
                                        >
                                            <svg
                                                style="width: 0.75rem; height: 0.75rem; color: white"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                                ></path>
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                                                ></path>
                                            </svg>
                                        </label>
                                    </form>

                                    @if ($user->getFirstMedia('profile-pictures'))
                                        <form
                                            method="POST"
                                            action="{{ route('profile.remove-photo') }}"
                                            style="margin: 0"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                style="
                                                    width: 1.5rem;
                                                    height: 1.5rem;
                                                    background-color: #dc2626;
                                                    border-radius: 50%;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    cursor: pointer;
                                                    border: 2px solid #1f2937;
                                                    color: white;
                                                "
                                                title="Remover foto"
                                                onclick="return confirm('Tem certeza que deseja remover sua foto de perfil?')"
                                            >
                                                <svg
                                                    style="width: 0.75rem; height: 0.75rem"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    ></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <h1 style="font-size: 1.5rem; font-weight: bold; margin: 0 0 0.5rem 0">
                                {{ $user->name }}
                            </h1>
                            <p style="color: #9ca3af; margin: 0">{{ $user->email }}</p>
                        </div>

                        <div style="border-top: 1px solid #374151; padding-top: 1.5rem">
                            <div
                                style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem"
                            >
                                <div style="text-align: center">
                                    <p style="font-size: 1.25rem; font-weight: bold; margin: 0; color: #60a5fa">
                                        {{ $posts->total() }}
                                    </p>
                                    <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0">Posts</p>
                                </div>
                                <div style="text-align: center">
                                    <p style="font-size: 1.25rem; font-weight: bold; margin: 0; color: #10b981">
                                        {{ $subreddits->count() }}
                                    </p>
                                    <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0">
                                        Comunidades
                                    </p>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.75rem">
                                <a
                                    href="{{ route('profile.edit') }}"
                                    style="
                                        padding: 0.75rem;
                                        background-color: #2563eb;
                                        color: white;
                                        text-decoration: none;
                                        border-radius: 0.5rem;
                                        text-align: center;
                                        font-size: 0.875rem;
                                        font-weight: 500;
                                        transition: background-color 0.2s;
                                    "
                                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                                    onmouseout="this.style.backgroundColor='#2563eb'"
                                >
                                    Editar Perfil
                                </a>
                                <a
                                    href="{{ route('profile.edit-password') }}"
                                    style="
                                        padding: 0.75rem;
                                        background-color: #374151;
                                        color: #e5e7eb;
                                        text-decoration: none;
                                        border-radius: 0.5rem;
                                        text-align: center;
                                        font-size: 0.875rem;
                                        font-weight: 500;
                                        transition: background-color 0.2s;
                                    "
                                    onmouseover="this.style.backgroundColor='#4b5563'"
                                    onmouseout="this.style.backgroundColor='#374151'"
                                >
                                    Alterar Senha
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Created Subreddits -->
                    @if ($subreddits->count() > 0)
                        <div
                            style="
                                background-color: #1f2937;
                                border: 1px solid #374151;
                                border-radius: 0.75rem;
                                padding: 1.5rem;
                            "
                        >
                            <h3 style="font-weight: 500; color: #e5e7eb; margin: 0 0 1rem 0">Suas Comunidades</h3>
                            <div style="display: flex; flex-direction: column; gap: 0.75rem">
                                @foreach ($subreddits as $subreddit)
                                    <a
                                        href="{{ route('subreddit.show', $subreddit->slug) }}"
                                        style="
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            padding: 0.75rem;
                                            background-color: #374151;
                                            border-radius: 0.5rem;
                                            text-decoration: none;
                                            color: inherit;
                                            transition: background-color 0.2s;
                                        "
                                        onmouseover="this.style.backgroundColor='#4b5563'"
                                        onmouseout="this.style.backgroundColor='#374151'"
                                    >
                                        <div style="display: flex; align-items: center; gap: 0.75rem">
                                            <div
                                                style="
                                                    width: 2rem;
                                                    height: 2rem;
                                                    border-radius: 50%;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    font-size: 0.875rem;
                                                    font-weight: bold;
                                                    color: white;
                                                "
                                                style="background-color: {{ $subreddit->color }}"
                                            >
                                                {{ strtoupper(substr($subreddit->name, 0, 1)) }}
                                            </div>
                                            <span style="color: #e5e7eb">r/{{ $subreddit->slug }}</span>
                                        </div>
                                        <span style="color: #9ca3af; font-size: 0.875rem">
                                            {{ $subreddit->posts_count }} posts
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Main Content - User Posts -->
                <div>
                    <div style="margin-bottom: 1.5rem">
                        <h2 style="font-size: 1.25rem; font-weight: bold; margin: 0">
                            Seus Posts ({{ $posts->total() }})
                        </h2>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem">
                        @forelse ($posts as $post)
                            <article
                                style="
                                    background-color: #1f2937;
                                    border: 1px solid #374151;
                                    border-radius: 0.75rem;
                                    overflow: hidden;
                                "
                            >
                                <div style="padding: 1.5rem">
                                    <!-- Post Header -->
                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem">
                                        <div
                                            style="
                                                width: 2.5rem;
                                                height: 2.5rem;
                                                border-radius: 50%;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                font-size: 1.125rem;
                                                font-weight: bold;
                                                color: white;
                                            "
                                            style="background-color: {{ $post->subreddit->color }}"
                                        >
                                            {{ strtoupper(substr($post->subreddit->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 0.5rem">
                                                <a
                                                    href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                                                    style="font-weight: 500; color: #60a5fa; text-decoration: none"
                                                    onmouseover="this.style.textDecoration='underline'"
                                                    onmouseout="this.style.textDecoration='none'"
                                                >
                                                    r/{{ $post->subreddit->slug }}
                                                </a>
                                                <span style="color: #6b7280">•</span>
                                                <span style="color: #9ca3af">
                                                    {{ $post->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.75rem">
                                        <a
                                            href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
                                            style="color: inherit; text-decoration: none"
                                            onmouseover="this.style.color='#60a5fa'"
                                            onmouseout="this.style.color='inherit'"
                                        >
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p style="color: #d1d5db; line-height: 1.6; margin-bottom: 1rem">
                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                    </p>

                                    <!-- Post Actions -->
                                    <div style="display: flex; align-items: center; gap: 1.5rem">
                                        <div style="display: flex; align-items: center; gap: 0.5rem">
                                            <svg
                                                style="width: 1.25rem; height: 1.25rem; color: #9ca3af"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                                ></path>
                                            </svg>
                                            <span style="color: #9ca3af; font-size: 0.875rem">
                                                {{ $post->comment_count }}
                                            </span>
                                        </div>

                                        <div style="display: flex; align-items: center; gap: 0.5rem">
                                            <svg
                                                style="width: 1.25rem; height: 1.25rem; color: #9ca3af"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 15l7-7 7 7"
                                                ></path>
                                            </svg>
                                            <span style="font-size: 0.875rem; font-weight: 500">
                                                {{ $post->vote_score }}
                                            </span>
                                            <svg
                                                style="width: 1.25rem; height: 1.25rem; color: #9ca3af"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 9l-7 7-7-7"
                                                ></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div
                                style="
                                    background-color: #1f2937;
                                    border: 1px solid #374151;
                                    border-radius: 0.75rem;
                                    padding: 2rem;
                                    text-align: center;
                                "
                            >
                                <p style="color: #9ca3af; margin: 0">Você ainda não criou nenhum post.</p>
                                <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 0">
                                    Que tal compartilhar algo interessante?
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($posts->hasPages())
                        <div style="margin-top: 2rem">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>

<?php
