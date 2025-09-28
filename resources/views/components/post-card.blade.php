<?php

declare(strict_types=1);

?>
@props([
    'post',
])

<article class="p-6 transition-colors hover:bg-gray-50">
    <div class="flex space-x-4">
        <!-- Vote Section -->
        <div class="flex flex-col items-center space-y-2">
            <button class="rounded p-1 text-gray-400 hover:bg-orange-50 hover:text-orange-500">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
                </svg>
            </button>

            <span class="text-sm font-medium text-gray-700">
                {{ $post->vote_score }}
            </span>

            <button class="rounded p-1 text-gray-400 hover:bg-blue-50 hover:text-blue-500">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 20l-8-8h6V4h4v8h6l-8 8z" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="min-w-0 flex-1">
            <!-- Header -->
            <div class="mb-2 flex items-center space-x-2 text-sm text-gray-500">
                <a
                    href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                    class="font-medium hover:underline"
                    style="color: {{ $post->subreddit->color }}"
                >
                    r/{{ $post->subreddit->slug }}
                </a>
                <span>•</span>
                <span>Por {{ $post->user->name }}</span>
                <span>•</span>
                <span>{{ $post->created_at->diffForHumans() }}</span>
                @if ($post->is_pinned)
                    <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">
                        📌 Fixado
                    </span>
                @endif
            </div>

            <!-- Title -->
            <h2 class="mb-2 text-lg font-semibold text-gray-900">
                <a href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}" class="hover:text-blue-600">
                    {{ $post->title }}
                </a>
            </h2>

            <!-- Content Preview -->
            @if ($post->content)
                <div class="mb-4 line-clamp-3 text-gray-700">
                    {{ Str::limit(strip_tags($post->content), 200) }}
                </div>
            @endif

            <!-- URL Preview for link posts -->
            @if ($post->type === 'link' && $post->url)
                <div class="mb-4">
                    <a
                        href="{{ $post->url }}"
                        target="_blank"
                        class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-2 text-blue-700 transition-colors hover:bg-blue-100"
                    >
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                            ></path>
                        </svg>
                        {{ parse_url($post->url, PHP_URL_HOST) }}
                    </a>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <a
                    href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
                    class="flex items-center space-x-1 hover:text-gray-700"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        ></path>
                    </svg>
                    <span>{{ $post->comment_count }} comentários</span>
                </a>

                <button class="flex items-center space-x-1 hover:text-gray-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"
                        ></path>
                    </svg>
                    <span>Compartilhar</span>
                </button>
            </div>
        </div>
    </div>
</article>
<?php 
