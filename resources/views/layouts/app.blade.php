<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', '3Pontos Community')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="dark:bg-dark-bg min-h-screen bg-white font-sans text-gray-900 transition-colors dark:text-white">
        <!-- Sidebar -->
        <x-layout.sidebar :subreddits="$subreddits ?? []" />

        <!-- Main Content -->
        <main class="ml-60 min-h-screen transition-all duration-300">
            <!-- Header -->
            <x-layout.header />

            <!-- Page Content -->
            @yield('content')
        </main>

        @stack('scripts')
    </body>
</html>
<?php 
