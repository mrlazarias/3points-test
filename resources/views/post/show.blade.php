<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ $post->title }} - r/{{ $post->subreddit->slug }}</title>
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
                    <a
                        href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                        style="color: #9ca3af; text-decoration: none; font-size: 0.875rem"
                        onmouseover="this.style.color='#f9fafb'"
                        onmouseout="this.style.color='#9ca3af'"
                    >
                        ← Voltar para r/{{ $post->subreddit->slug }}
                    </a>

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
            <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem">
                <!-- Main Content - Post Details -->
                <div>
                    <article
                        style="
                            background-color: #1f2937;
                            border: 1px solid #374151;
                            border-radius: 0.75rem;
                            overflow: hidden;
                            margin-bottom: 1.5rem;
                        "
                    >
                        <div style="padding: 1.5rem">
                            <!-- Post Header -->
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem">
                                <div
                                    style="
                                        width: 3rem;
                                        height: 3rem;
                                        border-radius: 50%;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-size: 1.25rem;
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
                                        <span style="color: #9ca3af">Por {{ $post->user->name }}</span>
                                        <span style="color: #6b7280">•</span>
                                        <span style="color: #9ca3af">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Post Title -->
                            <h1 style="font-size: 1.5rem; font-weight: bold; margin: 0 0 1rem 0">
                                {{ $post->title }}
                            </h1>

                            <!-- Post Content -->
                            @if ($post->content)
                                <div style="color: #d1d5db; line-height: 1.6; margin-bottom: 1.5rem">
                                    {!! \Illuminate\Support\Str::markdown($post->content) !!}
                                </div>
                            @endif

                            @if ($post->type === 'link' && $post->url)
                                <div style="margin-bottom: 1.5rem">
                                    <a
                                        href="{{ $post->url }}"
                                        target="_blank"
                                        style="
                                            display: inline-flex;
                                            align-items: center;
                                            padding: 0.75rem 1rem;
                                            background-color: #2563eb;
                                            color: white;
                                            border-radius: 0.5rem;
                                            text-decoration: none;
                                            font-size: 0.875rem;
                                        "
                                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                                        onmouseout="this.style.backgroundColor='#2563eb'"
                                    >
                                        <svg
                                            style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                            ></path>
                                        </svg>
                                        Acessar link: {{ parse_url($post->url, PHP_URL_HOST) }}
                                    </a>
                                </div>
                            @endif

                            <!-- Post Actions -->
                            <div
                                style="
                                    display: flex;
                                    align-items: center;
                                    gap: 1.5rem;
                                    border-top: 1px solid #374151;
                                    padding-top: 1rem;
                                "
                            >
                                <div style="display: flex; align-items: center; gap: 0.5rem">
                                    @auth
                                        <button
                                            onclick="votePost({{ $post->id }}, 'up')"
                                            id="upvote-{{ $post->id }}"
                                            style="
                                                padding: 0.5rem;
                                                color: #9ca3af;
                                                border-radius: 0.5rem;
                                                background: none;
                                                border: none;
                                                cursor: pointer;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.backgroundColor='#16a34a'; this.style.color='white'"
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
                                                    d="M5 15l7-7 7 7"
                                                ></path>
                                            </svg>
                                        </button>
                                    @else
                                        <button
                                            onclick="showLoginAlert()"
                                            style="
                                                padding: 0.5rem;
                                                color: #9ca3af;
                                                border-radius: 0.5rem;
                                                background: none;
                                                border: none;
                                                cursor: pointer;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.backgroundColor='#16a34a'; this.style.color='white'"
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
                                                    d="M5 15l7-7 7 7"
                                                ></path>
                                            </svg>
                                        </button>
                                    @endauth

                                    <span
                                        id="vote-score-{{ $post->id }}"
                                        style="
                                            font-size: 0.875rem;
                                            font-weight: 500;
                                            min-width: 2rem;
                                            text-align: center;
                                        "
                                    >
                                        {{ $post->vote_score }}
                                    </span>

                                    @auth
                                        <button
                                            onclick="votePost({{ $post->id }}, 'down')"
                                            id="downvote-{{ $post->id }}"
                                            style="
                                                padding: 0.5rem;
                                                color: #9ca3af;
                                                border-radius: 0.5rem;
                                                background: none;
                                                border: none;
                                                cursor: pointer;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.backgroundColor='#dc2626'; this.style.color='white'"
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
                                                    d="M19 9l-7 7-7-7"
                                                ></path>
                                            </svg>
                                        </button>
                                    @else
                                        <button
                                            onclick="showLoginAlert()"
                                            style="
                                                padding: 0.5rem;
                                                color: #9ca3af;
                                                border-radius: 0.5rem;
                                                background: none;
                                                border: none;
                                                cursor: pointer;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.backgroundColor='#dc2626'; this.style.color='white'"
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
                                                    d="M19 9l-7 7-7-7"
                                                ></path>
                                            </svg>
                                        </button>
                                    @endauth
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
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        ></path>
                                    </svg>
                                    <span style="color: #9ca3af; font-size: 0.875rem">
                                        {{ $post->comment_count }} comentários
                                    </span>
                                </div>

                                <button
                                    style="
                                        padding: 0.5rem 1rem;
                                        background-color: #2563eb;
                                        color: white;
                                        border-radius: 0.5rem;
                                        border: none;
                                        font-size: 0.875rem;
                                        cursor: pointer;
                                    "
                                    onmouseover="this.style.backgroundColor='#1d4ed8'"
                                    onmouseout="this.style.backgroundColor='#2563eb'"
                                >
                                    Comentar
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Comments Section -->
                    <div
                        style="
                            background-color: #1f2937;
                            border: 1px solid #374151;
                            border-radius: 0.75rem;
                            padding: 1.5rem;
                        "
                    >
                        <h2 style="font-size: 1.25rem; font-weight: bold; margin: 0 0 1rem 0">
                            Comentários ({{ $comments->count() }})
                        </h2>

                        @forelse ($comments as $comment)
                            <div
                                style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #374151; last-child: border-bottom: none"
                            >
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem">
                                    <div
                                        style="
                                            width: 2rem;
                                            height: 2rem;
                                            background-color: #374151;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        "
                                    >
                                        <span style="font-size: 0.875rem; color: white">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span style="font-weight: 500; color: #d1d5db">
                                            {{ $comment->user->name }}
                                        </span>
                                        <span style="color: #6b7280; font-size: 0.875rem; margin-left: 0.5rem">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div style="color: #d1d5db; line-height: 1.6; margin-bottom: 0.75rem">
                                    {!! \Illuminate\Support\Str::markdown($comment->content) !!}
                                </div>
                                <div style="display: flex; align-items: center; gap: 1rem">
                                    <div style="display: flex; align-items: center; gap: 0.5rem">
                                        @auth
                                            <button
                                                onclick="voteComment({{ $comment->id }}, 'up')"
                                                id="upvote-comment-{{ $comment->id }}"
                                                style="
                                                    padding: 0.25rem;
                                                    color: #9ca3af;
                                                    border-radius: 0.25rem;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                    transition: all 0.2s;
                                                "
                                                onmouseover="this.style.backgroundColor='#16a34a'; this.style.color='white'"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af'"
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
                                                        d="M5 15l7-7 7 7"
                                                    ></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button
                                                onclick="showLoginAlert()"
                                                style="
                                                    padding: 0.25rem;
                                                    color: #9ca3af;
                                                    border-radius: 0.25rem;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                    transition: all 0.2s;
                                                "
                                                onmouseover="this.style.backgroundColor='#16a34a'; this.style.color='white'"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af'"
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
                                                        d="M5 15l7-7 7 7"
                                                    ></path>
                                                </svg>
                                            </button>
                                        @endauth

                                        <span
                                            id="vote-score-comment-{{ $comment->id }}"
                                            style="font-size: 0.75rem; min-width: 1.5rem; text-align: center"
                                        >
                                            {{ $comment->vote_score }}
                                        </span>

                                        @auth
                                            <button
                                                onclick="voteComment({{ $comment->id }}, 'down')"
                                                id="downvote-comment-{{ $comment->id }}"
                                                style="
                                                    padding: 0.25rem;
                                                    color: #9ca3af;
                                                    border-radius: 0.25rem;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                    transition: all 0.2s;
                                                "
                                                onmouseover="this.style.backgroundColor='#dc2626'; this.style.color='white'"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af'"
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
                                                        d="M19 9l-7 7-7-7"
                                                    ></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button
                                                onclick="showLoginAlert()"
                                                style="
                                                    padding: 0.25rem;
                                                    color: #9ca3af;
                                                    border-radius: 0.25rem;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                    transition: all 0.2s;
                                                "
                                                onmouseover="this.style.backgroundColor='#dc2626'; this.style.color='white'"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af'"
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
                                                        d="M19 9l-7 7-7-7"
                                                    ></path>
                                                </svg>
                                            </button>
                                        @endauth
                                    </div>

                                    @auth
                                        <button
                                            onclick="toggleReplyForm({{ $comment->id }})"
                                            style="
                                                color: #9ca3af;
                                                background: none;
                                                border: none;
                                                font-size: 0.875rem;
                                                cursor: pointer;
                                            "
                                            onmouseover="this.style.color='#f9fafb'"
                                            onmouseout="this.style.color='#9ca3af'"
                                        >
                                            Responder
                                        </button>
                                    @else
                                        <button
                                            onclick="showLoginAlert()"
                                            style="
                                                color: #9ca3af;
                                                background: none;
                                                border: none;
                                                font-size: 0.875rem;
                                                cursor: pointer;
                                            "
                                            onmouseover="this.style.color='#f9fafb'"
                                            onmouseout="this.style.color='#9ca3af'"
                                        >
                                            Responder
                                        </button>
                                    @endauth
                                </div>
                            </div>

                            <!-- Formulário de Resposta (oculto por padrão) -->
                            <div
                                id="reply-form-{{ $comment->id }}"
                                style="
                                    display: none;
                                    margin-top: 1rem;
                                    padding-top: 1rem;
                                    border-top: 1px solid #374151;
                                "
                            >
                                <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                    @csrf
                                    <textarea
                                        name="content"
                                        rows="3"
                                        style="
                                            width: 100%;
                                            padding: 0.75rem;
                                            background-color: #374151;
                                            border: 1px solid #4b5563;
                                            border-radius: 0.5rem;
                                            color: #f9fafb;
                                            font-size: 0.875rem;
                                            resize: vertical;
                                            min-height: 4rem;
                                        "
                                        placeholder="Responder para {{ $comment->user->name }}..."
                                        required
                                    >
{{ old('content') }}</textarea
                                    >
                                    @error('content')
                                        <p style="color: #ef4444; font-size: 0.875rem; margin: 0.5rem 0 0 0">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div style="display: flex; justify-end; gap: 0.75rem; margin-top: 0.75rem">
                                        <button
                                            type="button"
                                            onclick="toggleReplyForm({{ $comment->id }})"
                                            style="
                                                padding: 0.5rem 1rem;
                                                background-color: #374151;
                                                color: #9ca3af;
                                                border: none;
                                                border-radius: 0.5rem;
                                                font-size: 0.875rem;
                                                cursor: pointer;
                                                transition: background-color 0.2s;
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
                                                font-size: 0.875rem;
                                                cursor: pointer;
                                                transition: background-color 0.2s;
                                            "
                                            onmouseover="this.style.backgroundColor='#1d4ed8'"
                                            onmouseout="this.style.backgroundColor='#2563eb'"
                                        >
                                            Responder
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 2rem">
                                <p style="color: #9ca3af; margin: 0">Nenhum comentário ainda.</p>
                                <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 0">
                                    Seja o primeiro a comentar!
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Formulário de Comentário -->
                    @auth
                        <div
                            style="
                                background-color: #1f2937;
                                border: 1px solid #374151;
                                border-radius: 0.75rem;
                                padding: 1.5rem;
                                margin-top: 1.5rem;
                            "
                        >
                            <h3 style="font-size: 1.125rem; font-weight: 500; margin: 0 0 1rem 0">
                                Adicionar Comentário
                            </h3>
                            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                @csrf
                                <textarea
                                    name="content"
                                    rows="4"
                                    style="
                                        width: 100%;
                                        padding: 0.75rem;
                                        background-color: #374151;
                                        border: 1px solid #4b5563;
                                        border-radius: 0.5rem;
                                        color: #f9fafb;
                                        font-size: 0.875rem;
                                        resize: vertical;
                                        min-height: 6rem;
                                    "
                                    placeholder="Digite seu comentário..."
                                    required
                                >
{{ old('content') }}</textarea
                                >
                                @error('content')
                                    <p style="color: #ef4444; font-size: 0.875rem; margin: 0.5rem 0 0 0">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <div style="display: flex; justify-end; margin-top: 1rem">
                                    <button
                                        type="submit"
                                        style="
                                            padding: 0.75rem 1.5rem;
                                            background-color: #2563eb;
                                            color: white;
                                            border: none;
                                            border-radius: 0.5rem;
                                            font-size: 0.875rem;
                                            font-weight: 500;
                                            cursor: pointer;
                                            transition: background-color 0.2s;
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
                                background-color: #1f2937;
                                border: 1px solid #374151;
                                border-radius: 0.75rem;
                                padding: 1.5rem;
                                margin-top: 1.5rem;
                                text-align: center;
                            "
                        >
                            <p style="color: #9ca3af; margin: 0 0 1rem 0">Faça login para comentar</p>
                            <div style="display: flex; gap: 0.75rem; justify-content: center">
                                <a
                                    href="{{ route('login') }}"
                                    style="
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
                                    Entrar
                                </a>
                                <a
                                    href="{{ route('register') }}"
                                    style="
                                        padding: 0.75rem 1.5rem;
                                        background-color: #374151;
                                        color: white;
                                        text-decoration: none;
                                        border-radius: 0.5rem;
                                        font-size: 0.875rem;
                                        font-weight: 500;
                                        transition: background-color 0.2s;
                                    "
                                    onmouseover="this.style.backgroundColor='#4b5563'"
                                    onmouseout="this.style.backgroundColor='#374151'"
                                >
                                    Registrar
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Sidebar -->
                <div>
                    <div
                        style="
                            background-color: #1f2937;
                            border: 1px solid #374151;
                            border-radius: 0.75rem;
                            padding: 1.5rem;
                        "
                    >
                        <h3 style="font-weight: 500; color: #e5e7eb; margin: 0 0 1rem 0">
                            Sobre r/{{ $post->subreddit->slug }}
                        </h3>
                        <p style="color: #9ca3af; font-size: 0.875rem; line-height: 1.5; margin: 0 0 1rem 0">
                            {{ $post->subreddit->description }}
                        </p>
                        <div style="border-top: 1px solid #374151; padding-top: 1rem">
                            <p style="color: #6b7280; font-size: 0.75rem; margin: 0">
                                Criado por {{ $post->subreddit->creator->name }} em
                                {{ $post->subreddit->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript para funcionalidade de votação -->
        <script>
            // CSRF Token para requisições AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Função para votar em posts
            async function votePost(postId, voteType) {
                try {
                    const response = await fetch('{{ route('vote') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            Accept: 'application/json',
                        },
                        body: JSON.stringify({
                            voteable_type: 'post',
                            voteable_id: postId,
                            vote_type: voteType,
                        }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Atualizar o score do voto
                        const scoreElement = document.getElementById(`vote-score-${postId}`);
                        if (scoreElement) {
                            scoreElement.textContent = data.vote_score;
                        }

                        // Atualizar visual dos botões
                        updateVoteButtons(postId, data.vote_type, data.action);
                    } else {
                        console.error('Erro ao votar:', data.message);
                        alert('Erro ao votar. Tente novamente.');
                    }
                } catch (error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro de conexão. Tente novamente.');
                }
            }

            // Função para votar em comentários
            async function voteComment(commentId, voteType) {
                try {
                    const response = await fetch('{{ route('vote') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            Accept: 'application/json',
                        },
                        body: JSON.stringify({
                            voteable_type: 'comment',
                            voteable_id: commentId,
                            vote_type: voteType,
                        }),
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Atualizar o score do voto
                        const scoreElement = document.getElementById(`vote-score-comment-${commentId}`);
                        if (scoreElement) {
                            scoreElement.textContent = data.vote_score;
                        }

                        // Atualizar visual dos botões
                        updateCommentVoteButtons(commentId, data.vote_type, data.action);
                    } else {
                        console.error('Erro ao votar:', data.message);
                        alert('Erro ao votar. Tente novamente.');
                    }
                } catch (error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro de conexão. Tente novamente.');
                }
            }

            // Função para atualizar visual dos botões de votação de posts
            function updateVoteButtons(postId, voteType, action) {
                const upButton = document.getElementById(`upvote-${postId}`);
                const downButton = document.getElementById(`downvote-${postId}`);

                // Resetar todos os botões
                if (upButton) {
                    upButton.style.color = '#9ca3af';
                    upButton.style.backgroundColor = 'transparent';
                }
                if (downButton) {
                    downButton.style.color = '#9ca3af';
                    downButton.style.backgroundColor = 'transparent';
                }

                // Aplicar estilo baseado na ação
                if (action === 'removed') {
                    return;
                }

                if (voteType === 'up' && upButton) {
                    upButton.style.color = '#10b981';
                    upButton.style.backgroundColor = '#064e3b';
                } else if (voteType === 'down' && downButton) {
                    downButton.style.color = '#ef4444';
                    downButton.style.backgroundColor = '#7f1d1d';
                }
            }

            // Função para atualizar visual dos botões de votação de comentários
            function updateCommentVoteButtons(commentId, voteType, action) {
                const upButton = document.getElementById(`upvote-comment-${commentId}`);
                const downButton = document.getElementById(`downvote-comment-${commentId}`);

                // Resetar todos os botões
                if (upButton) {
                    upButton.style.color = '#9ca3af';
                    upButton.style.backgroundColor = 'transparent';
                }
                if (downButton) {
                    downButton.style.color = '#9ca3af';
                    downButton.style.backgroundColor = 'transparent';
                }

                // Aplicar estilo baseado na ação
                if (action === 'removed') {
                    return;
                }

                if (voteType === 'up' && upButton) {
                    upButton.style.color = '#10b981';
                    upButton.style.backgroundColor = '#064e3b';
                } else if (voteType === 'down' && downButton) {
                    downButton.style.color = '#ef4444';
                    downButton.style.backgroundColor = '#7f1d1d';
                }
            }

            // Função para mostrar alerta de login
            function showLoginAlert() {
                alert('Você precisa fazer login para votar. Redirecionando...');
                window.location.href = '{{ route('login') }}';
            }

            // Função para alternar formulário de resposta
            function toggleReplyForm(commentId) {
                const form = document.getElementById(`reply-form-${commentId}`);
                if (form) {
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                }
            }
        </script>
    </body>
</html>

<?php
