<?php

declare(strict_types=1);

?>
@props(['subreddits' => collect()])

<aside class="space-y-6">
    <!-- Popular Communities -->
    <div class="rounded-lg border bg-white shadow-sm">
        <div class="border-b p-4">
            <h2 class="font-semibold text-gray-900">Comunidades Populares</h2>
        </div>
        <div class="p-2">
            @forelse ($subreddits as $subreddit)
                <a
                    href="{{ route('subreddit.show', $subreddit->slug) }}"
                    class="flex items-center rounded p-2 transition-colors hover:bg-gray-50"
                >
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold text-white"
                        style="background-color: {{ $subreddit->color }}"
                    >
                        {{ strtoupper(substr($subreddit->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="font-medium text-gray-900">r/{{ $subreddit->slug }}</div>
                        <div class="text-sm text-gray-500">{{ $subreddit->posts_count }} posts</div>
                    </div>
                </a>
            @empty
                <p class="p-4 text-sm text-gray-500">Nenhuma comunidade encontrada.</p>
            @endforelse
        </div>
    </div>

    <!-- About -->
    <div class="rounded-lg border bg-white shadow-sm">
        <div class="border-b p-4">
            <h2 class="font-semibold text-gray-900">Sobre</h2>
        </div>
        <div class="p-4">
            <p class="text-sm leading-relaxed text-gray-600">
                Este é um clone do Reddit desenvolvido com Laravel 12 e FilamentPHP 4 para o processo seletivo da
                3Pontos Tech.
            </p>
            <div class="mt-4 border-t pt-4">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Desenvolvido com ❤️</span>
                    <span>Laravel {{ app()->version() }}</span>
                </div>
            </div>
        </div>
    </div>
</aside>
<?php 
