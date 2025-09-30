<?php

declare(strict_types=1);

?>
<aside
    id="sidebar"
    class="dark:border-dark-border dark:bg-dark-surface fixed top-0 left-0 z-50 flex h-screen w-60 flex-col border-r border-gray-200 bg-white p-6 transition-all duration-300"
>
    {{-- Toggle Button --}}
    <button
        id="sidebar-toggle"
        onclick="toggleSidebar()"
        class="dark:bg-dark-border dark:hover:bg-dark-hover absolute top-6 -right-3 flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-600 transition-all hover:bg-gray-300 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
    >
        <svg
            id="toggle-icon"
            xmlns="http://www.w3.org/2000/svg"
            width="14"
            height="14"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <polyline points="15 18 9 12 15 6" />
        </svg>
    </button>

    {{-- Sidebar Content --}}
    <div id="sidebar-content" class="flex h-full flex-col">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3 px-2">
            <img id="sidebar-logo" src="{{ asset('logo.svg') }}" alt="3Pontos" class="h-10 w-auto flex-shrink-0" />
        </a>

        {{-- Navigation --}}
        <nav class="mt-8">
            <a
                href="/"
                class="{{ request()->is('/') ? 'dark:bg-dark-hover bg-gray-100 text-gray-900 dark:text-white' : 'dark:hover:bg-dark-hover text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }} flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition-all"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="flex-shrink-0"
                >
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span class="sidebar-text">Home</span>
            </a>
        </nav>

        {{-- Communities Section --}}
        <div class="mt-8 flex flex-1 flex-col overflow-hidden">
            <div class="mb-4 px-2">
                <span class="sidebar-text text-xs font-semibold tracking-wider text-gray-600 uppercase">
                    @auth
                        Minhas comunidades
                    @else
                        Comunidades populares
                    @endauth
                </span>
            </div>

            <div class="sidebar-text flex-1 space-y-1 overflow-y-auto">
                @auth
                    @php
                        // Buscar comunidades que o usuário criou
                        $createdCommunities = Auth::user()
                            ->subreddits()
                            ->withCount('posts')
                            ->get();

                        // Buscar comunidades que o usuário segue
                        $followedCommunities = Auth::user()
                            ->followedCommunities()
                            ->withCount('posts')
                            ->get();

                        // Merge e remover duplicatas
                        $userCommunities = $createdCommunities
                            ->merge($followedCommunities)
                            ->unique('id')
                            ->sortBy('name');
                    @endphp

                    @forelse ($userCommunities as $community)
                        <a
                            href="{{ route('subreddit.show', $community->slug) }}"
                            class="group dark:hover:bg-dark-hover flex items-center gap-3 rounded-lg px-3 py-2.5 transition-all hover:bg-gray-100"
                        >
                            {{-- Community Icon/Avatar --}}
                            <div
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg text-lg"
                                style="background-color: {{ $community->color ?? '#f97316' }}"
                            >
                                😎
                            </div>

                            {{-- Community Name --}}
                            <span
                                class="flex-1 truncate text-sm font-medium text-gray-700 transition-colors group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            >
                                {{ $community->name }}
                            </span>

                            {{-- Posts Count Badge --}}
                            <span
                                class="bg-dark-border flex-shrink-0 rounded-md px-2 py-1 text-xs font-semibold text-gray-500 transition-all group-hover:bg-[#1e1e22] group-hover:text-gray-400"
                            >
                                +{{ $community->posts_count ?? 0 }}
                            </span>
                        </a>
                    @empty
                        <p class="px-3 text-xs text-gray-600">Você ainda não segue nenhuma comunidade</p>
                    @endforelse
                @else
                    @foreach ($subreddits ?? [] as $community)
                        <a
                            href="{{ route('subreddit.show', $community->slug) }}"
                            class="group dark:hover:bg-dark-hover flex items-center gap-3 rounded-lg px-3 py-2.5 transition-all hover:bg-gray-100"
                        >
                            {{-- Community Icon/Avatar --}}
                            <div
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg text-lg"
                                style="background-color: {{ $community->color ?? '#f97316' }}"
                            >
                                😎
                            </div>

                            {{-- Community Name --}}
                            <span
                                class="flex-1 truncate text-sm font-medium text-gray-700 transition-colors group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            >
                                {{ $community->name }}
                            </span>

                            {{-- Posts Count Badge --}}
                            <span
                                class="bg-dark-border flex-shrink-0 rounded-md px-2 py-1 text-xs font-semibold text-gray-500 transition-all group-hover:bg-[#1e1e22] group-hover:text-gray-400"
                            >
                                +{{ $community->posts_count ?? 0 }}
                            </span>
                        </a>
                    @endforeach
                @endauth
            </div>
        </div>
    </div>
</aside>

{{-- Script para toggle da sidebar --}}
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleIcon = document.getElementById('toggle-icon');
        const content = document.getElementById('sidebar-content');
        const mainContent = document.querySelector('main.ml-60');

        sidebar.classList.toggle('w-60');
        sidebar.classList.toggle('w-20');

        if (sidebar.classList.contains('w-20')) {
            // Collapsed
            content.classList.add('opacity-0');
            setTimeout(() => {
                const texts = document.querySelectorAll('.sidebar-text');
                texts.forEach((text) => text.classList.add('hidden'));
                content.classList.remove('opacity-0');
            }, 150);

            toggleIcon.innerHTML = '<polyline points="9 18 15 12 9 6" />';
            if (mainContent) {
                mainContent.classList.remove('ml-60');
                mainContent.classList.add('ml-20');
            }
        } else {
            // Expanded
            const texts = document.querySelectorAll('.sidebar-text');
            texts.forEach((text) => text.classList.remove('hidden'));

            toggleIcon.innerHTML = '<polyline points="15 18 9 12 15 6" />';
            if (mainContent) {
                mainContent.classList.remove('ml-20');
                mainContent.classList.add('ml-60');
            }
        }

        // Salvar estado no localStorage
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('w-20'));
    }

    // Restaurar estado ao carregar
    document.addEventListener('DOMContentLoaded', function () {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            toggleSidebar();
        }
    });
</script>
<?php 
