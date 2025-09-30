<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ $subreddit->name }} - 3Pontos Community</title>

        <!-- Satoshi Font -->
        <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,400&display=swap" rel="stylesheet" />

        <!-- Cal Sans Font -->
        <link href="https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@800,700,500&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family:
                    'Satoshi',
                    -apple-system,
                    BlinkMacSystemFont,
                    'Segoe UI',
                    sans-serif;
                background-color: #0a0a0a;
                color: #ffffff;
                min-height: 100vh;
            }

            .cal-sans {
                font-family: 'Cabinet Grotesk', 'Satoshi', sans-serif;
            }

            /* Sidebar */
            .sidebar {
                width: 240px;
                height: 100vh;
                background: #0e0e0e;
                border-right: 1px solid #1a1a1a;
                position: fixed;
                left: 0;
                top: 0;
                padding: 24px 16px;
                display: flex;
                flex-direction: column;
                gap: 32px;
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 0 8px;
            }

            .logo-icon {
                width: 32px;
                height: 32px;
                background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 14px;
            }

            .logo-text {
                font-size: 18px;
                font-weight: 600;
            }

            .logo-sub {
                font-size: 14px;
                color: #666;
                font-weight: 400;
            }

            .nav-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 16px;
                border-radius: 8px;
                color: #888;
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.2s;
            }

            .nav-item:hover,
            .nav-item.active {
                background: #1a1a1a;
                color: #fff;
            }

            .community-section {
                margin-top: auto;
            }

            .community-section-title {
                font-size: 12px;
                color: #666;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 0 16px;
                margin-bottom: 12px;
            }

            .community-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px 16px;
                border-radius: 8px;
                text-decoration: none;
                color: #ccc;
                font-size: 14px;
                transition: all 0.2s;
            }

            .community-item:hover {
                background: #1a1a1a;
            }

            .community-badge {
                background: #1a1a1a;
                color: #888;
                font-size: 11px;
                font-weight: 600;
                padding: 2px 8px;
                border-radius: 12px;
            }

            /* Main Content */
            .main-content {
                margin-left: 240px;
                min-height: 100vh;
            }

            /* Header */
            .header {
                height: 64px;
                background: #0e0e0e;
                border-bottom: 1px solid #1a1a1a;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 32px;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .header-actions {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .theme-toggle {
                width: 40px;
                height: 40px;
                background: #1a1a1a;
                border: none;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #888;
                cursor: pointer;
                transition: all 0.2s;
            }

            .theme-toggle:hover {
                background: #252525;
                color: #fff;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #1a1a1a;
                cursor: pointer;
            }

            /* Community Header */
            .community-header {
                position: relative;
                height: 200px;
                background: linear-gradient(180deg, {{ $subreddit->color }}20 0%, #0a0a0a 100%);
                border-bottom: 1px solid #1a1a1a;
            }

            .community-info {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 32px;
                position: relative;
                transform: translateY(-48px);
            }

            .community-avatar {
                width: 96px;
                height: 96px;
                background: {{ $subreddit->color }};
                border-radius: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 42px;
                font-weight: 700;
                border: 4px solid #0a0a0a;
                margin-bottom: 16px;
            }

            .community-title {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 12px;
            }

            .community-name {
                font-size: 32px;
                font-weight: 700;
                margin: 0;
            }

            .community-description {
                font-size: 16px;
                color: #999;
                margin: 0 0 16px 0;
                line-height: 1.5;
            }

            .community-meta {
                display: flex;
                align-items: center;
                gap: 24px;
            }

            .community-meta-item {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 14px;
                color: #666;
            }

            .community-meta-icon {
                width: 16px;
                height: 16px;
                color: #888;
            }

            .btn-enter,
            .btn-create-post {
                padding: 12px 24px;
                border-radius: 12px;
                font-size: 14px;
                font-weight: 600;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-enter {
                background: {{ $isFollowing ? '#059669' : '#1A1A1A' }};
                color: {{ $isFollowing ? '#FFF' : '#CCC' }};
                border: 1px solid {{ $isFollowing ? '#059669' : '#2A2A2A' }};
            }

            .btn-enter:hover {
                background: {{ $isFollowing ? '#047857' : '#252525' }};
            }

            .btn-create-post {
                background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
                color: #fff;
            }

            .btn-create-post:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
            }

            /* Content Grid */
            .content-wrapper {
                max-width: 1200px;
                margin: 0 auto;
                padding: 32px;
            }

            .posts-section-title {
                font-size: 24px;
                font-weight: 700;
                margin-bottom: 24px;
            }

            /* Post Card */
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

            .post-author {
                font-size: 14px;
                font-weight: 600;
                color: #fff;
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
                gap: 16px;
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
        </style>
    </head>
    <body>
        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="/" class="logo">
                <div class="logo-icon">3P</div>
                <div>
                    <div class="logo-text">3Pontos</div>
                    <div class="logo-sub">Community</div>
                </div>
            </a>

            <nav>
                <a href="/" class="nav-item">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Home
                </a>
            </nav>

            <div class="community-section">
                <div class="community-section-title">Minhas comunidades</div>
                @auth
                    @php
                        $userCommunities = Auth::user()
                            ->followedCommunities()
                            ->take(4)
                            ->get();
                    @endphp

                    @foreach ($userCommunities as $community)
                        <a href="{{ route('subreddit.show', $community->slug) }}" class="community-item">
                            <span>{{ $community->name }}</span>
                            <span class="community-badge">+{{ $community->posts_count ?? 0 }}</span>
                        </a>
                    @endforeach
                @else
                    <a href="/r/laravel" class="community-item">
                        <span>UI/UX</span>
                        <span class="community-badge">+999</span>
                    </a>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div></div>
                <div class="header-actions">
                    <button class="theme-toggle">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="12" cy="12" r="5" />
                            <line x1="12" y1="1" x2="12" y2="3" />
                            <line x1="12" y1="21" x2="12" y2="23" />
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                            <line x1="1" y1="12" x2="3" y2="12" />
                            <line x1="21" y1="12" x2="23" y2="12" />
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                        </svg>
                    </button>

                    @auth
                        @if (Auth::user()->getFirstMedia('profile-pictures'))
                            <img
                                src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl() }}"
                                alt="Avatar"
                                class="user-avatar"
                            />
                        @else
                            <div
                                class="user-avatar"
                                style="
                                    background: #2563eb;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 700;
                                    font-size: 16px;
                                "
                            >
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-enter">Entrar</a>
                    @endauth
                </div>
            </header>

            <!-- Community Header -->
            <div class="community-header"></div>

            <div class="community-info">
                <div class="community-avatar">😎</div>

                <div class="community-title">
                    <div>
                        <h1 class="community-name cal-sans">/r {{ $subreddit->name }}</h1>
                        <p class="community-description">{{ $subreddit->description }}</p>

                        <div class="community-meta">
                            <div class="community-meta-item">
                                <svg
                                    class="community-meta-icon"
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

                            <div class="community-meta-item">
                                <svg
                                    class="community-meta-icon"
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

                    <div style="display: flex; gap: 12px">
                        @auth
                            <button
                                id="follow-btn-{{ $subreddit->id }}"
                                onclick="toggleFollow({{ $subreddit->id }}, '{{ $subreddit->slug }}')"
                                class="btn-enter"
                            >
                                <span id="follow-text-{{ $subreddit->id }}">
                                    {{ $isFollowing ? 'Seguindo' : 'Entrar' }}
                                </span>
                            </button>
                            <a href="{{ route('post.create', $subreddit->slug) }}" class="btn-create-post">
                                Criar post
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-enter">Entrar</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Posts Section -->
            <div class="content-wrapper">
                <h2 class="posts-section-title">Veja todos os posts da comunidade</h2>

                <div class="posts-list">
                    @forelse ($posts as $post)
                        <article class="post-card">
                            <div class="post-header">
                                <div class="post-avatar">😎</div>
                                <div>
                                    <div class="post-author">/r/dev</div>
                                    <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                                </div>
                            </div>

                            <a href="{{ route('post.show', [$subreddit->slug, $post->slug]) }}" class="post-title">
                                {{ $post->title }}
                            </a>

                            <p class="post-content">{{ Str::limit(strip_tags($post->content), 200) }}</p>

                            <div class="post-footer">
                                <button class="post-action" id="comment-btn-{{ $post->id }}">
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

                                <button class="post-action">Responder</button>
                            </div>
                        </article>
                    @empty
                        <div class="post-card" style="text-align: center; color: #666">
                            <p>Nenhum post encontrado nesta comunidade.</p>
                            <p style="font-size: 14px; margin-top: 8px">Seja o primeiro a postar aqui!</p>
                        </div>
                    @endforelse
                </div>

                @if ($posts->hasPages())
                    <div style="margin-top: 32px">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </main>

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            async function votePost(postId, voteType) {
                const upButton = document.getElementById(`upvote-${postId}`);
                const downButton = document.getElementById(`downvote-${postId}`);

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
                        // Reset both buttons
                        upButton.classList.remove('active-like');
                        downButton.classList.remove('active-dislike');

                        // Add active class if vote was added
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
                        button.style.background = data.is_following ? '#059669' : '#1A1A1A';
                        button.style.color = data.is_following ? '#FFF' : '#CCC';
                    }
                } catch (error) {
                    console.error('Erro:', error);
                } finally {
                    button.disabled = false;
                }
            }
        </script>
    </body>
</html>

<?php
