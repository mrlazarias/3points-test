<?php

declare(strict_types=1);

?>

<header class="sticky top-0 z-50 border-b bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500">
                        <span class="text-sm font-bold text-white">R</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Reddit Clone</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="mx-8 max-w-2xl flex-1">
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Buscar no Reddit Clone..."
                        class="w-full rounded-full border border-gray-200 bg-gray-100 px-4 py-2 pl-10 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:outline-none"
                    />
                    <svg
                        class="absolute top-2.5 left-3 h-5 w-5 text-gray-400"
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
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <a
                        href="{{ route('subreddit.create') }}"
                        class="rounded-full bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700"
                    >
                        <svg class="mr-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                            ></path>
                        </svg>
                        Criar Comunidade
                    </a>
                @endauth

                <button class="rounded-full p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        ></path>
                    </svg>
                </button>

                <a
                    href="/admin"
                    class="rounded-full bg-orange-500 px-4 py-2 text-white transition-colors hover:bg-orange-600"
                >
                    Admin
                </a>
            </div>
        </div>
    </div>
</header>

<?php
