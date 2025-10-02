<?php

declare(strict_types=1);

?>

@props([
    'comment',
    'post',
])
<div
    class="border-dark-border {{ ($comment->depth ?? 0) > 0 ? 'ml-' . ($comment->depth ?? 0) * 4 : '' }} border-l-2 pl-4"
    data-comment-id="{{ $comment->id }}"
>
    {{-- Comment Header --}}
    <div class="mb-3 flex items-start gap-3">
        <div class="bg-dark-border flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full text-sm">
            @if ($comment->user->getFirstMedia('profile-pictures'))
                <img
                    src="{{ $comment->user->getFirstMedia('profile-pictures')->getUrl() }}"
                    alt="{{ $comment->user->name }}"
                    class="h-full w-full rounded-full object-cover"
                />
            @else
                😎
            @endif
        </div>
        <div class="flex-1">
            {{-- User and Time --}}
            <div class="mb-2 flex items-center gap-2">
                @if ($comment->user->username)
                    <a
                        href="{{ route('profile.user', $comment->user->username) }}"
                        class="text-sm font-semibold text-white hover:underline"
                    >
                        u/{{ $comment->user->username }}
                    </a>
                @else
                    <span class="text-sm font-semibold text-white">{{ $comment->user->name }}</span>
                @endif
                <span class="text-xs text-gray-600">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            {{-- Comment Content --}}
            <div class="prose prose-invert prose-sm mb-3 max-w-none">
                <p class="text-sm text-gray-300">{{ $comment->content }}</p>
            </div>
            {{-- Comment Actions --}}
            <div class="flex items-center gap-2">
                @auth
                    {{-- Upvote --}}
                    <button
                        id="comment-upvote-{{ $comment->id }}"
                        onclick="voteComment({{ $comment->id }}, 'up')"
                        class="hover:bg-dark-hover bg-dark-border flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition-all hover:text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="12"
                            height="12"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                            />
                        </svg>
                        <span id="comment-upvote-count-{{ $comment->id }}">{{ $comment->likes_count ?? 0 }}</span>
                    </button>
                    {{-- Downvote --}}
                    <button
                        id="comment-downvote-{{ $comment->id }}"
                        onclick="voteComment({{ $comment->id }}, 'down')"
                        class="hover:bg-dark-hover bg-dark-border flex items-center gap-1 rounded px-2 py-1 text-xs text-gray-500 transition-all hover:text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="12"
                            height="12"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                            />
                        </svg>
                        <span id="comment-downvote-count-{{ $comment->id }}">
                            {{ $comment->dislikes_count ?? 0 }}
                        </span>
                    </button>
                @endauth

                {{-- Reply Button --}}
                @if ($comment->canBeRepliedToBy(Auth::user()))
                    <button
                        onclick="toggleReplyForm({{ $comment->id }})"
                        class="text-xs text-gray-500 transition-colors hover:text-orange-500"
                    >
                        Responder
                    </button>
                @endif

                {{-- Delete Button --}}
                @if ($comment->canBeDeletedBy(Auth::user()))
                    <button
                        onclick="deleteComment({{ $comment->id }})"
                        class="text-xs text-red-500 transition-colors hover:text-red-400"
                    >
                        Excluir
                    </button>
                @endif
            </div>
            {{-- Reply Form --}}
            @if ($comment->canBeRepliedToBy(Auth::user()))
                <form
                    id="reply-form-{{ $comment->id }}"
                    action="{{ route('comments.reply', $comment) }}"
                    method="POST"
                    class="mt-4 hidden"
                >
                    @csrf
                    <textarea
                        name="content"
                        rows="3"
                        placeholder="Sua resposta..."
                        class="border-dark-border bg-dark-bg mb-2 w-full rounded-lg border px-3 py-2 text-sm text-white placeholder-gray-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none"
                        required
                    ></textarea>
                    <button
                        type="submit"
                        class="rounded-lg bg-orange-500 px-4 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-orange-600"
                    >
                        Responder
                    </button>
                </form>
            @endif

            {{-- Nested Replies --}}
            @if ($comment->replies && $comment->replies->count() > 0)
                <div class="replies-container mt-4 space-y-4">
                    @foreach ($comment->replies as $reply)
                        <x-comment :comment="$reply" :post="$post" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
