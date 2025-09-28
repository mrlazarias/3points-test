<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>r/{{ $subreddit->slug }} - 3Pontos Community</title>
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
                    <a
                        href="/"
                        style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit"
                    >
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
                    </a>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem">
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
            <!-- Subreddit Header -->
            <div style="margin-bottom: 2rem">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem">
                    <div
                        style="
                            width: 4rem;
                            height: 4rem;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 1.5rem;
                            font-weight: bold;
                            color: white;
                        "
                        style="background-color: {{ $subreddit->color }}"
                    >
                        {{ strtoupper(substr($subreddit->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 style="font-size: 2rem; font-weight: bold; margin: 0">r/{{ $subreddit->slug }}</h1>
                        <p style="color: #9ca3af; margin: 0.25rem 0 0 0">{{ $subreddit->description }}</p>
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
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem"
                    >
                        <div style="text-align: center">
                            <p style="font-size: 1.5rem; font-weight: bold; margin: 0">{{ $posts->total() }}</p>
                            <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0">Posts</p>
                        </div>
                        <div style="text-align: center">
                            <p style="font-size: 1.5rem; font-weight: bold; margin: 0">
                                {{ number_format(rand(1000, 5000)) }}
                            </p>
                            <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0">Membros</p>
                        </div>
                        <div style="text-align: center">
                            <p style="font-size: 1.5rem; font-weight: bold; margin: 0">
                                {{ $subreddit->created_at->format('Y') }}
                            </p>
                            <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0">Criado em</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem">
                <!-- Main Content -->
                <div>
                    <div style="margin-bottom: 1.5rem">
                        <h2 style="font-size: 1.25rem; font-weight: bold; margin: 0">Posts da comunidade</h2>
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
                                            <span style="font-size: 1.125rem">👨‍💻</span>
                                        </div>
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 0.5rem">
                                                <span style="font-weight: 500; color: #d1d5db">
                                                    {{ $post->user->name }}
                                                </span>
                                                <span style="color: #6b7280; font-size: 0.875rem">
                                                    {{ $post->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Post Content -->
                                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.75rem">
                                        <a
                                            href="{{ route('post.show', [$subreddit->slug, $post->slug]) }}"
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
                                <p style="color: #9ca3af; margin: 0">Nenhum post encontrado nesta comunidade.</p>
                                <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 0">
                                    Seja o primeiro a postar aqui!
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

                <!-- Sidebar -->
                <div>
                    <div
                        style="
                            background-color: #1f2937;
                            border: 1px solid #374151;
                            border-radius: 0.75rem;
                            padding: 1.5rem;
                        "
                    >
                        <h3 style="font-weight: 500; color: #e5e7eb; margin: 0 0 1rem 0">
                            Sobre r/{{ $subreddit->slug }}
                        </h3>
                        <p style="color: #9ca3af; font-size: 0.875rem; line-height: 1.5; margin: 0 0 1rem 0">
                            {{ $subreddit->description }}
                        </p>
                        <div style="border-top: 1px solid #374151; padding-top: 1rem">
                            <p style="color: #6b7280; font-size: 0.75rem; margin: 0">
                                Criado por {{ $subreddit->creator->name }} em
                                {{ $subreddit->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
