<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <title>{{ $post->title }} - r/{{ $post->subreddit->slug }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }

            /* Estilos para o conteúdo do post */
            .prose {
                color: #f9fafb !important; /* text-white */
            }

            .prose h1,
            .prose h2,
            .prose h3,
            .prose h4,
            .prose h5,
            .prose h6 {
                color: #f9fafb !important; /* text-white */
            }

            .prose p {
                color: #f9fafb !important; /* text-white */
            }

            .prose ul,
            .prose ol {
                color: #f9fafb !important; /* text-white */
            }

            .prose li {
                color: #f9fafb !important; /* text-white */
            }

            .prose strong {
                color: #f9fafb !important; /* text-white */
                font-weight: 600;
            }

            .prose em {
                color: #d1d5db !important; /* text-gray-300 */
                font-style: italic;
            }

            .prose code {
                background-color: #374151 !important; /* bg-gray-700 */
                color: #93c5fd !important; /* text-blue-300 */
                padding: 0.2em 0.4em;
                border-radius: 0.3rem;
                font-size: 0.875em;
            }

            .prose pre {
                background-color: #1f2937 !important; /* bg-gray-800 */
                color: #e5e7eb !important; /* text-gray-200 */
                padding: 1rem;
                border-radius: 0.5rem;
                overflow-x: auto;
            }

            .prose a {
                color: #60a5fa !important; /* text-blue-400 */
                text-decoration: underline;
            }

            .prose a:hover {
                color: #93c5fd !important; /* text-blue-300 */
            }
        </style>
    </head>
    <body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 antialiased">
        <!-- Header -->
        <header class="border-b border-slate-700/50 bg-slate-900/80 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="/" class="group flex items-center space-x-3">
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-r from-orange-500 to-red-500 shadow-lg transition-all duration-300 group-hover:shadow-orange-500/25"
                            >
                                <span class="text-sm font-bold text-white">3P</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-semibold text-white">3Pontos</span>
                                <span class="text-xs text-slate-400">Community</span>
                            </div>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a
                            href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                            class="flex items-center space-x-2 text-sm text-slate-400 transition-colors hover:text-white"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                ></path>
                            </svg>
                            <span>Voltar para r/{{ $post->subreddit->slug }}</span>
                        </a>

                        @auth
                            <div class="flex items-center space-x-3">
                                <a
                                    href="{{ route('profile.show') }}"
                                    class="flex items-center space-x-2 text-sm text-slate-300 transition-colors hover:text-white"
                                >
                                    @if (Auth::user()->getFirstMedia('profile-pictures'))
                                        <img
                                            src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl('') }}"
                                            alt="Foto de perfil"
                                            class="h-6 w-6 rounded-full border border-slate-600 object-cover"
                                        />
                                    @else
                                        <div
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white"
                                        >
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
                                    >
                                        Sair
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-3">
                                <a
                                    href="{{ route('login') }}"
                                    class="rounded-lg bg-slate-700 px-4 py-2 text-sm font-medium text-slate-300 transition-colors hover:bg-slate-600 hover:text-white"
                                >
                                    Entrar
                                </a>
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                >
                                    Registrar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                    <!-- Sidebar - Community Info -->
                    <div class="lg:col-span-1">
                        <!-- Community Card -->
                        <div
                            class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-xl backdrop-blur-sm"
                        >
                            <div class="mb-6 flex items-center space-x-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl shadow-lg"
                                    style="background-color: {{ $post->subreddit->color }}"
                                >
                                    <span class="text-lg font-bold text-white">r/</span>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">r/{{ $post->subreddit->name }}</h2>
                                    <p class="text-sm text-slate-400">{{ $post->subreddit->description }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-400">Membros</span>
                                    <span class="text-sm font-medium text-white">
                                        {{ $post->subreddit->posts_count }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-400">Posts</span>
                                    <span class="text-sm font-medium text-white">
                                        {{ $post->subreddit->posts_count }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-400">Criado em</span>
                                    <span class="text-sm font-medium text-white">
                                        {{ $post->subreddit->created_at->format('M Y') }}
                                    </span>
                                </div>
                            </div>

                            @auth
                                <div class="mt-6">
                                    <a
                                        href="{{ route('post.create', $post->subreddit->slug) }}"
                                        class="block w-full rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-center text-sm font-medium text-white shadow-lg transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:shadow-blue-500/25"
                                    >
                                        + Criar Post
                                    </a>
                                </div>
                            @else
                                <div class="mt-6">
                                    <a
                                        href="{{ route('login') }}"
                                        class="block w-full rounded-xl bg-slate-700 px-4 py-3 text-center text-sm font-medium text-slate-300 transition-colors hover:bg-slate-600 hover:text-white"
                                    >
                                        + Criar Post
                                    </a>
                                </div>
                            @endauth
                        </div>

                        <!-- Community Rules -->
                        <div
                            class="mt-6 rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-xl backdrop-blur-sm"
                        >
                            <h3 class="mb-4 text-lg font-semibold text-white">Regras da Comunidade</h3>
                            <ul class="space-y-2 text-sm text-slate-400">
                                <li class="flex items-start space-x-2">
                                    <span class="mt-1 text-blue-400">•</span>
                                    <span>Seja respeitoso com outros membros</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <span class="mt-1 text-blue-400">•</span>
                                    <span>Use títulos descritivos</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <span class="mt-1 text-blue-400">•</span>
                                    <span>Não faça spam</span>
                                </li>
                                <li class="flex items-start space-x-2">
                                    <span class="mt-1 text-blue-400">•</span>
                                    <span>Mantenha o conteúdo relevante</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Main Content - Post -->
                    <div class="lg:col-span-3">
                        <!-- Post Card -->
                        <article
                            class="mb-8 rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-2xl backdrop-blur-sm"
                        >
                            <div class="p-8">
                                <!-- Post Header -->
                                <div class="mb-6 flex items-center space-x-4">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl shadow-lg"
                                        style="background-color: {{ $post->subreddit->color }}"
                                    >
                                        <span class="text-lg font-bold text-white">r/</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <a
                                                href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                                                class="text-lg font-semibold text-blue-400 transition-colors hover:text-blue-300"
                                            >
                                                r/{{ $post->subreddit->slug }}
                                            </a>
                                            <span class="text-slate-400">•</span>
                                            <span class="text-sm text-slate-400">
                                                Postado por u/{{ $post->user->name }}
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Post Title -->
                                <h1 class="mb-6 text-3xl leading-tight font-bold text-white">{{ $post->title }}</h1>

                                <!-- Post Content -->
                                <div class="prose prose-invert prose-lg mb-8 max-w-none">
                                    @if ($post->type === 'text')
                                        {!! Str::markdown($post->content) !!}
                                    @elseif ($post->type === 'link')
                                        <div class="rounded-xl border border-slate-600 bg-slate-700/50 p-6">
                                            <a
                                                href="{{ $post->url }}"
                                                target="_blank"
                                                class="block text-blue-400 transition-colors hover:text-blue-300"
                                            >
                                                <div class="flex items-center space-x-3">
                                                    <svg
                                                        class="h-6 w-6"
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
                                                    <span class="text-lg font-medium">{{ $post->url }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @elseif ($post->type === 'image')
                                        <div class="overflow-hidden rounded-xl">
                                            <img
                                                src="{{ $post->url }}"
                                                alt="{{ $post->title }}"
                                                class="h-auto max-h-96 w-full object-cover"
                                            />
                                        </div>
                                    @endif
                                </div>

                                <!-- Post Actions -->
                                <div class="flex items-center justify-between border-t border-slate-700 pt-6">
                                    <div class="flex items-center space-x-6">
                                        <!-- Voting -->
                                        <div class="flex items-center space-x-2">
                                            <button
                                                onclick="vote({{ $post->id }}, 'post', 'up')"
                                                class="vote-btn rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-700 hover:text-orange-400"
                                                data-vote-type="up"
                                                data-target-id="{{ $post->id }}"
                                                data-target-type="post"
                                            >
                                                <svg
                                                    class="h-5 w-5"
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
                                            <span
                                                id="vote-score-{{ $post->id }}"
                                                class="text-sm font-medium text-white"
                                            >
                                                {{ $post->vote_score }}
                                            </span>
                                            <button
                                                onclick="vote({{ $post->id }}, 'post', 'down')"
                                                class="vote-btn rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-700 hover:text-blue-400"
                                                data-vote-type="down"
                                                data-target-id="{{ $post->id }}"
                                                data-target-type="post"
                                            >
                                                <svg
                                                    class="h-5 w-5"
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
                                        </div>

                                        <!-- Comments Count -->
                                        <div class="flex items-center space-x-2 text-slate-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                                ></path>
                                            </svg>
                                            <span class="text-sm">{{ $post->comment_count }} comentários</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <button
                                            class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-700 hover:text-white"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"
                                                ></path>
                                            </svg>
                                        </button>
                                        <button
                                            class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-700 hover:text-white"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
                                                ></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <!-- Comments Section -->
                        <div class="space-y-6">
                            <h2 class="text-2xl font-bold text-white">Comentários ({{ $post->comment_count }})</h2>

                            <!-- Comment Form -->
                            @auth
                                <div
                                    class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-xl backdrop-blur-sm"
                                >
                                    <h3 class="mb-4 text-lg font-semibold text-white">Adicionar Comentário</h3>
                                    <form action="{{ route('comments.store', $post->slug) }}" method="POST">
                                        @csrf
                                        <textarea
                                            name="content"
                                            rows="4"
                                            class="w-full rounded-xl border border-slate-600 bg-slate-700/50 px-4 py-3 text-white placeholder-slate-400 backdrop-blur-sm transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20"
                                            placeholder="Digite seu comentário..."
                                            required
                                        >
{{ old('content') }}</textarea
                                        >
                                        @error('content')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror

                                        <div class="mt-4 flex justify-end">
                                            <button
                                                type="submit"
                                                class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 font-medium text-white shadow-lg transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:shadow-blue-500/25"
                                            >
                                                Comentar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div
                                    class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 text-center shadow-xl backdrop-blur-sm"
                                >
                                    <p class="mb-4 text-slate-400">Faça login para comentar</p>
                                    <a
                                        href="{{ route('login') }}"
                                        class="inline-flex items-center rounded-xl bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700"
                                    >
                                        Entrar
                                    </a>
                                </div>
                            @endauth

                            <!-- Comments Sorting -->
                            <div class="mb-6 flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-white">
                                    Comentários ({{ $comments->count() }})
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-slate-400">Ordenar por:</span>
                                    <select
                                        id="comment-sort"
                                        class="rounded-lg border border-slate-600 bg-slate-700 px-3 py-1.5 text-sm text-white transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                        onchange="sortComments(this.value)"
                                    >
                                        <option value="top" {{ $sortBy === 'top' ? 'selected' : '' }}>
                                            Mais votados
                                        </option>
                                        <option value="new" {{ $sortBy === 'new' ? 'selected' : '' }}>
                                            Mais novos
                                        </option>
                                        <option value="old" {{ $sortBy === 'old' ? 'selected' : '' }}>
                                            Mais antigos
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Comments List -->
                            <div class="space-y-4">
                                @forelse ($comments as $comment)
                                    @include('components.comment', ['comment' => $comment, 'depth' => 0])
                                @empty
                                    <div
                                        class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-8 text-center shadow-xl backdrop-blur-sm"
                                    >
                                        <p class="text-slate-400">
                                            Nenhum comentário ainda. Seja o primeiro a comentar!
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            // Voting functionality
            async function vote(targetId, targetType, voteType) {
                try {
                    const response = await fetch('/vote', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            target_id: targetId,
                            target_type: targetType,
                            vote_type: voteType,
                        }),
                    });

                    if (response.ok) {
                        const data = await response.json();
                        document.getElementById(`vote-score-${targetId}`).textContent = data.vote_score;

                        // Update button states
                        const buttons = document.querySelectorAll(`[data-target-id="${targetId}"]`);
                        buttons.forEach((btn) => {
                            btn.classList.remove('bg-orange-500', 'bg-blue-500', 'text-white');
                            btn.classList.add('text-slate-400');
                        });

                        if (data.user_vote) {
                            const activeBtn = document.querySelector(
                                `[data-target-id="${targetId}"][data-vote-type="${data.user_vote}"]`,
                            );
                            if (activeBtn) {
                                activeBtn.classList.remove('text-slate-400');
                                activeBtn.classList.add(
                                    data.user_vote === 'up' ? 'bg-orange-500' : 'bg-blue-500',
                                    'text-white',
                                );
                            }
                        }
                    }
                } catch (error) {
                    console.error('Erro ao votar:', error);
                }
            }

            // Toggle reply form
            function toggleReplyForm(commentId) {
                const form = document.getElementById(`reply-form-${commentId}`);
                if (form) {
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                }
            }

            // Sort comments function
            function sortComments(sortBy) {
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.set('sort', sortBy);
                window.location.href = currentUrl.toString();
            }

            // Debug: verificar se a página carregou corretamente
            console.log('Página carregada, comentários:', {{ $comments->count() }});

            // Forçar atualização da página após comentário
            @if (session('commented'))
                // Scroll para os comentários após comentário
                setTimeout(() => {
                    document.querySelector('.space-y-4')?.scrollIntoView({ behavior: 'smooth' });
                }, 100);
            @endif

            // Load user votes on page load
            document.addEventListener('DOMContentLoaded', async function () {
                try {
                    const response = await fetch('/vote/user');
                    if (response.ok) {
                        const votes = await response.json();
                        votes.forEach((vote) => {
                            const button = document.querySelector(
                                `[data-target-id="${vote.target_id}"][data-vote-type="${vote.vote_type}"]`,
                            );
                            if (button) {
                                button.classList.remove('text-slate-400');
                                button.classList.add(
                                    vote.vote_type === 'up' ? 'bg-orange-500' : 'bg-blue-500',
                                    'text-white',
                                );
                            }
                        });
                    }
                } catch (error) {
                    console.error('Erro ao carregar votos:', error);
                }
            });
        </script>
    </body>
</html>
