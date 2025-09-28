<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>r/{{ $subreddit->slug }} - 3Pontos Community</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-900 text-white">
        <!-- Header -->
        <header class="border-b border-gray-700 bg-gray-800 px-6 py-4">
            <div class="mx-auto flex max-w-7xl items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-500">
                            <span class="text-sm font-bold text-white">3P</span>
                        </div>
                        <span class="text-xl font-semibold">3Pontos</span>
                        <span class="text-sm text-gray-400">Community</span>
                    </a>
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
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
                        <span class="text-sm font-medium text-white">$</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-7xl px-6 py-8">
            <!-- Subreddit Header -->
            <div class="mb-8">
                <div class="mb-4 flex items-center space-x-4">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-full text-2xl font-bold text-white"
                        style="background-color: {{ $subreddit->color }}"
                    >
                        {{ strtoupper(substr($subreddit->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">r/{{ $subreddit->slug }}</h1>
                        <p class="text-gray-400">{{ $subreddit->description }}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-700 bg-gray-800 p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ $posts->total() }}</p>
                            <p class="text-sm text-gray-400">Posts</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ number_format(rand(1000, 5000)) }}</p>
                            <p class="text-sm text-gray-400">Membros</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">{{ $subreddit->created_at->format('Y') }}</p>
                            <p class="text-sm text-gray-400">Criado em</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts -->
            <div>
                <h2 class="mb-6 text-xl font-bold">Posts da comunidade</h2>

                <div class="space-y-4">
                    @forelse ($posts as $post)
                        <article class="overflow-hidden rounded-xl border border-gray-700 bg-gray-800">
                            <div class="p-6">
                                <!-- Post Header -->
                                <div class="mb-4 flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-700">
                                        <span class="text-lg">👨‍💻</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-gray-300">{{ $post->user->name }}</span>
                                            <span class="text-sm text-gray-500">
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Post Content -->
                                <h3 class="mb-3 text-lg font-semibold text-white">
                                    <a
                                        href="{{ route('post.show', [$subreddit->slug, $post->slug]) }}"
                                        class="hover:text-blue-400"
                                    >
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mb-4 leading-relaxed text-gray-300">
                                    {{ Str::limit(strip_tags($post->content), 200) }}
                                </p>

                                <!-- Post Actions -->
                                <div class="flex items-center space-x-6">
                                    <div class="flex items-center space-x-2">
                                        <button class="flex items-center space-x-1 text-gray-400 hover:text-white">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="text-gray-400">Nenhum post encontrado nesta comunidade.</p>
                            <p class="mt-2 text-sm text-gray-500">Seja o primeiro a postar aqui!</p>
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
    </body>
</html>
<?php 
