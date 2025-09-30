<?php

declare(strict_types=1);

?>

<aside class="sidebar">
    <a href="/" class="logo">
        <div class="logo-icon">3P</div>
        <div>
            <div class="logo-text">3Pontos</div>
            <div class="logo-sub">Community</div>
        </div>
    </a>

    <nav>
        <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
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
        <div class="community-section-title">
            @auth
                Minhas comunidades
            @else
                Comunidades populares
            @endauth
        </div>

        @auth
            @php
                $userCommunities = Auth::user()
                    ->followedCommunities()
                    ->withCount('posts')
                    ->take(4)
                    ->get();
            @endphp

            @forelse ($userCommunities as $community)
                <a href="{{ route('subreddit.show', $community->slug) }}" class="community-item">
                    <span>{{ $community->name }}</span>
                    <span class="community-badge">+{{ $community->posts_count ?? 0 }}</span>
                </a>
            @empty
                <p style="color: #666; font-size: 12px; padding: 0 16px">Você ainda não segue nenhuma comunidade</p>
            @endforelse
        @else
            @foreach ($subreddits ?? [] as $community)
                <a href="{{ route('subreddit.show', $community->slug) }}" class="community-item">
                    <span>{{ $community->name }}</span>
                    <span class="community-badge">+{{ $community->posts_count ?? 0 }}</span>
                </a>
            @endforeach
        @endauth
    </div>
</aside>

<style>
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
        text-decoration: none;
        color: inherit;
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
        color: #fff;
    }

    .logo-text {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
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
</style>

<?php
