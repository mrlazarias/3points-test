<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>3Pontos Community</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background-color: #111827; color: #f9fafb; min-height: 100vh">
        <!-- Header -->
        <header style="background-color: #1f2937; border-bottom: 1px solid #374151; padding: 1rem 1.5rem">
            <div
                style="
                    max-width: 80rem;
                    margin: 0 auto;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >
                <div style="display: flex; align-items: center; gap: 1rem">
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 2rem;
                                height: 2rem;
                                background-color: #f97316;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <span style="color: white; font-weight: bold; font-size: 0.875rem">3P</span>
                        </div>
                        <span style="font-size: 1.25rem; font-weight: 600">3Pontos</span>
                        <span style="color: #9ca3af; font-size: 0.875rem">Community</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem">
                    <button
                        style="padding: 0.5rem; color: #9ca3af; border-radius: 0.5rem; background: none; border: none"
                    >
                        <svg
                            style="width: 1.25rem; height: 1.25rem"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            ></path>
                        </svg>
                    </button>
                    <div
                        style="
                            width: 2rem;
                            height: 2rem;
                            background-color: #2563eb;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        "
                    >
                        <span style="color: white; font-size: 0.875rem; font-weight: 500">$</span>
                    </div>
                </div>
            </div>
        </header>

        <div style="max-width: 80rem; margin: 0 auto; padding: 2rem 1.5rem">
            <!-- Welcome Section -->
            <div style="margin-bottom: 2rem">
                <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem">
                    Olá,
                    <span style="color: #60a5fa">$user</span>
                </h1>
                <p style="color: #9ca3af">Confira as estatísticas das comunidades que você segue</p>
            </div>

            <!-- Stats Cards -->
            <div
                style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 1.5rem;
                    margin-bottom: 2rem;
                "
            >
                <div
                    style="
                        background-color: #1f2937;
                        border: 1px solid #374151;
                        border-radius: 0.75rem;
                        padding: 1.5rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 3rem;
                                height: 3rem;
                                background-color: #2563eb;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <svg
                                style="width: 1.5rem; height: 1.5rem; color: white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 0.875rem">Quantidade de usuários</p>
                            <p style="font-size: 1.5rem; font-weight: bold">10000</p>
                        </div>
                    </div>
                </div>

                <div
                    style="
                        background-color: #1f2937;
                        border: 1px solid #374151;
                        border-radius: 0.75rem;
                        padding: 1.5rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 3rem;
                                height: 3rem;
                                background-color: #16a34a;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <svg
                                style="width: 1.5rem; height: 1.5rem; color: white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 0.875rem">Quantidade de posts</p>
                            <p style="font-size: 1.5rem; font-weight: bold">{{ $posts->total() }}</p>
                        </div>
                    </div>
                </div>

                <div
                    style="
                        background-color: #1f2937;
                        border: 1px solid #374151;
                        border-radius: 0.75rem;
                        padding: 1.5rem;
                    "
                >
                    <div style="display: flex; align-items: center; gap: 0.75rem">
                        <div
                            style="
                                width: 3rem;
                                height: 3rem;
                                background-color: #9333ea;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <svg
                                style="width: 1.5rem; height: 1.5rem; color: white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p style="color: #9ca3af; font-size: 0.875rem">Quantidade de replies</p>
                            <p style="font-size: 1.5rem; font-weight: bold">10000</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem">
                <!-- Sidebar -->
                <div>
                    <!-- Navigation -->
                    <nav style="margin-bottom: 1.5rem">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem">
                            <svg
                                style="width: 1.25rem; height: 1.25rem; color: #9ca3af"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                                ></path>
                            </svg>
                            <span style="font-weight: 500">Home</span>
                        </div>
                    </nav>

                    <!-- Communities -->
                    <div style="background-color: #1f2937; border: 1px solid #374151; border-radius: 0.75rem">
                        <div style="padding: 1rem; border-bottom: 1px solid #374151">
                            <h3 style="font-weight: 500; color: #e5e7eb">Minhas comunidades</h3>
                        </div>
                        <div style="padding: 0.5rem">
                            @foreach ($subreddits as $subreddit)
                                @php
                                    $icons = ['🎨', '🔥', '🌱', '💻', '⚡'];
                                    $icon = $icons[array_rand($icons)];
                                @endphp

                                <a
                                    href="{{ route('subreddit.show', $subreddit->slug) }}"
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        padding: 0.75rem;
                                        border-radius: 0.5rem;
                                        text-decoration: none;
                                        color: inherit;
                                    "
                                    onmouseover="this.style.backgroundColor='#374151'"
                                    onmouseout="this.style.backgroundColor='transparent'"
                                >
                                    <div style="display: flex; align-items: center; gap: 0.75rem">
                                        <span style="font-size: 1.125rem">{{ $icon }}</span>
                                        <span style="color: #e5e7eb">{{ $subreddit->name }}</span>
                                    </div>
                                    <span style="color: #9ca3af; font-size: 0.875rem">
                                        +{{ $subreddit->posts_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div>
                    <div style="margin-bottom: 1.5rem">
                        <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem">
                            Veja os últimos posts das comunidades que você segue
                        </h2>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem">
                        @forelse ($posts as $post)
                            <article
                                style="
                                    background-color: #1f2937;
                                    border: 1px solid #374151;
                                    border-radius: 0.75rem;
                                    overflow: hidden;
                                "
                            >
                                <div style="padding: 1.5rem">
                                    <!-- Post Header -->
                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem">
                                        @php
                                            $icons = ['👨‍💻', '🔧', '🎯', '💡', '🚀'];
                                            $icon = $icons[array_rand($icons)];
                                        @endphp

                                        <div
                                            style="
                                                width: 2.5rem;
                                                height: 2.5rem;
                                                background-color: #374151;
                                                border-radius: 50%;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                            "
                                        >
                                            <span style="font-size: 1.125rem">{{ $icon }}</span>
                                        </div>
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 0.5rem">
                                                <span style="font-weight: 500; color: #d1d5db">
                                                    r/{{ $post->subreddit->slug }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.75rem">
                                        <a
                                            href="{{ route('post.show', [$post->subreddit->slug, $post->slug]) }}"
                                            style="color: inherit; text-decoration: none"
                                            onmouseover="this.style.color='#60a5fa'"
                                            onmouseout="this.style.color='inherit'"
                                        >
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p style="color: #d1d5db; line-height: 1.6; margin-bottom: 1rem">
                                        {{ Str::limit(strip_tags($post->content), 200) }}
                                    </p>

                                    <!-- Post Actions -->
                                    <div style="display: flex; align-items: center; gap: 1.5rem">
                                        <div style="display: flex; align-items: center; gap: 0.5rem">
                                            <button
                                                style="
                                                    display: flex;
                                                    align-items: center;
                                                    gap: 0.25rem;
                                                    color: #9ca3af;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                "
                                            >
                                                <svg
                                                    style="width: 1.25rem; height: 1.25rem"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                                    ></path>
                                                </svg>
                                                <span style="font-size: 0.875rem">{{ $post->comment_count }}</span>
                                            </button>
                                        </div>

                                        <div style="display: flex; align-items: center; gap: 0.5rem">
                                            <button
                                                style="
                                                    padding: 0.5rem;
                                                    color: #9ca3af;
                                                    border-radius: 0.5rem;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                "
                                            >
                                                <svg
                                                    style="width: 1.25rem; height: 1.25rem"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 15l7-7 7 7"
                                                    ></path>
                                                </svg>
                                            </button>
                                            <span style="font-size: 0.875rem; font-weight: 500">
                                                {{ $post->vote_score }}
                                            </span>
                                            <button
                                                style="
                                                    padding: 0.5rem;
                                                    color: #9ca3af;
                                                    border-radius: 0.5rem;
                                                    background: none;
                                                    border: none;
                                                    cursor: pointer;
                                                "
                                            >
                                                <svg
                                                    style="width: 1.25rem; height: 1.25rem"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 9l-7 7-7-7"
                                                    ></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <button
                                            style="
                                                padding: 0.5rem 1rem;
                                                background-color: #374151;
                                                color: #e5e7eb;
                                                border-radius: 0.5rem;
                                                border: none;
                                                font-size: 0.875rem;
                                                cursor: pointer;
                                            "
                                        >
                                            Responder
                                        </button>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div
                                style="
                                    background-color: #1f2937;
                                    border: 1px solid #374151;
                                    border-radius: 0.75rem;
                                    padding: 2rem;
                                    text-align: center;
                                "
                            >
                                <p style="color: #9ca3af">Nenhum post encontrado.</p>
                                <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem">
                                    Seja o primeiro a compartilhar algo!
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($posts->hasPages())
                        <div style="margin-top: 2rem">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
