<?php

declare(strict_types=1);

?>
@extends('layouts.app')

@section('title', '3Pontos Community - Home')

@section('styles')
    <style>
        .stats-card {
            background: #0e0e0e;
            border: 1px solid #1a1a1a;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .stats-label {
            font-size: 14px;
            color: #888;
        }

        .post-card {
            background: #0e0e0e;
            border: 1px solid #1a1a1a;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            transition: all 0.2s;
        }

        .post-card:hover {
            border-color: #2a2a2a;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .post-community {
            font-size: 14px;
            font-weight: 600;
            color: #f97316;
            text-decoration: none;
        }

        .post-time {
            font-size: 12px;
            color: #666;
        }

        .post-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
            text-decoration: none;
            display: block;
        }

        .post-title:hover {
            color: #f97316;
        }

        .post-content {
            font-size: 14px;
            color: #999;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .post-footer {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .post-action {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: #1a1a1a;
            border: none;
            border-radius: 8px;
            color: #888;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .post-action:hover {
            background: #252525;
            color: #fff;
        }

        .post-action svg {
            width: 16px;
            height: 16px;
        }

        .post-action.active-like {
            background: #10b98120;
            color: #10b981;
        }

        .post-action.active-dislike {
            background: #ef444420;
            color: #ef4444;
        }

        .btn-create {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Welcome Section -->
        <div style="margin-bottom: 32px">
            <h1 class="cal-sans" style="font-size: 32px; font-weight: 700; margin-bottom: 8px">
                @auth
                    Olá, {{ Auth::user()->name }}! 👋
                @else
                    Olá, visitante! 👋
                @endauth
            </h1>
            <p style="color: #888; font-size: 16px">Confira as estatísticas das comunidades que você segue</p>
        </div>

        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 48px">
            <div class="stats-card">
                <div class="stats-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
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
                </div>
                <div class="stats-number">10,000</div>
                <div class="stats-label">Quantidade de usuários</div>
            </div>

            <div class="stats-card">
                <div class="stats-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <div class="stats-number">{{ $posts->total() }}</div>
                <div class="stats-label">Quantidade de posts</div>
            </div>

            <div class="stats-card">
                <div class="stats-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <div class="stats-number">10,000</div>
                <div class="stats-label">Quantidade de replies</div>
            </div>
        </div>

        <!-- Posts Section Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px">
            <h2 class="cal-sans" style="font-size: 24px; font-weight: 700; color: #fff">
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
                <a href="{{ route('subreddit.create') }}" class="btn-create">
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

        <!-- Posts List -->
        @forelse ($posts as $post)
            <article class="post-card" data-post-id="{{ $post->id }}">
                <div class="post-header">
                    <div class="post-avatar">😎</div>
                    <div>
                        <a href="{{ route('subreddit.show', $post->subreddit->slug) }}" class="post-community">
                            r/{{ $post->subreddit->slug }}
                        </a>
                        <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <a href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}" class="post-title">
                    {{ $post->title }}
                </a>

                <div class="post-content">
                    {{ Str::limit(strip_tags($post->content), 200) }}
                </div>

                <div class="post-footer">
                    <button
                        class="post-action"
                        onclick="openCommentsModal({{ $post->id }}, '{{ $post->subreddit->slug }}', '{{ $post->slug }}')"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        <span id="comment-count-{{ $post->id }}">{{ $post->comment_count }}</span>
                    </button>

                    @auth
                        <button
                            class="post-action"
                            id="upvote-{{ $post->id }}"
                            onclick="votePost({{ $post->id }}, 'up')"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
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

                        <button
                            class="post-action"
                            id="downvote-{{ $post->id }}"
                            onclick="votePost({{ $post->id }}, 'down')"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
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
                        <button class="post-action" onclick="alert('Faça login para votar')">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
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

                    <a href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}" class="post-action">
                        Ver Post
                    </a>
                </div>
            </article>
        @empty
            <div class="post-card" style="text-align: center">
                <p style="color: #666; font-size: 16px; margin-bottom: 8px">
                    @auth
                        Você ainda não segue nenhuma comunidade.
                    @else
                        Nenhum post disponível no momento.
                    @endauth
                </p>
                <p style="color: #888; font-size: 14px">
                    @auth
                        <a href="{{ route('subreddit.create') }}" style="color: #f97316">Crie uma comunidade</a>
                        ou explore as sugestões na sidebar.
                    @else
                        <a href="{{ route('login') }}" style="color: #f97316">Faça login</a>
                        para ver posts das suas comunidades.
                    @endauth
                </p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div style="margin-top: 32px">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Vote Post
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

                        // Reset styles
                        upButton.classList.remove('active-like');
                        downButton.classList.remove('active-dislike');

                        // Apply active style
                        if (data.action === 'added') {
                            if (voteType === 'up') {
                                upButton.classList.add('active-like');
                            } else {
                                downButton.classList.add('active-dislike');
                            }
                        }
                    }
                } catch (error) {
                    console.error('Erro ao votar:', error);
                    alert('Erro de conexão. Tente novamente.');
                }
            }

            // Open Comments Modal (placeholder)
            function openCommentsModal(postId, subredditSlug, postSlug) {
                window.location.href = `/r/${subredditSlug}/${postSlug}`;
            }

            // Load user votes on page load
            @auth
                document.addEventListener('DOMContentLoaded', async function() {
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
                            data.votes.forEach(vote => {
                                if (vote.voteable_type === 'post') {
                                    const upButton = document.getElementById(`upvote-${vote.voteable_id}`);
                                    const downButton = document.getElementById(`downvote-${vote.voteable_id}`);

                                    if (vote.vote_type === 'up' && upButton) {
                                        upButton.classList.add('active-like');
                                    } else if (vote.vote_type === 'down' && downButton) {
                                        downButton.classList.add('active-dislike');
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
@endsection
<?php 
