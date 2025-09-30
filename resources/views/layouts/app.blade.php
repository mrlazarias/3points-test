<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', '3Pontos Community')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="bg-dark-bg min-h-screen font-sans text-white">
        <!-- Sidebar -->
        <x-layout.sidebar :subreddits="$subreddits ?? []" />

        <!-- Main Content -->
        <main class="ml-60 min-h-screen">
            <!-- Header -->
            <x-layout.header />

            <!-- Page Content -->
            @yield('content')
        </main>

        @stack('scripts')
    </body>
</html>
<?php 
