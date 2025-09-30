<?php

declare(strict_types=1);

?>
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
                <a href="{{ route('profile.show') }}">
                    <img
                        src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl() }}"
                        alt="Avatar"
                        class="user-avatar"
                    />
                </a>
            @else
                <a href="{{ route('profile.show') }}">
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
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-enter">Entrar</a>
        @endauth
    </div>
</header>

<style>
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
        transition: all 0.2s;
    }

    .user-avatar:hover {
        border-color: #f97316;
    }

    .btn-enter {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        background: #1a1a1a;
        color: #ccc;
        border: 1px solid #2a2a2a;
    }

    .btn-enter:hover {
        background: #252525;
    }
</style>
<?php 
