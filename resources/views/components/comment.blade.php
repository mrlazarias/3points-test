<?php

declare(strict_types=1);

?>

@props([
    'comment',
    'depth',
])

<div
    class="rounded-xl border border-slate-700/50 bg-slate-800/30 p-6 backdrop-blur-sm"
    style="margin-left: {{ $depth * 2 }}rem"
    data-comment-id="{{ $comment->id }}"
>
    <!-- Comment Header -->
    <div class="mb-4 flex items-center space-x-3">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">
            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <div class="flex items-center space-x-2">
                <span class="text-sm font-medium text-white">u/{{ $comment->user->name }}</span>
                <span class="text-slate-400">•</span>
                <span class="text-sm text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>

    <!-- Comment Content -->
    <div class="prose prose-invert prose-sm mb-4 max-w-none">
        {!! Str::markdown($comment->content) !!}
    </div>

    <!-- Comment Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <!-- Voting -->
            <div class="flex items-center space-x-1">
                <!-- Like Button -->
                <button
                    onclick="vote({{ $comment->id }}, 'comment', 'up')"
                    class="vote-btn group flex items-center space-x-1.5 rounded-lg border border-transparent px-3 py-1.5 text-slate-400 transition-all duration-200 hover:border-green-500/30 hover:bg-green-500/15 hover:text-green-400 focus:ring-2 focus:ring-green-500/30 focus:outline-none"
                    data-vote-type="up"
                    data-target-id="{{ $comment->id }}"
                    data-target-type="comment"
                >
                    <div
                        class="flex h-5 w-5 items-center justify-center rounded-full transition-all duration-200 group-hover:bg-green-500/20 group-hover:shadow-md group-hover:shadow-green-500/20"
                    >
                        <svg
                            class="h-3.5 w-3.5 transition-transform duration-200 group-hover:scale-110"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M5 15l7-7 7 7"
                            ></path>
                        </svg>
                    </div>
                    <span
                        id="likes-count-{{ $comment->id }}"
                        class="text-xs font-bold transition-colors duration-200 group-hover:text-green-400"
                    >
                        {{ $comment->likes_count ?? 0 }}
                    </span>
                </button>

                <!-- Dislike Button -->
                <button
                    onclick="vote({{ $comment->id }}, 'comment', 'down')"
                    class="vote-btn group flex items-center space-x-1.5 rounded-lg border border-transparent px-3 py-1.5 text-slate-400 transition-all duration-200 hover:border-red-500/30 hover:bg-red-500/15 hover:text-red-400 focus:ring-2 focus:ring-red-500/30 focus:outline-none"
                    data-vote-type="down"
                    data-target-id="{{ $comment->id }}"
                    data-target-type="comment"
                >
                    <div
                        class="flex h-5 w-5 items-center justify-center rounded-full transition-all duration-200 group-hover:bg-red-500/20 group-hover:shadow-md group-hover:shadow-red-500/20"
                    >
                        <svg
                            class="h-3.5 w-3.5 transition-transform duration-200 group-hover:scale-110"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M19 9l-7 7-7-7"
                            ></path>
                        </svg>
                    </div>
                    <span
                        id="dislikes-count-{{ $comment->id }}"
                        class="text-xs font-bold transition-colors duration-200 group-hover:text-red-400"
                    >
                        {{ $comment->dislikes_count ?? 0 }}
                    </span>
                </button>
            </div>

            <!-- Action Buttons -->
            @auth
                <div class="flex items-center space-x-2">
                    @if ($comment->can_reply ?? true)
                        <button
                            onclick="toggleReplyForm({{ $comment->id }})"
                            class="rounded-lg px-3 py-1.5 text-sm text-slate-400 transition-colors hover:bg-slate-700 hover:text-white"
                        >
                            Responder
                        </button>
                    @endif

                    @if ($comment->can_delete ?? false)
                        <button
                            onclick="deleteComment({{ $comment->id }})"
                            class="rounded-lg px-3 py-1.5 text-sm text-red-400 transition-colors hover:bg-red-900/20 hover:text-red-300"
                        >
                            Excluir
                        </button>
                    @endif
                </div>
            @endauth
        </div>
    </div>

    <!-- Reply Form (Hidden by default) -->
    @auth
        @if ($comment->can_reply ?? true)
            <div
                id="reply-form-{{ $comment->id }}"
                class="mt-4 hidden rounded-xl border border-slate-600 bg-slate-700/50 p-4"
            >
                <form onsubmit="submitReply(event, {{ $comment->id }})" class="space-y-3">
                    <textarea
                        id="reply-content-{{ $comment->id }}"
                        placeholder="Responder para {{ $comment->user->name }}..."
                        class="w-full rounded-lg border border-slate-600 bg-slate-600/50 px-3 py-2 text-sm text-white placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:bg-slate-600 focus:ring-2 focus:ring-blue-500/20"
                        rows="3"
                        required
                    ></textarea>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            onclick="toggleReplyForm({{ $comment->id }})"
                            class="rounded-lg bg-slate-600 px-4 py-2 text-sm text-slate-300 transition-colors hover:bg-slate-500"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                        >
                            Responder
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endauth

    <!-- Edit Form (Hidden by default) -->
    @auth
        @if (Auth::id() === $comment->user_id)
            <div
                id="edit-form-{{ $comment->id }}"
                class="mt-4 hidden rounded-xl border border-slate-600 bg-slate-700/50 p-4"
            >
                <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea
                        name="content"
                        rows="3"
                        class="w-full rounded-lg border border-slate-600 bg-slate-600/50 px-3 py-2 text-sm text-white placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:bg-slate-600 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Editar comentário..."
                        required
                    >
{{ $comment->content }}</textarea
                    >
                    @error('content')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex justify-end space-x-2">
                        <button
                            type="button"
                            onclick="toggleEditForm({{ $comment->id }})"
                            class="rounded-lg bg-slate-600 px-4 py-2 text-sm text-slate-300 transition-colors hover:bg-slate-500"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                        >
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endauth

    <!-- Nested Comments -->
    @if ($comment->replies->count() > 0)
        <div class="mt-4 space-y-4">
            @foreach ($comment->replies as $reply)
                @include('components.comment', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>

<script>
    // Toggle reply form
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if (form) {
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
            if (form.style.display === 'block') {
                const textarea = document.getElementById(`reply-content-${commentId}`);
                if (textarea) {
                    textarea.focus();
                }
            }
        }
    }
</script>

<?php
