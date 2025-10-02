<?php

declare(strict_types=1);

?>

@extends('layouts.app')
@section('title', $post->title . ' - r/' . $post->subreddit->slug)
@section('content')
    <div class="mx-auto max-w-screen-lg px-8 py-8">
        {{-- Back to Community --}}
        <a
            href="{{ route('subreddit.show', $post->subreddit->slug) }}"
            class="mb-6 inline-flex items-center gap-2 text-sm text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-500 dark:text-white"
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
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Voltar para r/{{ $post->subreddit->slug }}
        </a>
        {{-- Post Card --}}
        <article class="border-dark-border bg-dark-surface mb-8 rounded-2xl border p-8">
            {{-- Post Header --}}
            <div class="mb-6 flex items-center gap-3">
                <div
                    class="dark:bg-dark-border flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-2xl"
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
                    <div class="text-xs text-gray-600">
                        por

                        @if ($post->user->username)
                            <a href="{{ route('profile.user', $post->user->username) }}" class="hover:underline">
                                u/{{ $post->user->username }}
                            </a>
                        @else
                            {{ $post->user->name }}
                        @endif
                        · {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            {{-- Post Title --}}
            <h1 class="font-display mb-6 text-3xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h1>
            {{-- Post Content --}}
            <div class="prose prose-invert mb-6 max-w-none text-gray-300">
                {!! Str::markdown($post->content) !!}
            </div>
            {{-- Post Actions --}}
            <div class="flex items-center gap-3">
                <div
                    class="dark:bg-dark-border flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 dark:text-gray-500"
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
                    <span id="total-comments">{{ $post->comment_count }}</span>
                    <span>comentários</span>
                </div>
                @auth
                    <button
                        id="post-upvote"
                        onclick="votePost({{ $post->id }}, 'up')"
                        class="dark:hover:bg-dark-hover dark:bg-dark-border flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
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
                        <span id="post-upvote-count">{{ $post->likes_count }}</span>
                    </button>
                    <button
                        id="post-downvote"
                        onclick="votePost({{ $post->id }}, 'down')"
                        class="dark:hover:bg-dark-hover dark:bg-dark-border flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-600 transition-all hover:bg-gray-200 hover:text-gray-900 dark:text-gray-500 dark:text-white"
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
                        <span id="post-downvote-count">{{ $post->dislikes_count }}</span>
                    </button>
                @endauth
            </div>
        </article>
        {{-- Comments Section --}}
        <div class="border-dark-border bg-dark-surface rounded-2xl border p-8">
            <h2 class="font-display mb-6 text-2xl font-bold text-gray-900 dark:text-white">
                Comentários (
                <span id="total-comments-header">{{ $post->comment_count }}</span>
                )
            </h2>
            {{-- Comment Form --}}
            @auth
                <form
                    id="comment-form"
                    action="{{ route('comments.store', [$post->subreddit->slug, $post->slug]) }}"
                    method="POST"
                    class="mb-8"
                >
                    @csrf
                    <textarea
                        name="content"
                        id="comment-content"
                        rows="4"
                        placeholder="Adicione um comentário..."
                        class="border-dark-border bg-dark-bg mb-3 w-full rounded-xl border px-4 py-3 text-sm text-gray-900 placeholder-gray-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none dark:text-white"
                        required
                    ></textarea>
                    <button
                        type="submit"
                        class="rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-2.5 text-sm font-semibold text-gray-900 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/40 dark:text-white"
                    >
                        Comentar
                    </button>
                </form>
            @else
                <div class="border-dark-border bg-dark-bg mb-8 rounded-xl border p-6 text-center">
                    <p class="mb-3 text-gray-700 dark:text-gray-400">Você precisa fazer login para comentar</p>
                    <a
                        href="{{ route('login') }}"
                        class="inline-block rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-2.5 text-sm font-semibold text-gray-900 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/40 dark:text-white"
                    >
                        Fazer Login
                    </a>
                </div>
            @endauth
            {{-- Sort Filter --}}
            <div class="mb-6 flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-500">Ordenar por:</span>
                <a
                    href="?sort=new"
                    class="{{ request('sort') === 'new' ? 'bg-orange-500/10 text-orange-500' : 'dark:bg-dark-border text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-500 dark:text-white' }} rounded-lg px-3 py-1.5 text-xs font-medium transition-all"
                >
                    Mais novos
                </a>
                <a
                    href="?sort=top"
                    class="{{ request('sort') === 'top' || ! request('sort') ? 'bg-orange-500/10 text-orange-500' : 'dark:bg-dark-border text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-500 dark:text-white' }} rounded-lg px-3 py-1.5 text-xs font-medium transition-all"
                >
                    Mais votados
                </a>
            </div>
            {{-- Comments List --}}
            <div id="comments-container" class="space-y-4">
                @forelse ($comments as $comment)
                    <x-comment :comment="$comment" :post="$post" />
                @empty
                    <div class="border-dark-border bg-dark-bg rounded-xl border p-8 text-center">
                        <p class="text-gray-700 dark:text-gray-400">Nenhum comentário ainda.</p>
                        <p class="mt-2 text-sm text-gray-600">Seja o primeiro a comentar!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        // Vote Post
        async function votePost(postId, voteType) {
            const upButton = document.getElementById('post-upvote');
            const downButton = document.getElementById('post-downvote');
            const upCount = document.getElementById('post-upvote-count');
            const downCount = document.getElementById('post-downvote-count');
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
                    upCount.textContent = data.likes_count || 0;
                    downCount.textContent = data.dislikes_count || 0;
                    upButton.classList.remove('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                    downButton.classList.remove('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
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
            }
        }
        // Vote Comment
        async function voteComment(commentId, voteType) {
            const upButton = document.getElementById(`comment-upvote-${commentId}`);
            const downButton = document.getElementById(`comment-downvote-${commentId}`);
            const upCount = document.getElementById(`comment-upvote-count-${commentId}`);
            const downCount = document.getElementById(`comment-downvote-count-${commentId}`);
            try {
                const response = await fetch('{{ route('vote') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        Accept: 'application/json',
                    },
                    body: JSON.stringify({
                        voteable_type: 'comment',
                        voteable_id: commentId,
                        vote_type: voteType,
                    }),
                });
                const data = await response.json();
                if (data.success) {
                    upCount.textContent = data.likes_count || 0;
                    downCount.textContent = data.dislikes_count || 0;
                    upButton.classList.remove('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                    downButton.classList.remove('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
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
            }
        }
        // Toggle Reply Form
        function toggleReplyForm(commentId) {
            const form = document.getElementById(`reply-form-${commentId}`);
            if (form) {
                form.classList.toggle('hidden');
            }
        }
        // Delete Comment
        async function deleteComment(commentId) {
            if (!confirm('Tem certeza que deseja excluir este comentário?')) return;
            try {
                const response = await fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                });
                const data = await response.json();
                if (data.success) {
                    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                }
            } catch (error) {
                console.error('Erro ao deletar:', error);
            }
        }
        // Echo/Reverb Real-time
        @auth
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.Echo !== 'undefined') {

                    window.Echo.channel('post.{{ $post->id }}').listen('.comment.created', (e) => {
                    const commentsContainer = document.getElementById('comments-container');
                    if (commentsContainer && e.comment) {
                        updateCommentCount(e.post.comment_count);
                        const newComment = createCommentElement(e.comment, e.post);
                        if (newComment) {
                            if (e.comment.parent_id) {
                                const parentComment = document.querySelector(
                                    `[data-comment-id="${e.comment.parent_id}"]`,
                                );
                                if (parentComment) {
                                    let repliesContainer = parentComment.querySelector('.replies-container');
                                    if (!repliesContainer) {
                                        repliesContainer = document.createElement('div');
                                        repliesContainer.className = 'mt-4 space-y-4 replies-container';
                                        parentComment.appendChild(repliesContainer);
                                    }
                                    repliesContainer.appendChild(newComment);
                                } else {
                                    commentsContainer.appendChild(newComment);
                                }
                            } else {
                                const currentSort = new URLSearchParams(window.location.search).get('sort');
                                if (currentSort === 'new') {
                                    commentsContainer.insertBefore(newComment, commentsContainer.firstChild);
                                } else {
                                    commentsContainer.appendChild(newComment);
                                }
                            }
                        }
                    }
                });
                window.Echo.channel('post.{{ $post->id }}').listen('.comment.deleted', (e) => {
                    if (e.comment_id) {
                        const commentElement = document.querySelector(`[data-comment-id="${e.comment_id}"]`);
                        if (commentElement) {
                            commentElement.remove();
                        }
                        if (e.comment_count !== undefined) {
                            updateCommentCount(e.comment_count);
                        }
                    }
                });
                }
            });
        @endauth
        function updateCommentCount(count) {
            const totalComments = document.getElementById('total-comments');
            const totalCommentsHeader = document.getElementById('total-comments-header');
            if (totalComments) totalComments.textContent = count;
            if (totalCommentsHeader) totalCommentsHeader.textContent = count;
        }
        function createCommentElement(comment, post) {
            const div = document.createElement('div');
            div.className = 'border-l-2 border-dark-border pl-4';
            div.setAttribute('data-comment-id', comment.id);
            const canDelete = {{ Auth::id() ?? 'null' }} === comment.user.id || {{ Auth::id() ?? 'null' }} === {{ $post->user_id }};
            const canReply = {{ Auth::check() ? 'true' : 'false' }} && comment.depth < 5;
            div.innerHTML = `
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-8 h-8 bg-gray-100 dark:bg-dark-border rounded-full flex items-center justify-center text-sm flex-shrink-0">
                        ${comment.user.profile_photo_url ? `<img src="${comment.user.profile_photo_url}" class="w-full h-full rounded-full object-cover">` : '😎'}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">${comment.user.name}</span>
                            <span class="text-xs text-gray-600">${new Date(comment.created_at).toLocaleDateString('pt-BR')}</span>
                        </div>
                        <p class="text-sm text-gray-300 mb-3">${comment.content}</p>
                        <div class="flex items-center gap-2">
                            ${
                                {{ Auth::check() ? 'true' : 'false' }}
                                    ? `
                                <button onclick="voteComment(${comment.id}, 'up')" id="comment-upvote-${comment.id}" class="flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-dark-border rounded text-xs text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-dark-hover hover:text-gray-900 dark:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/>
                                    </svg>
                                    <span id="comment-upvote-count-${comment.id}">${comment.likes_count || 0}</span>
                                </button>
                                <button onclick="voteComment(${comment.id}, 'down')" id="comment-downvote-${comment.id}" class="flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-dark-border rounded text-xs text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-dark-hover hover:text-gray-900 dark:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"/>
                                    </svg>
                                    <span id="comment-downvote-count-${comment.id}">${comment.dislikes_count || 0}</span>
                                </button>
                            `
                                    : ''
                            }
                            ${canReply ? `<button onclick="toggleReplyForm(${comment.id})" class="text-xs text-gray-600 dark:text-gray-500 hover:text-orange-500 transition-colors">Responder</button>` : ''}
                            ${canDelete ? `<button onclick="deleteComment(${comment.id})" class="text-xs text-red-500 hover:text-red-400 transition-colors">Excluir</button>` : ''}
                        </div>
                        ${
                            canReply
                                ? `
                            <form id="reply-form-${comment.id}" action="/comments/${comment.id}/reply" method="POST" class="mt-4 hidden">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <textarea name="content" rows="3" placeholder="Sua resposta..." class="w-full rounded-lg border border-dark-border bg-dark-bg px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-600 focus:border-orange-500 focus:outline-none mb-2" required></textarea>
                                <button type="submit" class="rounded-lg bg-orange-500 px-4 py-1.5 text-xs font-semibold text-gray-900 dark:text-white hover:bg-orange-600 transition-colors">Responder</button>
                            </form>
                        `
                                : ''
                        }
                    </div>
                </div>
            `;
            return div;
        }
        // Submit comment via AJAX
        document.getElementById('comment-form')?.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const content = formData.get('content');
            if (!content || content.trim() === '') return;
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    },
                    body: formData,
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('comment-content').value = '';
                    if (data.comment_count !== undefined) {
                        updateCommentCount(data.comment_count);
                    }
                }
            } catch (error) {
                console.error('Erro ao comentar:', error);
            }
        });
        // Load user votes
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
                            if (vote.voteable_type === 'post' && vote.voteable_id === {{ $post->id }}) {
                                const upButton = document.getElementById('post-upvote');
                                const downButton = document.getElementById('post-downvote');
                                if (vote.vote_type === 'up' && upButton) {
                                    upButton.classList.add('!bg-emerald-500/20', '!text-emerald-500', '!border-emerald-500/30');
                                } else if (vote.vote_type === 'down' && downButton) {
                                    downButton.classList.add('!bg-red-500/20', '!text-red-500', '!border-red-500/30');
                                }
                            }
                            if (vote.voteable_type === 'comment') {
                                const upButton = document.getElementById(`comment-upvote-${vote.voteable_id}`);
                                const downButton = document.getElementById(`comment-downvote-${vote.voteable_id}`);
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
