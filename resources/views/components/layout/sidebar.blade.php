<?php

declare(strict_types=1);

?>
<aside class="bg-dark-surface border-dark-border fixed top-0 left-0 flex h-screen w-60 flex-col gap-8 border-r p-6">
    {{-- Logo --}}
    <a href="/" class="flex items-center gap-3 px-2">
        <div
            class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-orange-500 to-orange-600"
        >
            <span class="text-sm font-bold text-white">3P</span>
        </div>
        <div>
            <div class="text-lg font-semibold text-white">3Pontos</div>
            <div class="text-sm text-gray-600">Community</div>
        </div>
    </a>

    {{-- Navigation --}}
    <nav>
        <a
            href="/"
            class="{{ request()->is('/') ? 'bg-dark-border text-white' : 'hover:bg-dark-border text-gray-500 hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-all"
        >
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

    {{-- Communities Section --}}
    <div class="mt-auto">
        <div class="mb-3 px-4 text-xs font-semibold tracking-wide text-gray-600 uppercase">
            @auth
                Minhas comunidades
            @else
                Comunidades populares
            @endauth
        </div>

        <div class="space-y-1">
            @auth
                @php
                    $userCommunities = Auth::user()
                        ->followedCommunities()
                        ->withCount('posts')
                        ->take(4)
                        ->get();
                @endphp

                @forelse ($userCommunities as $community)
                    <a
                        href="{{ route('subreddit.show', $community->slug) }}"
                        class="hover:bg-dark-border flex items-center justify-between rounded-lg px-4 py-2 text-sm text-gray-400 transition-all"
                    >
                        <span>{{ $community->name }}</span>
                        <span class="bg-dark-border rounded-full px-2 py-0.5 text-xs font-semibold text-gray-500">
                            +{{ $community->posts_count ?? 0 }}
                        </span>
                    </a>
                @empty
                    <p class="px-4 text-xs text-gray-600">Você ainda não segue nenhuma comunidade</p>
                @endforelse
            @else
                @foreach ($subreddits ?? [] as $community)
                    <a
                        href="{{ route('subreddit.show', $community->slug) }}"
                        class="hover:bg-dark-border flex items-center justify-between rounded-lg px-4 py-2 text-sm text-gray-400 transition-all"
                    >
                        <span>{{ $community->name }}</span>
                        <span class="bg-dark-border rounded-full px-2 py-0.5 text-xs font-semibold text-gray-500">
                            +{{ $community->posts_count ?? 0 }}
                        </span>
                    </a>
                @endforeach
            @endauth
        </div>
    </div>
</aside>
<?php 
