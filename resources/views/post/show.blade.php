<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $post->title }} - r/{{ $post->subreddit->slug }}</title>
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
                    <a
                        href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                        class="text-gray-400 hover:text-white"
                    >
                        ← Voltar para r/{{ $post->subreddit->slug }}
                    </a>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
                        <span class="text-sm font-medium text-white">$</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-4xl px-6 py-8">
            <!-- Post -->
            <article class="mb-8 overflow-hidden rounded-xl border border-gray-700 bg-gray-800">
                <div class="p-6">
                    <!-- Post Header -->
                    <div class="mb-6 flex items-center space-x-3">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full text-xl font-bold text-white"
                            style="background-color: {{ $post->subreddit->color }}"
                        >
                            {{ strtoupper(substr($post->subreddit->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <a
                                    href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                                    class="font-medium text-blue-400 hover:underline"
                                >
                                    r/{{ $post->subreddit->slug }}
                                </a>
                                <span class="text-gray-500">•</span>
                                <span class="text-gray-400">Por {{ $post->user->name }}</span>
                                <span class="text-gray-500">•</span>
                                <span class="text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <h1 class="mb-4 text-2xl font-bold text-white">{{ $post->title }}</h1>

                    @if ($post->content)
                        <div class="prose prose-invert mb-6 max-w-none">
                            {!! \Illuminate\Support\Str::markdown($post->content) !!}
                        </div>
                    @endif

                    @if ($post->type === 'link' && $post->url)
                        <div class="mb-6">
                            <a
                                href="{{ $post->url }}"
                                target="_blank"
                                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-3 text-white transition-colors hover:bg-blue-700"
                            >
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="flex items-center space-x-6 border-t border-gray-700 pt-4">
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

                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                ></path>
                            </svg>
                            <span class="text-sm text-gray-400">{{ $post->comment_count }} comentários</span>
                        </div>

                        <button
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white transition-colors hover:bg-blue-700"
                        >
                            Comentar
                        </button>
                    </div>
                </div>
            </article>

            <!-- Comments Section -->
            <div class="space-y-4">
                <h2 class="text-xl font-bold">Comentários</h2>

                @forelse ($comments as $comment)
                    <div class="rounded-xl border border-gray-700 bg-gray-800 p-6">
                        <div class="mb-3 flex items-center space-x-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-700">
                                <span class="text-sm">👤</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-300">{{ $comment->user->name }}</span>
                                <span class="ml-2 text-sm text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="prose prose-invert mb-4 max-w-none">
                            {!! \Illuminate\Support\Str::markdown($comment->content) !!}
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <button
                                    class="rounded p-1 text-gray-400 transition-colors hover:bg-green-400/10 hover:text-green-400"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 15l7-7 7 7"
                                        ></path>
                                    </svg>
                                </button>
                                <span class="text-sm">{{ $comment->vote_score }}</span>
                                <button
                                    class="rounded p-1 text-gray-400 transition-colors hover:bg-red-400/10 hover:text-red-400"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"
                                        ></path>
                                    </svg>
                                </button>
                            </div>

                            <button class="text-sm text-gray-400 hover:text-white">Responder</button>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-gray-700 bg-gray-800 p-8 text-center">
                        <p class="text-gray-400">Nenhum comentário ainda.</p>
                        <p class="mt-2 text-sm text-gray-500">Seja o primeiro a comentar!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </body>
</html>
<?php 
