<?php

declare(strict_types=1);

?>
@extends('layouts.app')

@section('title', $subreddit->name . ' - 3Pontos Community')

@section('content')
    {{-- Community Header with Gradient --}}
    <div
        class="to-dark-bg border-dark-border relative h-52 border-b bg-gradient-to-b from-[{{ $subreddit->color }}]/10"
    ></div>

    <div class="relative mx-auto -mt-12 max-w-screen-xl px-8">
        {{-- Community Info --}}
        <div class="mb-8">
            {{-- Community Avatar --}}
            <div
                class="border-dark-bg mb-4 flex h-24 w-24 items-center justify-center rounded-3xl border-4 bg-orange-500 text-5xl font-bold"
            >
                😎
            </div>

            {{-- Community Title and Actions --}}
            <div class="mb-3 flex items-start justify-between">
                <div>
                    <h1 class="font-display mb-2 text-3xl font-bold text-gray-900 dark:text-white">
                        /r {{ $subreddit->name }}
                    </h1>
                    <p class="mb-4 text-base text-gray-700 dark:text-gray-400">{{ $subreddit->description }}</p>

                    {{-- Community Meta --}}
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg
                                class="h-4 w-4 text-gray-600 dark:text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            {{ number_format($followersCount) }}i de membros
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg
                                class="h-4 w-4 text-gray-600 dark:text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                            Criado em Jan, {{ $subreddit->created_at->format('Y') }}
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    @auth
                        <button
                            id="follow-btn-{{ $subreddit->id }}"
                            onclick="toggleFollow({{ $subreddit->id }}, '{{ $subreddit->slug }}')"
                            class="{{ $isFollowing ? 'bg-emerald-600 text-gray-900 hover:bg-emerald-700 dark:text-white' : 'dark:bg-dark-border border-dark-hover dark:hover:bg-dark-hover border bg-gray-100 text-gray-700 hover:bg-gray-200 dark:text-gray-400' }} rounded-xl px-6 py-3 text-sm font-semibold transition-all"
                        >
                            <span id="follow-text-{{ $subreddit->id }}">
                                {{ $isFollowing ? 'Seguindo' : 'Entrar' }}
                            </span>
                        </button>
                        <a
                            href="{{ route('post.create', $subreddit->slug) }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-3 text-sm font-semibold text-gray-900 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/40 dark:text-white"
                        >
                            Criar post
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="dark:bg-dark-border border-dark-hover dark:hover:bg-dark-hover rounded-xl border bg-gray-100 px-6 py-3 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200 dark:text-gray-400"
                        >
                            Entrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Posts Section --}}
        <h2 class="font-display mb-6 text-2xl font-bold text-gray-900 dark:text-white">
            Veja todos os posts da comunidade
        </h2>

        @forelse ($posts as $post)
            <article
                class="dark:border-dark-border dark:bg-dark-surface hover:border-dark-hover mb-4 rounded-2xl border border-gray-200 bg-white p-6 transition-all"
            >
                {{-- Post Header --}}
                <div class="mb-4 flex items-center gap-3">
                    <div
                        class="dark:bg-dark-border flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-xl"
                    >
                        😎
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-orange-500">r/{{ $subreddit->slug }}</div>
                        <div class="text-xs text-gray-600">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                {{-- Post Title --}}
                <a
                    href="{{ route('post.show', [$subreddit->slug, $post->slug]) }}"
                    class="mb-3 block text-lg font-bold text-gray-900 transition-colors hover:text-orange-500 dark:text-white"
                >
                    {{ $post->title }}
                </a>

                {{-- Post Content --}}
                <p class="mb-4 text-sm leading-relaxed text-gray-700 dark:text-gray-400">
                    {{ Str::limit(strip_tags($post->content), 200) }}
                </p>

                {{-- Post Actions --}}
                <div class="flex items-center gap-3">
                    <button
                        class="dark:bg-dark-border dark:hover:bg-dark-hover flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        <span>{{ $post->comment_count }}</span>
                    </button>

                    @auth
                        <button
                            id="upvote-{{ $post->id }}"
                            onclick="votePost({{ $post->id }}, 'up')"
                            class="post-vote dark:bg-dark-border dark:hover:bg-dark-hover flex items-center gap-2 rounded-lg border border-transparent bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                                />
                            </svg>
                            <span id="upvote-count-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
                        </button>

                        <button
                            id="downvote-{{ $post->id }}"
                            onclick="votePost({{ $post->id }}, 'down')"
                            class="post-vote dark:bg-dark-border dark:hover:bg-dark-hover flex items-center gap-2 rounded-lg border border-transparent bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                                />
                            </svg>
                            <span id="downvote-count-{{ $post->id }}">{{ $post->dislikes_count ?? 0 }}</span>
                        </button>
                    @else
                        <button
                            onclick="alert('Faça login para votar')"
                            class="dark:bg-dark-border dark:hover:bg-dark-hover flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                                />
                            </svg>
                        </button>
                    @endauth

                    <a
                        href="{{ route('post.show', [$subreddit->slug, $post->slug]) }}"
                        class="dark:bg-dark-border dark:hover:bg-dark-hover rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
                    >
                        Ver Post
                    </a>
                </div>
            </article>
        @empty
            <div
                class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-12 text-center"
            >
                <p class="mb-2 text-gray-700 dark:text-gray-400">Nenhum post encontrado nesta comunidade.</p>
                <p class="text-sm text-gray-600 dark:text-gray-500">Seja o primeiro a postar aqui!</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($posts->hasPages())
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        async function votePost(postId, voteType) {
            const upButton = document.getElementById(`upvote-${postId}`);
            const downButton = document.getElementById(`downvote-${postId}`);
            const upCount = document.getElementById(`upvote-count-${postId}`);
            const downCount = document.getElementById(`downvote-count-${postId}`);

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
                    // Update counts
                    upCount.textContent = data.likes_count || 0;
                    downCount.textContent = data.dislikes_count || 0;

                    // Reset active states
                    upButton.classList.remove('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                    downButton.classList.remove('!bg-red-500/20', '!text-red-500', '!border-red-500/30');

                    // Apply active state
                    if (data.action === 'added' || data.action === 'updated') {
                        if (voteType === 'up') {
                            upButton.classList.add('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                        } else {
                            downButton.classList.add('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
                        }
                    }
                }
            } catch (error) {
                console.error('Erro ao votar:', error);
                alert('Erro de conexão. Tente novamente.');
            }
        }

        async function toggleFollow(subredditId, subredditSlug) {
            const button = document.getElementById(`follow-btn-${subredditId}`);
            const text = document.getElementById(`follow-text-${subredditId}`);

            if (!button || !text) return;

            button.disabled = true;

            try {
                const checkResponse = await fetch(`/communities/${subredditSlug}/follow-status`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                });

                const checkData = await checkResponse.json();
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
                    text.textContent = data.is_following ? 'Seguindo' : 'Entrar';

                    if (data.is_following) {
                        button.className =
                            'px-6 py-3 rounded-xl text-sm font-semibold transition-all bg-emerald-600 text-gray-900 dark:text-white hover:bg-emerald-700';
                    } else {
                        button.className =
                            'px-6 py-3 rounded-xl text-sm font-semibold transition-all bg-gray-100 dark:bg-dark-border text-gray-700 dark:text-gray-400 border border-dark-hover hover:bg-gray-200 dark:hover:bg-dark-hover';
                    }
                }
            } catch (error) {
                console.error('Erro:', error);
            } finally {
                button.disabled = false;
            }
        }

        // Load user votes on page load
        @auth
            document.addEventListener('DOMContentLoaded', async function () {
                try {
                    const response = await fetch('{{ route('vote.user') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            Accept: 'application/json',
                        },
                    });

                    const data = await response.json();

                    if (data.success && data.votes) {
                        data.votes.forEach((vote) => {
                            if (vote.voteable_type === 'post') {
                                const upButton = document.getElementById(`upvote-${vote.voteable_id}`);
                                const downButton = document.getElementById(`downvote-${vote.voteable_id}`);

                                if (vote.vote_type === 'up' && upButton) {
                                    upButton.classList.add('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                                } else if (vote.vote_type === 'down' && downButton) {
                                    downButton.classList.add('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Erro ao carregar votos:', error);
                }
            });
        @endauth
    </script>
@endpush
<?php 
