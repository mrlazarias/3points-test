<?php

declare(strict_types=1);

?>
<header
    class="bg-dark-surface border-dark-border sticky top-0 z-10 flex h-16 items-center justify-between border-b px-8"
>
    <div></div>

    <div class="flex items-center gap-4">
        {{-- Theme Toggle --}}
        <button
            class="bg-dark-border hover:bg-dark-hover flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 transition-all hover:text-white"
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
                class="bg-dark-border border-dark-hover hover:bg-dark-hover rounded-lg border px-5 py-2.5 text-sm font-semibold text-gray-400 transition-all"
            >
                Entrar
            </a>
        @endauth
    </div>
</header>
<?php 
