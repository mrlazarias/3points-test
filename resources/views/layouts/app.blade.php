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

            .main-content {
                margin-left: 240px;
                min-height: 100vh;
            }

            .content-wrapper {
                max-width: 1200px;
                margin: 0 auto;
                padding: 32px;
            }

            @yield('styles')
        </style>
    </head>
    <body>
        <!-- Sidebar -->
        <x-sidebar :subreddits="$subreddits ?? []" />

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <x-header />

            <!-- Page Content -->
            @yield('content')
        </main>

        @yield('scripts')
    </body>
</html>

<?php
