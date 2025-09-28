<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>3Pontos Community</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-900 text-white">
        <!-- Header -->
        <header class="border-b border-gray-700 bg-gray-800 px-6 py-4">
            <div class="mx-auto flex max-w-7xl items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-500">
                            <span class="text-sm font-bold text-white">3P</span>
                        </div>
                        <span class="text-xl font-semibold">3Pontos</span>
                        <span class="text-sm text-gray-400">Community</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="rounded-lg p-2 text-gray-400 hover:bg-gray-700 hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            ></path>
                        </svg>
                    </button>
                    <button class="rounded-lg p-2 text-gray-400 hover:bg-gray-700 hover:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"
                            ></path>
                        </svg>
                    </button>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
                        <span class="text-sm font-medium text-white">$</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-7xl px-6 py-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="mb-2 text-2xl font-bold">
                    Olá,
                    <span class="text-blue-400">$user</span>
                </h1>
                <p class="text-gray-400">Confira as estatísticas das comunidades que você segue</p>
            </div>

            <!-- Stats Cards -->
            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-xl border border-gray-700 bg-gray-800 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Quantidade de usuários</p>
                            <p class="text-2xl font-bold">10000</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-700 bg-gray-800 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Quantidade de posts</p>
                            <p class="text-2xl font-bold">{{ $posts->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-700 bg-gray-800 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Quantidade de replies</p>
                            <p class="text-2xl font-bold">10000</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Navigation -->
                    <nav class="mb-6">
                        <div class="mb-4 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                                ></path>
                            </svg>
                            <span class="font-medium text-white">Home</span>
                        </div>
                    </nav>

                    <!-- Communities -->
                    <div class="rounded-xl border border-gray-700 bg-gray-800">
                        <div class="border-b border-gray-700 p-4">
                            <h3 class="font-medium text-gray-200">Minhas comunidades</h3>
                        </div>
                        <div class="p-2">
                            @foreach ($subreddits as $subreddit)
                                @php
                                    $icons = ['🎨', '🔥', '🌱', '💻', '⚡'];
                                    $icon = $icons[array_rand($icons)];
                                @endphp

                                <a
                                    href="{{ route('subreddit.show', $subreddit->slug) }}"
                                    class="flex items-center justify-between rounded-lg p-3 transition-colors hover:bg-gray-700"
                                >
                                    <div class="flex items-center space-x-3">
                                        <span class="text-lg">{{ $icon }}</span>
                                        <span class="text-gray-200">{{ $subreddit->name }}</span>
                                    </div>
                                    <span class="text-sm text-gray-400">+{{ $subreddit->posts_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="mb-6">
                        <h2 class="mb-2 text-xl font-bold">Veja os últimos posts das comunidades que você segue</h2>
                    </div>

                    <div class="space-y-4">
                        @forelse ($posts as $post)
                            <article class="overflow-hidden rounded-xl border border-gray-700 bg-gray-800">
                                <div class="p-6">
                                    <!-- Post Header -->
                                    <div class="mb-4 flex items-center space-x-3">
                                        @php
                                            $icons = ['👨‍💻', '🔧', '🎯', '💡', '🚀'];
                                            $icon = $icons[array_rand($icons)];
                                        @endphp

                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-700"
                                        >
                                            <span class="text-lg">{{ $icon }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <span class="font-medium text-gray-300">
                                                    r/{{ $post->subreddit->slug }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <h3 class="mb-3 text-lg font-semibold text-white">{{ $post->title }}</h3>
                                    <p class="mb-4 leading-relaxed text-gray-300">
                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                    </p>

                                    <!-- Post Actions -->
                                    <div class="flex items-center space-x-6">
                                        <div class="flex items-center space-x-2">
                                            <button class="flex items-center space-x-1 text-gray-400 hover:text-white">
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
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                                    ></path>
                                                </svg>
                                                <span class="text-sm">{{ $post->comment_count }}</span>
                                            </button>
                                        </div>

                                        <div class="flex items-center space-x-2">
                                            <button
                                                class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-green-400/10 hover:text-green-400"
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
                                            <span class="text-sm font-medium">{{ $post->vote_score }}</span>
                                            <button
                                                class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-red-400/10 hover:text-red-400"
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

                                        <button
                                            class="rounded-lg bg-gray-700 px-4 py-2 text-sm text-gray-200 transition-colors hover:bg-gray-600"
                                        >
                                            Responder
                                        </button>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-xl border border-gray-700 bg-gray-800 p-8 text-center">
                                <p class="text-gray-400">Nenhum post encontrado.</p>
                                <p class="mt-2 text-sm text-gray-500">Seja o primeiro a compartilhar algo!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($posts->hasPages())
                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
