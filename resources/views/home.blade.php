<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>3Pontos Community</title>
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
                    <div style="display: flex; align-items: center; gap: 0.75rem">
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
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem">
                    @auth
                        <a
                            href="{{ route('subreddit.create') }}"
                            style="
                                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                                color: white;
                                padding: 0.75rem 1.5rem;
                                border-radius: 0.75rem;
                                text-decoration: none;
                                font-weight: 600;
                                font-size: 0.875rem;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                                transition: all 0.2s;
                                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                            "
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'"
                        >
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                ></path>
                            </svg>
                            Criar Comunidade
                        </a>
                    @endauth

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

                    @auth
                        <!-- User Menu -->
                        <div style="display: flex; align-items: center; gap: 0.75rem">
                            <a
                                href="{{ route('profile.show') }}"
                                style="
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    color: #d1d5db;
                                    text-decoration: none;
                                    font-size: 0.875rem;
                                "
                                onmouseover="this.style.color='#f9fafb'"
                                onmouseout="this.style.color='#d1d5db'"
                            >
                                @if (Auth::user()->getFirstMedia('profile-pictures'))
                                    <img
                                        src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl() }}"
                                        alt="Foto de perfil"
                                        style="
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 1px solid #374151;
                                        "
                                    />
                                @else
                                    <div
                                        style="
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            background-color: #2563eb;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 0.75rem;
                                            font-weight: bold;
                                            color: white;
                                        "
                                    >
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                {{ Auth::user()->name }}
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
                    @else
                        <!-- Auth Links -->
                        <div style="display: flex; align-items: center; gap: 0.75rem">
                            <a
                                href="{{ route('login') }}"
                                style="
                                    color: #9ca3af;
                                    text-decoration: none;
                                    font-size: 0.875rem;
                                    transition: color 0.2s;
                                "
                                onmouseover="this.style.color='#f9fafb'"
                                onmouseout="this.style.color='#9ca3af'"
                            >
                                Entrar
                            </a>
                            <a
                                href="{{ route('register') }}"
                                style="
                                    padding: 0.5rem 1rem;
                                    background-color: #2563eb;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    transition: background-color 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#1d4ed8'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                            >
                                Registrar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <div style="max-width: 80rem; margin: 0 auto; padding: 2rem 1.5rem">
            <!-- Welcome Section -->
            <div style="margin-bottom: 2rem">
                <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem">
                    @auth
                        Olá,
                        <span style="color: #60a5fa">{{ Auth::user()->name }}</span>
                    @else
                        Olá, visitante!
                    @endauth
                </h1>
                <p style="color: #9ca3af">Confira as estatísticas das comunidades que você segue</p>
            </div>

            <!-- Stats Cards -->
            <div
                style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 1.5rem;
                    margin-bottom: 2rem;
                "
            >
                <div
                    style="
                        background-color: #1f2937;
                        border: 1px solid #374151;
                        border-radius: 0.75rem;
                        padding: 1.5rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 3rem;
                                height: 3rem;
                                background-color: #2563eb;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <svg
                                style="width: 1.5rem; height: 1.5rem; color: white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 0.875rem">Quantidade de usuários</p>
                            <p style="font-size: 1.5rem; font-weight: bold">10000</p>
                        </div>
                    </div>
                </div>

                <div
                    style="
                        background-color: #1f2937;
                        border: 1px solid #374151;
                        border-radius: 0.75rem;
                        padding: 1.5rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 3rem;
                                height: 3rem;
                                background-color: #16a34a;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <svg
                                style="width: 1.5rem; height: 1.5rem; color: white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 0.875rem">Quantidade de posts</p>
                            <p style="font-size: 1.5rem; font-weight: bold">{{ $posts->total() }}</p>
                        </div>
                    </div>
                </div>

                <div
                    style="
                        background-color: #1f2937;
                        border: 1px solid #374151;
                        border-radius: 0.75rem;
                        padding: 1.5rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 3rem;
                                height: 3rem;
                                background-color: #9333ea;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <svg
                                style="width: 1.5rem; height: 1.5rem; color: white"
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
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 0.875rem">Quantidade de replies</p>
                            <p style="font-size: 1.5rem; font-weight: bold">10000</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem">
                <!-- Sidebar -->
                <div>
                    <!-- Navigation -->
                    <nav style="margin-bottom: 1.5rem">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem">
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
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                                ></path>
                            </svg>
                            <span style="font-weight: 500">Home</span>
                        </div>
                    </nav>

                    <!-- Communities -->
                    <div style="background-color: #1f2937; border: 1px solid #374151; border-radius: 0.75rem">
                        <div style="padding: 1rem; border-bottom: 1px solid #374151">
                            <h3 style="font-weight: 500; color: #e5e7eb">
                                @auth
                                    Minhas comunidades
                                @else
                                    Comunidades populares
                                @endauth
                            </h3>
                        </div>
                        <div style="padding: 0.5rem">
                            @foreach ($subreddits as $subreddit)
                                @php
                                    $icons = ['🎨', '🔥', '🌱', '💻', '⚡'];
                                    $icon = $icons[array_rand($icons)];
                                @endphp

                                <a
                                    href="{{ route('subreddit.show', $subreddit->slug) }}"
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        padding: 0.75rem;
                                        border-radius: 0.5rem;
                                        text-decoration: none;
                                        color: inherit;
                                    "
                                    onmouseover="this.style.backgroundColor='#374151'"
                                    onmouseout="this.style.backgroundColor='transparent'"
                                >
                                    <div style="display: flex; align-items: center; gap: 0.75rem">
                                        <span style="font-size: 1.125rem">{{ $icon }}</span>
                                        <span style="color: #e5e7eb">{{ $subreddit->name }}</span>
                                    </div>
                                    <div
                                        style="
                                            display: flex;
                                            flex-direction: column;
                                            align-items: flex-end;
                                            gap: 0.25rem;
                                        "
                                    >
                                        <span style="color: #9ca3af; font-size: 0.875rem">
                                            +{{ $subreddit->posts_count }} posts
                                        </span>
                                        <span style="color: #6b7280; font-size: 0.75rem">
                                            {{ $subreddit->followers_count }} seguidores
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Suggested Communities -->
                <div style="margin-top: 1.5rem">
                    <div style="background-color: #1f2937; border: 1px solid #374151; border-radius: 0.75rem">
                        <div style="padding: 1rem; border-bottom: 1px solid #374151">
                            <div style="display: flex; justify-content: space-between; align-items: center">
                                <div>
                                    <h3 style="font-weight: 500; color: #e5e7eb">🌟 Comunidades Sugeridas</h3>
                                    <p style="color: #9ca3af; font-size: 0.875rem; margin-top: 0.25rem">
                                        Descubra novas comunidades interessantes
                                    </p>
                                </div>
                                <button
                                    onclick="refreshSuggestions()"
                                    style="
                                        padding: 0.5rem;
                                        background-color: #374151;
                                        color: #e5e7eb;
                                        border: 1px solid #4b5563;
                                        border-radius: 0.375rem;
                                        font-size: 0.75rem;
                                        font-weight: 500;
                                        cursor: pointer;
                                        transition: all 0.2s;
                                        display: flex;
                                        align-items: center;
                                        gap: 0.25rem;
                                    "
                                    onmouseover="this.style.backgroundColor='#4b5563'"
                                    onmouseout="this.style.backgroundColor='#374151'"
                                >
                                    <svg
                                        style="width: 1rem; height: 1rem"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                        ></path>
                                    </svg>
                                    Atualizar
                                </button>
                            </div>
                        </div>
                        <div class="suggested-communities-list" style="padding: 0.5rem">
                            @foreach ($suggestedSubreddits as $suggestedSubreddit)
                                @php
                                    $icons = ['🎨', '🔥', '🌱', '💻', '⚡', '🚀', '💡', '🎯', '🌟', '🎪'];
                                    $icon = $icons[array_rand($icons)];
                                @endphp

                                <a
                                    href="{{ route('subreddit.show', $suggestedSubreddit->slug) }}"
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        padding: 0.75rem;
                                        border-radius: 0.5rem;
                                        text-decoration: none;
                                        color: inherit;
                                    "
                                    onmouseover="this.style.backgroundColor='#374151'"
                                    onmouseout="this.style.backgroundColor='transparent'"
                                >
                                    <div style="display: flex; align-items: center; gap: 0.75rem">
                                        <span style="font-size: 1.125rem">{{ $icon }}</span>
                                        <span style="color: #e5e7eb">{{ $suggestedSubreddit->name }}</span>
                                    </div>
                                    <div
                                        style="
                                            display: flex;
                                            flex-direction: column;
                                            align-items: flex-end;
                                            gap: 0.25rem;
                                        "
                                    >
                                        <span style="color: #9ca3af; font-size: 0.875rem">
                                            +{{ $suggestedSubreddit->posts_count }} posts
                                        </span>
                                        <span style="color: #6b7280; font-size: 0.75rem">
                                            {{ $suggestedSubreddit->followers_count }} seguidores
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div>
                    <div style="margin-bottom: 1.5rem">
                        <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem">
                            Veja os últimos posts das comunidades que você segue
                        </h2>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem">
                        @if ($posts->count() > 0)
                            @foreach ($posts as $post)
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
                                        <div
                                            style="
                                                display: flex;
                                                align-items: center;
                                                gap: 0.75rem;
                                                margin-bottom: 1rem;
                                            "
                                        >
                                            @php
                                                $icons = ['👨‍💻', '🔧', '🎯', '💡', '🚀'];
                                                $icon = $icons[array_rand($icons)];
                                            @endphp

                                            <div
                                                style="
                                                    width: 2.5rem;
                                                    height: 2.5rem;
                                                    background-color: #374151;
                                                    border-radius: 50%;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                "
                                            >
                                                <span style="font-size: 1.125rem">{{ $icon }}</span>
                                            </div>
                                            <div style="flex: 1">
                                                <div style="display: flex; align-items: center; gap: 0.5rem">
                                                    <span style="font-weight: 500; color: #d1d5db">
                                                        r/{{ $post->subreddit->slug }}
                                                    </span>
                                                    @auth
                                                        <button
                                                            id="follow-btn-{{ $post->subreddit->id }}"
                                                            data-subreddit-slug="{{ $post->subreddit->slug }}"
                                                            onclick="toggleFollow({{ $post->subreddit->id }}, '{{ $post->subreddit->slug }}')"
                                                            style="
                                                                padding: 0.25rem 0.75rem;
                                                                background-color: #374151;
                                                                color: #e5e7eb;
                                                                border: 1px solid #4b5563;
                                                                border-radius: 0.375rem;
                                                                font-size: 0.75rem;
                                                                font-weight: 500;
                                                                cursor: pointer;
                                                                transition: all 0.2s;
                                                            "
                                                            onmouseover="this.style.backgroundColor='#4b5563'"
                                                            onmouseout="this.style.backgroundColor='#374151'"
                                                        >
                                                            <span id="follow-text-{{ $post->subreddit->id }}">
                                                                Seguir
                                                            </span>
                                                        </button>
                                                    @endauth
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
                                            <!-- Comments Button -->
                                            <div style="display: flex; align-items: center; gap: 0.5rem">
                                                <button
                                                    onclick="openCommentsModal({{ $post->id }}, '{{ $post->title }}', '{{ $post->subreddit->slug }}', '{{ $post->slug }}')"
                                                    style="
                                                        display: flex;
                                                        align-items: center;
                                                        gap: 0.25rem;
                                                        color: #9ca3af;
                                                        background: none;
                                                        border: none;
                                                        cursor: pointer;
                                                        padding: 0.5rem;
                                                        border-radius: 0.5rem;
                                                        transition: all 0.2s;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#374151'; this.style.color='#d1d5db'"
                                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af'"
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
                                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                                        ></path>
                                                    </svg>
                                                    <span style="font-size: 0.875rem">{{ $post->comment_count }}</span>
                                                </button>
                                            </div>

                                            <!-- Vote Section -->
                                            <div style="display: flex; align-items: center; gap: 0.5rem">
                                                @auth
                                                    <!-- Like Button -->
                                                    <button
                                                        onclick="votePost({{ $post->id }}, 'up')"
                                                        id="upvote-{{ $post->id }}"
                                                        class="vote-btn group flex items-center space-x-1.5 rounded-lg border border-transparent px-3 py-1.5 text-slate-400 transition-all duration-200 hover:border-green-500/30 hover:bg-green-500/15 hover:text-green-400 focus:ring-2 focus:ring-green-500/30 focus:outline-none"
                                                        data-vote-type="up"
                                                        data-target-id="{{ $post->id }}"
                                                        data-target-type="post"
                                                    >
                                                        <div
                                                            class="flex h-5 w-5 items-center justify-center rounded-full transition-all duration-200 group-hover:bg-green-500/20 group-hover:shadow-md group-hover:shadow-green-500/20"
                                                        >
                                                            <svg
                                                                class="h-3.5 w-3.5 transition-transform duration-200 group-hover:scale-110"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M5 15l7-7 7 7"
                                                                ></path>
                                                            </svg>
                                                        </div>
                                                        <span
                                                            id="likes-count-{{ $post->id }}"
                                                            class="text-xs font-bold transition-colors duration-200 group-hover:text-green-400"
                                                        >
                                                            {{ $post->likes_count ?? 0 }}
                                                        </span>
                                                    </button>

                                                    <!-- Dislike Button -->
                                                    <button
                                                        onclick="votePost({{ $post->id }}, 'down')"
                                                        id="downvote-{{ $post->id }}"
                                                        class="vote-btn group flex items-center space-x-1.5 rounded-lg border border-transparent px-3 py-1.5 text-slate-400 transition-all duration-200 hover:border-red-500/30 hover:bg-red-500/15 hover:text-red-400 focus:ring-2 focus:ring-red-500/30 focus:outline-none"
                                                        data-vote-type="down"
                                                        data-target-id="{{ $post->id }}"
                                                        data-target-type="post"
                                                    >
                                                        <div
                                                            class="flex h-5 w-5 items-center justify-center rounded-full transition-all duration-200 group-hover:bg-red-500/20 group-hover:shadow-md group-hover:shadow-red-500/20"
                                                        >
                                                            <svg
                                                                class="h-3.5 w-3.5 transition-transform duration-200 group-hover:scale-110"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M19 9l-7 7-7-7"
                                                                ></path>
                                                            </svg>
                                                        </div>
                                                        <span
                                                            id="dislikes-count-{{ $post->id }}"
                                                            class="text-xs font-bold transition-colors duration-200 group-hover:text-red-400"
                                                        >
                                                            {{ $post->dislikes_count ?? 0 }}
                                                        </span>
                                                    </button>
                                                @else
                                                    <!-- Like Button (Not Logged In) -->
                                                    <button
                                                        onclick="showLoginAlert()"
                                                        class="vote-btn group flex items-center space-x-1.5 rounded-lg border border-transparent px-3 py-1.5 text-slate-400 transition-all duration-200 hover:border-green-500/30 hover:bg-green-500/15 hover:text-green-400 focus:ring-2 focus:ring-green-500/30 focus:outline-none"
                                                    >
                                                        <div
                                                            class="flex h-5 w-5 items-center justify-center rounded-full transition-all duration-200 group-hover:bg-green-500/20 group-hover:shadow-md group-hover:shadow-green-500/20"
                                                        >
                                                            <svg
                                                                class="h-3.5 w-3.5 transition-transform duration-200 group-hover:scale-110"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M5 15l7-7 7 7"
                                                                ></path>
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="text-xs font-bold transition-colors duration-200 group-hover:text-green-400"
                                                        >
                                                            {{ $post->likes_count ?? 0 }}
                                                        </span>
                                                    </button>

                                                    <!-- Dislike Button (Not Logged In) -->
                                                    <button
                                                        onclick="showLoginAlert()"
                                                        class="vote-btn group flex items-center space-x-1.5 rounded-lg border border-transparent px-3 py-1.5 text-slate-400 transition-all duration-200 hover:border-red-500/30 hover:bg-red-500/15 hover:text-red-400 focus:ring-2 focus:ring-red-500/30 focus:outline-none"
                                                    >
                                                        <div
                                                            class="flex h-5 w-5 items-center justify-center rounded-full transition-all duration-200 group-hover:bg-red-500/20 group-hover:shadow-md group-hover:shadow-red-500/20"
                                                        >
                                                            <svg
                                                                class="h-3.5 w-3.5 transition-transform duration-200 group-hover:scale-110"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M19 9l-7 7-7-7"
                                                                ></path>
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="text-xs font-bold transition-colors duration-200 group-hover:text-red-400"
                                                        >
                                                            {{ $post->dislikes_count ?? 0 }}
                                                        </span>
                                                    </button>
                                                @endauth
                                            </div>

                                            <a
                                                href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
                                                style="
                                                    padding: 0.5rem 1rem;
                                                    background-color: #374151;
                                                    color: #e5e7eb;
                                                    border-radius: 0.5rem;
                                                    border: none;
                                                    font-size: 0.875rem;
                                                    cursor: pointer;
                                                    text-decoration: none;
                                                    display: inline-block;
                                                    transition: all 0.2s;
                                                "
                                                onmouseover="this.style.backgroundColor='#4b5563'"
                                                onmouseout="this.style.backgroundColor='#374151'"
                                            >
                                                Ver Post
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @else
                            @auth
                                <div
                                    style="
                                        background-color: #1f2937;
                                        border: 1px solid #374151;
                                        border-radius: 0.75rem;
                                        padding: 2rem;
                                        text-align: center;
                                    "
                                >
                                    <div style="font-size: 3rem; margin-bottom: 1rem">🔍</div>
                                    <h3 style="color: #e5e7eb; margin-bottom: 0.5rem; font-size: 1.125rem">
                                        Nenhuma comunidade seguida
                                    </h3>
                                    <p style="color: #9ca3af; margin-bottom: 1rem">
                                        Você ainda não está seguindo nenhuma comunidade.
                                    </p>
                                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem">
                                        Explore as comunidades disponíveis e comece a seguir as que mais te interessam!
                                    </p>
                                    <a
                                        href="/"
                                        style="
                                            display: inline-block;
                                            padding: 0.75rem 1.5rem;
                                            background-color: #2563eb;
                                            color: white;
                                            text-decoration: none;
                                            border-radius: 0.5rem;
                                            font-size: 0.875rem;
                                            font-weight: 500;
                                            transition: background-color 0.2s;
                                        "
                                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                                        onmouseout="this.style.backgroundColor='#2563eb'"
                                    >
                                        Explorar Comunidades
                                    </a>
                                </div>
                            @else
                                <div
                                    style="
                                        background-color: #1f2937;
                                        border: 1px solid #374151;
                                        border-radius: 0.75rem;
                                        padding: 2rem;
                                        text-align: center;
                                    "
                                >
                                    <p style="color: #9ca3af">Nenhum post encontrado.</p>
                                    <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem">
                                        Seja o primeiro a compartilhar algo!
                                    </p>
                                </div>
                            @endauth
                        @endif
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

        <!-- JavaScript para funcionalidade de votação -->
        <script>
            // Variáveis globais
            let csrfToken = null;

            // Função para votar em posts
            async function votePost(postId, voteType) {
                try {
                    const response = await fetch('/vote', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            voteable_type: 'post',
                            voteable_id: postId,
                            vote_type: voteType
                        })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Atualizar contadores de likes e dislikes
                        const likesElement = document.getElementById(`likes-count-${postId}`);
                        const dislikesElement = document.getElementById(`dislikes-count-${postId}`);

                        if (likesElement) {
                            likesElement.textContent = data.likes || 0;
                            likesElement.classList.add('vote-count', 'updated');
                            setTimeout(() => likesElement.classList.remove('updated'), 600);
                        }
                        if (dislikesElement) {
                            dislikesElement.textContent = data.dislikes || 0;
                            dislikesElement.classList.add('vote-count', 'updated');
                            setTimeout(() => dislikesElement.classList.remove('updated'), 600);
                        }

                        // Update button states using the centralized function
                        if (data.vote_type) {
                            applyVoteState(postId, data.vote_type);

                            // Add pulse animation for new votes (temporary)
                            const activeBtn = document.querySelector(
                                `[data-target-id="${postId}"][data-vote-type="${data.vote_type}"]`,
                            );
                            if (activeBtn) {
                                if (data.vote_type === 'up') {
                                    activeBtn.style.animation = 'pulse-glow 2s infinite';
                                } else {
                                    activeBtn.style.animation = 'pulse-glow-red 2s infinite';
                                }

                                // Remove animation after 3 seconds
                                setTimeout(() => {
                                    activeBtn.style.animation = '';
                                    if (data.vote_type === 'up') {
                                        activeBtn.style.boxShadow = '0 0 8px rgba(34, 197, 94, 0.3)';
                                    } else {
                                        activeBtn.style.boxShadow = '0 0 8px rgba(239, 68, 68, 0.3)';
                                    }
                                }, 3000);
                            }
                        } else {
                            // If no vote type, reset all buttons to default state
                            const allButtons = document.querySelectorAll(`[data-target-id="${postId}"]`);
                            allButtons.forEach(btn => {
                                btn.classList.remove(
                                    'bg-green-500/20',
                                    'bg-red-500/20',
                                    'text-green-400',
                                    'text-red-400',
                                    'border-green-500/30',
                                    'border-red-500/30',
                                    'active'
                                );
                                btn.classList.add('text-slate-400', 'border-transparent');
                                btn.style.animation = '';

                                // Reset icon containers
                                const iconContainer = btn.querySelector('div');
                                if (iconContainer) {
                                    iconContainer.classList.remove('bg-green-500/20', 'bg-red-500/20', 'shadow-lg', 'shadow-green-500/20', 'shadow-red-500/20');
                                }

                                // Reset count spans
                                const countSpan = btn.querySelector('span');
                                if (countSpan) {
                                    countSpan.classList.remove('text-green-400', 'text-red-400');
                                    countSpan.classList.add('text-slate-400');
                                }
                            });
                        }
                    } else {
                        console.error('Erro ao votar:', data.message);
                        alert('Erro ao votar. Tente novamente.');
                    }
                } catch (error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro de conexão. Tente novamente.');
                }
            }

            // Função para mostrar alerta de login
            function showLoginAlert() {
                alert('Você precisa fazer login para votar. Redirecionando...');
                window.location.href = '{{ route("login") }}';
            }

            // Carregar votos do usuário ao carregar a página

            // Função para carregar votos do usuário
            async function loadUserVotes() {
                try {
                    // Carregar votos para cada post individualmente
                    const postElements = document.querySelectorAll('[data-target-id]');
                    const postIds = [...new Set(Array.from(postElements).map(el => el.getAttribute('data-target-id')))];

                    for (const postId of postIds) {
                        const url = `{{ route("vote.user") }}?voteable_type=post&voteable_id=${postId}`;

                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            }
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if (data.vote && data.vote.vote_type) {
                                applyVoteState(postId, data.vote.vote_type);
                            }
                        }
                    }
                } catch (error) {
                    console.error('Erro ao carregar votos:', error);
                }
            }

            // Função para aplicar estado visual do voto
            function applyVoteState(postId, voteType) {
                const activeBtn = document.querySelector(
                    `[data-target-id="${postId}"][data-vote-type="${voteType}"]`,
                );

                if (activeBtn) {
                    // Reset all buttons for this post first
                    const allButtons = document.querySelectorAll(`[data-target-id="${postId}"]`);
                    allButtons.forEach(btn => {
                        btn.classList.remove(
                            'bg-green-500/20',
                            'bg-red-500/20',
                            'text-green-400',
                            'text-red-400',
                            'border-green-500/30',
                            'border-red-500/30',
                            'active'
                        );
                        btn.classList.add('text-slate-400', 'border-transparent');

                        // Reset icon containers
                        const iconContainer = btn.querySelector('div');
                        if (iconContainer) {
                            iconContainer.classList.remove('bg-green-500/20', 'bg-red-500/20', 'shadow-lg', 'shadow-green-500/20', 'shadow-red-500/20');
                        }

                        // Reset count spans
                        const countSpan = btn.querySelector('span');
                        if (countSpan) {
                            countSpan.classList.remove('text-green-400', 'text-red-400');
                            countSpan.classList.add('text-slate-400');
                        }
                    });

                    // Apply active state to the voted button
                    activeBtn.classList.remove('text-slate-400', 'border-transparent');
                    activeBtn.classList.add(
                        voteType === 'up' ? 'bg-green-500/20' : 'bg-red-500/20',
                        voteType === 'up' ? 'text-green-400' : 'text-red-400',
                        voteType === 'up' ? 'border-green-500/30' : 'border-red-500/30',
                        'active'
                    );

                    // Apply active state to icon container
                    const iconContainer = activeBtn.querySelector('div');
                    if (iconContainer) {
                        iconContainer.classList.add(
                            voteType === 'up' ? 'bg-green-500/20' : 'bg-red-500/20',
                            'shadow-lg'
                        );
                        if (voteType === 'up') {
                            iconContainer.classList.add('shadow-green-500/20');
                        } else {
                            iconContainer.classList.add('shadow-red-500/20');
                        }
                    }

                    // Apply active state to count span
                    const countSpan = activeBtn.querySelector('span');
                    if (countSpan) {
                        countSpan.classList.remove('text-slate-400');
                        countSpan.classList.add(
                            voteType === 'up' ? 'text-green-400' : 'text-red-400',
                        );
                    }

                    // Add subtle glow effect for existing votes (no constant animation)
                    if (voteType === 'up') {
                        activeBtn.style.boxShadow = '0 0 8px rgba(34, 197, 94, 0.3)';
                    } else {
                        activeBtn.style.boxShadow = '0 0 8px rgba(239, 68, 68, 0.3)';
                    }
                }
            }

            // Variáveis globais para o modal de comentários
            let currentPostId = null;
            let currentPostTitle = '';
            let currentSubredditSlug = '';
            let currentPostSlug = '';

            // Função para abrir o modal de comentários
            function openCommentsModal(postId, postTitle, subredditSlug, postSlug) {
                currentPostId = postId;
                currentPostTitle = postTitle;
                currentSubredditSlug = subredditSlug;
                currentPostSlug = postSlug;

                document.getElementById('modalTitle').textContent = `Comentários - ${postTitle}`;
                document.getElementById('commentsModal').style.display = 'block';
                document.body.style.overflow = 'hidden';

                // Carregar comentários
                loadComments();
            }

            // Função para fechar o modal de comentários
            function closeCommentsModal() {
                document.getElementById('commentsModal').style.display = 'none';
                document.body.style.overflow = 'auto';
                currentPostId = null;
            }

            // Função para carregar comentários
            async function loadComments() {
                if (!currentPostId) return;

                try {
                    const response = await fetch(`/posts/${currentSubredditSlug}/${currentPostSlug}/comments`, {
                        headers: {
                            'Accept': 'application/json',
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        displayComments(data.comments || []);
                    } else {
                        document.getElementById('commentsList').innerHTML = `
                            <div style="text-align: center; color: #ef4444; padding: 2rem">
                                Erro ao carregar comentários
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error('Erro ao carregar comentários:', error);
                    document.getElementById('commentsList').innerHTML = `
                        <div style="text-align: center; color: #ef4444; padding: 2rem">
                            Erro de conexão
                        </div>
                    `;
                }
            }

            // Função para exibir comentários
            function displayComments(comments) {
                const commentsList = document.getElementById('commentsList');

                if (comments.length === 0) {
                    commentsList.innerHTML = `
                        <div style="text-align: center; color: #9ca3af; padding: 2rem">
                            Nenhum comentário ainda. Seja o primeiro a comentar!
                        </div>
                    `;
                    return;
                }

                commentsList.innerHTML = comments.map(comment => `
                    <div style="
                        background-color: #374151;
                        border-radius: 0.5rem;
                        padding: 1rem;
                        margin-bottom: 1rem;
                        border: 1px solid #4b5563;
                    ">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem">
                            <div style="
                                width: 2rem;
                                height: 2rem;
                                background-color: #6b7280;
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: white;
                                font-weight: bold;
                                font-size: 0.875rem;
                            ">
                                ${comment.user.name.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <div style="font-weight: 500; color: #f9fafb">${comment.user.name}</div>
                                <div style="font-size: 0.875rem; color: #9ca3af">${new Date(comment.created_at).toLocaleString('pt-BR')}</div>
                            </div>
                        </div>
                        <div style="color: #d1d5db; line-height: 1.6; white-space: pre-wrap">${comment.content}</div>
                    </div>
                `).join('');
            }

            // Função para enviar comentário
            async function submitComment(event) {
                event.preventDefault();

                if (!currentPostId) return;

                const content = document.getElementById('commentContent').value.trim();
                if (!content) return;

                try {
                    const response = await fetch(`/posts/${currentSubredditSlug}/${currentPostSlug}/comments`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            content: content
                        })
                    });

                    if (response.ok) {
                        document.getElementById('commentContent').value = '';
                        loadComments(); // Recarregar comentários

                        // Atualizar contador de comentários na homepage
                        const commentCountElement = document.querySelector(`[onclick*="openCommentsModal(${currentPostId}"] span`);
                        if (commentCountElement) {
                            const currentCount = parseInt(commentCountElement.textContent);
                            commentCountElement.textContent = currentCount + 1;
                        }
                    } else {
                        const data = await response.json();
                        alert('Erro ao enviar comentário: ' + (data.message || 'Tente novamente'));
                    }
                } catch (error) {
                    console.error('Erro ao enviar comentário:', error);
                    alert('Erro de conexão. Tente novamente.');
                }
            }

            // Fechar modal ao clicar fora dele
            const commentsModal = document.getElementById('commentsModal');
            if (commentsModal) {
                commentsModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCommentsModal();
                    }
                });
            }

            // Função para alternar follow/unfollow de comunidade
            async function toggleFollow(subredditId, subredditSlug) {
                const button = document.getElementById(`follow-btn-${subredditId}`);
                const text = document.getElementById(`follow-text-${subredditId}`);

                if (!button || !text) return;

                // Desabilitar botão durante a requisição
                button.disabled = true;
                button.style.opacity = '0.6';

                try {
                    // Verificar se já está seguindo
                    const checkResponse = await fetch(`/communities/${subredditSlug}/follow-status`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    });

                    const checkData = await checkResponse.json();

                    if (!checkData.success) {
                        throw new Error(checkData.message || 'Erro ao verificar status');
                    }

                    const isFollowing = checkData.is_following;
                    const url = `/communities/${subredditSlug}/follow`;
                    const method = isFollowing ? 'DELETE' : 'POST';

                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Atualizar texto do botão
                        text.textContent = data.is_following ? 'Seguindo' : 'Seguir';

                        // Atualizar estilo do botão
                        if (data.is_following) {
                            button.style.backgroundColor = '#10b981';
                            button.style.borderColor = '#059669';
                            button.style.color = '#ffffff';
                        } else {
                            button.style.backgroundColor = '#374151';
                            button.style.borderColor = '#4b5563';
                            button.style.color = '#e5e7eb';
                        }

                        // Mostrar mensagem de sucesso
                        console.log(data.message);
                    } else {
                        throw new Error(data.message || 'Erro na operação');
                    }
                } catch (error) {
                    console.error('Erro ao alternar follow:', error);
                    alert('Erro: ' + error.message);
                } finally {
                    // Reabilitar botão
                    button.disabled = false;
                    button.style.opacity = '1';
                }
            }

            // Carregar status de follow das comunidades na página
            async function loadFollowStatus() {
                @auth
                    // Obter todos os botões de follow
                    const followButtons = document.querySelectorAll('[id^="follow-btn-"]');

                    for (const button of followButtons) {
                        const text = document.getElementById(`follow-text-${button.id.replace('follow-btn-', '')}`);
                        const subredditSlug = button.getAttribute('data-subreddit-slug');

                        if (!text || !subredditSlug) continue;

                        try {
                            const response = await fetch(`/communities/${subredditSlug}/follow-status`, {
                                method: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json',
                                },
                            });

                            const data = await response.json();

                            if (data.success) {
                                // Atualizar texto do botão
                                text.textContent = data.is_following ? 'Seguindo' : 'Seguir';

                                // Atualizar estilo do botão
                                if (data.is_following) {
                                    button.style.backgroundColor = '#10b981';
                                    button.style.borderColor = '#059669';
                                    button.style.color = '#ffffff';
                                } else {
                                    button.style.backgroundColor = '#374151';
                                    button.style.borderColor = '#4b5563';
                                    button.style.color = '#e5e7eb';
                                }
                            }
                        } catch (error) {
                            console.error(`Erro ao carregar status de follow para comunidade ${subredditSlug}:`, error);
                        }
                    }
                @endauth
            }

            // Carregar status de follow quando a página carregar
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar CSRF token
                csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                @auth
                    // Carregar votos existentes do usuário
                    loadUserVotes();

                    // Carregar status de follow
                    loadFollowStatus();
                @endauth
            });

            // Função para atualizar sugestões de comunidades
            async function refreshSuggestions() {
                try {
                    const response = await fetch('/suggested-communities', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateSuggestionsDisplay(data.suggestedSubreddits);
                    } else {
                        console.error('Erro ao carregar sugestões:', response.statusText);
                    }
                } catch (error) {
                    console.error('Erro ao atualizar sugestões:', error);
                }
            }

            // Função para atualizar a exibição das sugestões
            function updateSuggestionsDisplay(suggestedSubreddits) {
                const suggestionsContainer = document.querySelector('.suggested-communities-list');
                if (!suggestedSubreddits || !suggestionsContainer) return;

                const icons = ['🎨', '🔥', '🌱', '💻', '⚡', '🚀', '💡', '🎯', '🌟', '🎪'];

                suggestionsContainer.innerHTML = suggestedSubreddits.map(subreddit => {
                    const icon = icons[Math.floor(Math.random() * icons.length)];
                    return `
                        <a
                            href="/communities/${subreddit.slug}"
                            style="
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                padding: 0.75rem;
                                border-radius: 0.5rem;
                                text-decoration: none;
                                color: inherit;
                            "
                            onmouseover="this.style.backgroundColor='#374151'"
                            onmouseout="this.style.backgroundColor='transparent'"
                        >
                            <div style="display: flex; align-items: center; gap: 0.75rem">
                                <span style="font-size: 1.125rem">${icon}</span>
                                <span style="color: #e5e7eb">${subreddit.name}</span>
                            </div>
                            <div
                                style="
                                    display: flex;
                                    flex-direction: column;
                                    align-items: flex-end;
                                    gap: 0.25rem;
                                "
                            >
                                <span style="color: #9ca3af; font-size: 0.875rem">
                                    +${subreddit.posts_count} posts
                                </span>
                                <span style="color: #6b7280; font-size: 0.75rem">
                                    ${subreddit.followers_count} seguidores
                                </span>
                            </div>
                        </a>
                    `;
                }).join('');
            }
        </script>

        <!-- CSS para animações de votação -->
        <style>
            @keyframes pulse-glow {
                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); /* Green */
                }
                50% {
                    box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1); /* Green */
                }
            }

            @keyframes pulse-glow-red {
                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); /* Red */
                }
                50% {
                    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1); /* Red */
                }
            }

            .vote-count.updated {
                animation: number-bounce 0.6s ease-in-out;
            }

            @keyframes number-bounce {
                0%,
                100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.2);
                }
            }
        </style>

        <!-- Comments Modal -->
        <div
            id="commentsModal"
            style="
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                z-index: 1000;
                overflow-y: auto;
            "
        >
            <div
                style="
                    position: relative;
                    max-width: 800px;
                    margin: 2rem auto;
                    background-color: #1f2937;
                    border-radius: 0.75rem;
                    border: 1px solid #374151;
                    max-height: 90vh;
                    overflow: hidden;
                "
            >
                <!-- Modal Header -->
                <div
                    style="
                        padding: 1.5rem;
                        border-bottom: 1px solid #374151;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                    "
                >
                    <h3 id="modalTitle" style="font-size: 1.25rem; font-weight: 600; color: #f9fafb; margin: 0">
                        Comentários
                    </h3>
                    <button
                        onclick="closeCommentsModal()"
                        style="
                            background: none;
                            border: none;
                            color: #9ca3af;
                            cursor: pointer;
                            padding: 0.5rem;
                            border-radius: 0.5rem;
                            transition: all 0.2s;
                        "
                        onmouseover="this.style.backgroundColor='#374151'; this.style.color='#f9fafb'"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af'"
                    >
                        <svg
                            style="width: 1.5rem; height: 1.5rem"
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
                </div>

                <!-- Modal Content -->
                <div style="padding: 1.5rem; max-height: 60vh; overflow-y: auto">
                    <!-- Comment Form -->
                    @auth
                        <div style="margin-bottom: 2rem">
                            <form id="commentForm" onsubmit="submitComment(event)">
                                <textarea
                                    id="commentContent"
                                    placeholder="Adicione um comentário..."
                                    style="
                                        width: 100%;
                                        min-height: 100px;
                                        padding: 0.75rem;
                                        background-color: #374151;
                                        border: 1px solid #4b5563;
                                        border-radius: 0.5rem;
                                        color: #f9fafb;
                                        resize: vertical;
                                        font-family: inherit;
                                    "
                                    required
                                ></textarea>
                                <div style="margin-top: 1rem; display: flex; justify-content: flex-end; gap: 0.75rem">
                                    <button
                                        type="button"
                                        onclick="closeCommentsModal()"
                                        style="
                                            padding: 0.5rem 1rem;
                                            background-color: #374151;
                                            color: #d1d5db;
                                            border: none;
                                            border-radius: 0.5rem;
                                            cursor: pointer;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.backgroundColor='#4b5563'"
                                        onmouseout="this.style.backgroundColor='#374151'"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        style="
                                            padding: 0.5rem 1rem;
                                            background-color: #2563eb;
                                            color: white;
                                            border: none;
                                            border-radius: 0.5rem;
                                            cursor: pointer;
                                            transition: all 0.2s;
                                        "
                                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                                        onmouseout="this.style.backgroundColor='#2563eb'"
                                    >
                                        Comentar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div
                            style="
                                text-align: center;
                                padding: 2rem;
                                background-color: #374151;
                                border-radius: 0.5rem;
                                margin-bottom: 2rem;
                            "
                        >
                            <p style="color: #9ca3af; margin-bottom: 1rem">Você precisa fazer login para comentar</p>
                            <a
                                href="{{ route('login') }}"
                                style="
                                    display: inline-block;
                                    padding: 0.5rem 1rem;
                                    background-color: #2563eb;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 0.5rem;
                                    transition: all 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#1d4ed8'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                            >
                                Fazer Login
                            </a>
                        </div>
                    @endauth

                    <!-- Comments List -->
                    <div id="commentsList">
                        <div style="text-align: center; color: #9ca3af; padding: 2rem">Carregando comentários...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão Flutuante de Criar Comunidade -->
        @auth
            <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1000">
                <a
                    href="{{ route('subreddit.create') }}"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        background: linear-gradient(135deg, #10b981, #059669);
                        color: white;
                        padding: 1rem 1.5rem;
                        border-radius: 2rem;
                        text-decoration: none;
                        font-weight: 600;
                        font-size: 1rem;
                        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
                        transition: all 0.3s ease;
                        animation: pulse-glow 2s infinite;
                    "
                    onmouseover="
                        this.style.transform='translateY(-3px) scale(1.05)';
                        this.style.boxShadow='0 20px 40px -5px rgba(16, 185, 129, 0.6)';
                        this.style.animation='none';
                    "
                    onmouseout="
                        this.style.transform='translateY(0) scale(1)';
                        this.style.boxShadow='0 10px 25px -5px rgba(16, 185, 129, 0.4)';
                        this.style.animation='pulse-glow 2s infinite';
                    "
                >
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                        ></path>
                    </svg>
                    <span>Criar Comunidade</span>
                </a>
            </div>

            <style>
                @keyframes pulse-glow {
                    0%,
                    100% {
                        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
                    }
                    50% {
                        box-shadow:
                            0 10px 25px -5px rgba(16, 185, 129, 0.6),
                            0 0 0 10px rgba(16, 185, 129, 0.1);
                    }
                }
            </style>
        @endauth
    </body>
</html>

<?php
