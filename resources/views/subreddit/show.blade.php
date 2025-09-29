<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
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

                    @auth
                        <!-- User Menu -->
                        <div style="display: flex; align-items: center; gap: 0.75rem">
                            <a
                                href="{{ route('profile.show') }}"
                                style="
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    color: #d1d5db;
                                    text-decoration: none;
                                    font-size: 0.875rem;
                                "
                                onmouseover="this.style.color='#f9fafb'"
                                onmouseout="this.style.color='#d1d5db'"
                            >
                                @if (Auth::user()->getFirstMedia('profile-pictures'))
                                    <img
                                        src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl() }}"
                                        alt="Foto de perfil"
                                        style="
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 1px solid #374151;
                                        "
                                    />
                                @else
                                    <div
                                        style="
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            background-color: #2563eb;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 0.75rem;
                                            font-weight: bold;
                                            color: white;
                                        "
                                    >
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0">
                                @csrf
                                <button
                                    type="submit"
                                    style="
                                        padding: 0.5rem 1rem;
                                        background-color: #dc2626;
                                        color: white;
                                        border: none;
                                        border-radius: 0.5rem;
                                        font-size: 0.875rem;
                                        cursor: pointer;
                                        transition: background-color 0.2s;
                                    "
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                >
                                    Sair
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Auth Links -->
                        <div style="display: flex; align-items: center; gap: 0.75rem">
                            <a
                                href="{{ route('login') }}"
                                style="
                                    color: #9ca3af;
                                    text-decoration: none;
                                    font-size: 0.875rem;
                                    transition: color 0.2s;
                                "
                                onmouseover="this.style.color='#f9fafb'"
                                onmouseout="this.style.color='#9ca3af'"
                            >
                                Entrar
                            </a>
                            <a
                                href="{{ route('register') }}"
                                style="
                                    padding: 0.5rem 1rem;
                                    background-color: #2563eb;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    transition: background-color 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#1d4ed8'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                            >
                                Registrar
                            </a>
                        </div>
                    @endauth
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
                    <div
                        style="
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 1.5rem;
                        "
                    >
                        <h2 style="font-size: 1.25rem; font-weight: bold; margin: 0">Posts da comunidade</h2>

                        @auth
                            <a
                                href="{{ route('post.create', $subreddit->slug) }}"
                                style="
                                    padding: 0.75rem 1.5rem;
                                    background-color: #2563eb;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    transition: background-color 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#1d4ed8'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                            >
                                + Criar Post
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                style="
                                    padding: 0.75rem 1.5rem;
                                    background-color: #374151;
                                    color: #e5e7eb;
                                    text-decoration: none;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    transition: background-color 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#4b5563'"
                                onmouseout="this.style.backgroundColor='#374151'"
                            >
                                + Criar Post
                            </a>
                        @endauth
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
                                            @auth
                                                <button
                                                    onclick="votePost({{ $post->id }}, 'up')"
                                                    id="upvote-{{ $post->id }}"
                                                    style="
                                                        padding: 0.5rem;
                                                        color: #9ca3af;
                                                        border-radius: 0.5rem;
                                                        background: none;
                                                        border: none;
                                                        cursor: pointer;
                                                        transition: all 0.2s;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#374151'"
                                                    onmouseout="this.style.backgroundColor='transparent'"
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
                                            @else
                                                <button
                                                    onclick="showLoginAlert()"
                                                    style="
                                                        padding: 0.5rem;
                                                        color: #9ca3af;
                                                        border-radius: 0.5rem;
                                                        background: none;
                                                        border: none;
                                                        cursor: pointer;
                                                        transition: all 0.2s;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#374151'"
                                                    onmouseout="this.style.backgroundColor='transparent'"
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
                                            @endauth

                                            <span
                                                id="vote-score-{{ $post->id }}"
                                                style="
                                                    font-size: 0.875rem;
                                                    font-weight: 500;
                                                    min-width: 2rem;
                                                    text-align: center;
                                                "
                                            >
                                                {{ $post->vote_score }}
                                            </span>

                                            @auth
                                                <button
                                                    onclick="votePost({{ $post->id }}, 'down')"
                                                    id="downvote-{{ $post->id }}"
                                                    style="
                                                        padding: 0.5rem;
                                                        color: #9ca3af;
                                                        border-radius: 0.5rem;
                                                        background: none;
                                                        border: none;
                                                        cursor: pointer;
                                                        transition: all 0.2s;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#374151'"
                                                    onmouseout="this.style.backgroundColor='transparent'"
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
                                            @else
                                                <button
                                                    onclick="showLoginAlert()"
                                                    style="
                                                        padding: 0.5rem;
                                                        color: #9ca3af;
                                                        border-radius: 0.5rem;
                                                        background: none;
                                                        border: none;
                                                        cursor: pointer;
                                                        transition: all 0.2s;
                                                    "
                                                    onmouseover="this.style.backgroundColor='#374151'"
                                                    onmouseout="this.style.backgroundColor='transparent'"
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
                                            @endauth
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

        <!-- JavaScript para funcionalidade de votação -->
        <script>
            // CSRF Token para requisições AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Função para votar em posts
            async function votePost(postId, voteType) {
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
                        // Atualizar o score do voto
                        const scoreElement = document.getElementById(`vote-score-${postId}`);
                        if (scoreElement) {
                            scoreElement.textContent = data.vote_score;
                        }

                        // Atualizar visual dos botões
                        updateVoteButtons(postId, data.vote_type, data.action);
                    } else {
                        console.error('Erro ao votar:', data.message);
                        alert('Erro ao votar. Tente novamente.');
                    }
                } catch (error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro de conexão. Tente novamente.');
                }
            }

            // Função para atualizar visual dos botões de votação
            function updateVoteButtons(postId, voteType, action) {
                const upButton = document.getElementById(`upvote-${postId}`);
                const downButton = document.getElementById(`downvote-${postId}`);

                // Resetar todos os botões
                if (upButton) {
                    upButton.style.color = '#9ca3af';
                    upButton.style.backgroundColor = 'transparent';
                }
                if (downButton) {
                    downButton.style.color = '#9ca3af';
                    downButton.style.backgroundColor = 'transparent';
                }

                // Aplicar estilo baseado na ação
                if (action === 'removed') {
                    // Nenhum voto ativo
                    return;
                }

                if (voteType === 'up' && upButton) {
                    upButton.style.color = '#10b981';
                    upButton.style.backgroundColor = '#064e3b';
                } else if (voteType === 'down' && downButton) {
                    downButton.style.color = '#ef4444';
                    downButton.style.backgroundColor = '#7f1d1d';
                }
            }

            // Função para mostrar alerta de login
            function showLoginAlert() {
                alert('Você precisa fazer login para votar. Redirecionando...');
                window.location.href = '{{ route('login') }}';
            }
        </script>
    </body>
</html>

<?php
