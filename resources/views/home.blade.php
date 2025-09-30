<?php

declare(strict_types=1);

?>
@extends('layouts.app')
@section('title', '3Pontos Community - Home')
@section('content')
    <div class="mx-auto max-w-screen-xl p-8">
        {{-- Welcome Section --}}
        <div class="mb-8">
            <h1 class="font-display mb-2 text-3xl font-bold">
                @auth
                    Olá, {{ Auth::user()->name }}! 👋
                @else
                    Olá, visitante! 👋
                @endauth
            </h1>
            <p class="text-gray-600 dark:text-gray-500">Confira as estatísticas das comunidades que você segue</p>
        </div>
        {{-- Stats Grid --}}
        <div class="mb-12 grid grid-cols-3 gap-6">
            {{-- Users Stats --}}
            <div
                class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6 text-center"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="text-gray-900 dark:text-white"
                    >
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">10,000</div>
                <div class="text-sm text-gray-600 dark:text-gray-500">Quantidade de usuários</div>
            </div>
            {{-- Posts Stats --}}
            <div
                class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6 text-center"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="text-gray-900 dark:text-white"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <div class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $posts->total() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-500">Quantidade de posts</div>
            </div>
            {{-- Comments Stats --}}
            <div
                class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6 text-center"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="text-gray-900 dark:text-white"
                    >
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">10,000</div>
                <div class="text-sm text-gray-600 dark:text-gray-500">Quantidade de replies</div>
            </div>
        </div>
        {{-- Posts Section Header --}}
        <div class="mb-6 flex items-center justify-between">
            <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white">
                @auth
                    @if ($posts->isEmpty())
                        Veja os últimos posts
                    @else
                        Posts das suas comunidades
                    @endif
                @else
                    Veja os últimos posts das comunidades
                @endauth
            </h2>
            @auth
                <a
                    href="{{ route('subreddit.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-3 text-sm font-semibold text-gray-900 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/40 dark:text-white"
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
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Criar Comunidade
                </a>
            @endauth
        </div>
        {{-- Posts List --}}
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
                        <a
                            href="{{ route('subreddit.show', $post->subreddit->slug) }}"
                            class="text-sm font-semibold text-orange-500 transition-colors hover:text-orange-400"
                        >
                            r/{{ $post->subreddit->slug }}
                        </a>
                        <div class="text-xs text-gray-600">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                {{-- Post Title --}}
                <a
                    href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
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
                    {{-- Comments --}}
                    <button
                        onclick="window.location.href='{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}'"
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
                        <span id="comment-count-{{ $post->id }}">{{ $post->comment_count }}</span>
                    </button>
                    {{-- Upvote --}}
                    @auth
                        <button
                            id="upvote-{{ $post->id }}"
                            onclick="votePost({{ $post->id }}, 'up')"
                            class="post-vote dark:bg-dark-border dark:hover:bg-dark-hover flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
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
                            <span id="upvote-count-{{ $post->id }}">{{ $post->likes_count }}</span>
                        </button>
                        {{-- Downvote --}}
                        <button
                            id="downvote-{{ $post->id }}"
                            onclick="votePost({{ $post->id }}, 'down')"
                            class="post-vote dark:bg-dark-border dark:hover:bg-dark-hover flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
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
                            <span id="downvote-count-{{ $post->id }}">{{ $post->dislikes_count }}</span>
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
                    {{-- Ver Post --}}
                    <a
                        href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
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
                <p class="mb-2 text-base text-gray-700 dark:text-gray-400">
                    @auth
                        Você ainda não segue nenhuma comunidade.
                    @else
                        Nenhum post disponível no momento.
                    @endauth
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-500">
                    @auth
                        <a href="{{ route('subreddit.create') }}" class="text-orange-500 hover:text-orange-400">
                            Crie uma comunidade
                        </a>
                        ou explore as sugestões na sidebar.
                    @else
                        <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-400">Faça login</a>
                        para ver posts das suas comunidades.
                    @endauth
                </p>
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
        // Vote Post Function
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
        // Load user votes on page load
        @auth
            document.addEventListener('DOMContentLoaded', async function () {
                try {
                    const response = await fetch('{{ route('vote.user') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
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
