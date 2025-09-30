<?php

declare(strict_types=1);

?>
<header
    class="dark:border-dark-border dark:bg-dark-surface sticky top-0 z-10 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-8 transition-colors"
>
    <div></div>

    <div class="flex items-center gap-4">
        {{-- Theme Toggle --}}
        <button
            id="theme-toggle"
            onclick="toggleTheme()"
            class="dark:bg-dark-border dark:hover:bg-dark-hover flex h-10 w-10 items-center justify-center rounded-lg bg-gray-200 text-gray-600 transition-all hover:bg-gray-300 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
        >
            <svg
                id="theme-icon-sun"
                class="hidden"
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
            <svg
                id="theme-icon-moon"
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
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
        </button>

        {{-- User Avatar/Auth --}}
        @auth
            @if (Auth::user()->getFirstMedia('profile-pictures'))
                <a href="{{ route('profile.show') }}">
                    <img
                        src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl() }}"
                        alt="Avatar"
                        class="border-dark-border h-10 w-10 cursor-pointer rounded-full border-2 object-cover transition-all hover:border-orange-500"
                    />
                </a>
            @else
                <a href="{{ route('profile.show') }}">
                    <div
                        class="border-dark-border flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border-2 bg-blue-600 font-bold text-white transition-all hover:border-orange-500"
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </a>
            @endif
        @else
            <a
                href="{{ route('login') }}"
                class="dark:border-dark-hover dark:bg-dark-border dark:hover:bg-dark-hover rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-100 dark:text-gray-400"
            >
                Entrar
            </a>
        @endauth
    </div>
</header>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const sunIcon = document.getElementById('theme-icon-sun');
        const moonIcon = document.getElementById('theme-icon-moon');
        const logo = document.getElementById('sidebar-logo');

        if (html.classList.contains('dark')) {
            // Mudar para tema claro
            html.classList.remove('dark');
            sunIcon?.classList.remove('hidden');
            moonIcon?.classList.add('hidden');
            if (logo) {
                logo.src = '{{ asset('logo_black.svg') }}';
            }
            localStorage.setItem('theme', 'light');
        } else {
            // Mudar para tema escuro
            html.classList.add('dark');
            sunIcon?.classList.add('hidden');
            moonIcon?.classList.remove('hidden');
            if (logo) {
                logo.src = '{{ asset('logo.svg') }}';
            }
            localStorage.setItem('theme', 'dark');
        }
    }

    // Executar imediatamente ao carregar o script
    (function () {
        const theme = localStorage.getItem('theme') || 'dark';
        const html = document.documentElement;

        if (theme === 'light') {
            html.classList.remove('dark');
        } else {
            html.classList.add('dark');
        }

        // Atualizar ícones e logo quando o DOM estiver pronto
        window.addEventListener('DOMContentLoaded', function () {
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            const logo = document.getElementById('sidebar-logo');

            if (theme === 'light') {
                sunIcon?.classList.remove('hidden');
                moonIcon?.classList.add('hidden');
                if (logo) {
                    logo.src = '{{ asset('logo_black.svg') }}';
                }
            } else {
                sunIcon?.classList.add('hidden');
                moonIcon?.classList.remove('hidden');
                if (logo) {
                    logo.src = '{{ asset('logo.svg') }}';
                }
            }
        });
    })();
</script>
<?php 
