<?php

declare(strict_types=1);

?>
@extends('layouts.app')
@section('title', 'Perfil - ' . $user->getDisplayName())
@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8">
        <!-- Success Message -->
        @if (session('success'))
            <div
                class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20"
            >
                <div class="flex items-center gap-2">
                    <svg
                        class="h-5 w-5 text-green-600 dark:text-green-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-semibold text-green-800 dark:text-green-200">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="relative mb-8">
            <!-- Cover Photo -->
            <div class="relative h-48 w-full overflow-hidden rounded-2xl">
                @if ($user->getCoverPhotoUrl())
                    <img src="{{ $user->getCoverPhotoUrl() }}" alt="Cover photo" class="h-full w-full object-cover" />
                @else
                    <div
                        class="flex h-full w-full items-center justify-center bg-gradient-to-r from-orange-500 to-orange-600"
                    >
                        <svg class="h-16 w-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                @endif
                <!-- Profile Picture - Positioned to overlap cover photo -->
                <div class="absolute -bottom-12 left-6">
                    <div class="relative">
                        @if ($user->getProfilePictureUrl())
                            <img
                                src="{{ $user->getProfilePictureUrl() }}"
                                alt="Profile picture"
                                class="dark:border-dark-surface h-24 w-24 rounded-full border-4 border-white object-cover"
                            />
                        @else
                            <div
                                class="dark:border-dark-surface flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-orange-500 text-3xl font-bold text-white"
                            >
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Edit Button (only for own profile) -->
                @if ($isOwnProfile)
                    <div class="absolute right-4 bottom-4">
                        <a
                            href="{{ route('profile.edit') }}"
                            class="dark:bg-dark-surface dark:hover:bg-dark-border inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-lg transition-all hover:-translate-y-0.5 hover:bg-gray-50 dark:text-white"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                />
                            </svg>
                            Editar Perfil
                        </a>
                    </div>
                @endif
            </div>
            <!-- Profile Info -->
            <div class="mt-16 px-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="font-display text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $user->getDisplayName() }}
                        </h1>
                        @if ($user->username)
                            <p class="font-medium text-orange-500">u/{{ $user->username }}</p>
                        @endif

                        @if ($user->bio)
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $user->bio }}</p>
                        @endif

                        <!-- Additional Info -->
                        <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            @if ($user->location)
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    {{ $user->location }}
                                </div>
                            @endif

                            @if ($user->website)
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                        />
                                    </svg>
                                    <a
                                        href="{{ $user->website }}"
                                        target="_blank"
                                        class="transition-colors hover:text-orange-500"
                                    >
                                        {{ parse_url($user->website, PHP_URL_HOST) }}
                                    </a>
                                </div>
                            @endif

                            @if ($user->getAge())
                                <div class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    {{ $user->getAge() }} anos
                                </div>
                            @endif

                            <div class="flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                                Membro desde {{ $user->created_at->format('M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Stats Card -->
                <div
                    class="dark:border-dark-border dark:bg-dark-surface mb-6 rounded-2xl border border-gray-200 bg-white p-6"
                >
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Estatísticas</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-500">{{ $posts->total() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Posts</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-emerald-500">{{ $subreddits->count() }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Comunidades</div>
                        </div>
                    </div>
                </div>
                <!-- Created Communities -->
                @if ($subreddits->count() > 0)
                    <div
                        class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6"
                    >
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Comunidades Criadas</h3>
                        <div class="space-y-3">
                            @foreach ($subreddits as $subreddit)
                                <a
                                    href="{{ route('subreddit.show', $subreddit->slug) }}"
                                    class="dark:hover:bg-dark-border flex items-center gap-3 rounded-lg p-3 transition-all hover:bg-gray-50"
                                >
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white"
                                        style="background-color: {{ $subreddit->color }}"
                                    >
                                        {{ strtoupper(substr($subreddit->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            r/{{ $subreddit->slug }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $subreddit->posts_count }} posts
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Posts Section -->
                <div class="mb-6">
                    <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white">
                        Posts ({{ $posts->total() }})
                    </h2>
                </div>
                <div class="space-y-4">
                    @forelse ($posts as $post)
                        <article
                            class="dark:border-dark-border dark:bg-dark-surface dark:hover:border-dark-hover rounded-2xl border border-gray-200 bg-white p-6 transition-all hover:border-gray-300"
                        >
                            <!-- Post Header -->
                            <div class="mb-4 flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full text-xl"
                                    style="background-color: {{ $post->subreddit->color }}"
                                >
                                    {{ strtoupper(substr($post->subreddit->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <a
                                            href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                                            class="font-semibold text-orange-500 transition-colors hover:text-orange-600"
                                        >
                                            r/{{ $post->subreddit->slug }}
                                        </a>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Content -->
                            <h3 class="mb-3 text-lg font-bold text-gray-900 dark:text-white">
                                <a
                                    href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
                                    class="transition-colors hover:text-orange-500"
                                >
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="mb-4 line-clamp-3 text-gray-600 dark:text-gray-400">
                                {{ Str::limit(strip_tags($post->content), 200) }}
                            </p>
                            <!-- Post Actions -->
                            <div class="flex items-center gap-6">
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                        />
                                    </svg>
                                    {{ $post->comment_count }} comentários
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 15l7-7 7 7"
                                        />
                                    </svg>
                                    <span class="font-medium">{{ $post->vote_score }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div
                            class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-12 text-center"
                        >
                            <svg
                                class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                                Nenhum post encontrado
                            </h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">
                                @if ($isOwnProfile)
                                    Você ainda não criou nenhum post. Que tal compartilhar algo interessante?
                                @else
                                        Este usuário ainda não criou nenhum post.
                                @endif
                            </p>
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
@endsection
<?php 
