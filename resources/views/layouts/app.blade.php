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
        <!-- Header -->
        <x-layout.header />

        <!-- Main Content -->
        <main class="ml-60 min-h-screen pt-16 transition-all duration-300">
            <!-- Page Content -->
            @yield('content')
        </main>
        @stack('scripts')

        <!-- Voting Script -->
        @auth
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Configurar CSRF token para requisições AJAX
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Adicionar evento aos botões de votação
                    document.addEventListener('click', function (e) {
                        if (e.target.closest('.vote-btn')) {
                            e.preventDefault();

                            const button = e.target.closest('.vote-btn');
                            const voteableType = button.dataset.voteableType;
                            const voteableId = button.dataset.voteableId;
                            const voteType = button.dataset.voteType;

                            // Desabilitar botão temporariamente
                            button.disabled = true;

                            // Fazer requisição AJAX
                            fetch('/vote', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    Accept: 'application/json',
                                },
                                body: JSON.stringify({
                                    voteable_type: voteableType,
                                    voteable_id: voteableId,
                                    vote_type: voteType,
                                }),
                            })
                                .then((response) => response.json())
                                .then((data) => {
                                    if (data.success) {
                                        // Atualizar contadores
                                        const container = button.closest('.flex.items-center.space-x-2');
                                        const upButton = container.querySelector('[data-vote-type="up"]');
                                        const downButton = container.querySelector('[data-vote-type="down"]');
                                        const upCount = upButton.querySelector('.vote-count');
                                        const downCount = downButton.querySelector('.vote-count');

                                        upCount.textContent = data.likes_count;
                                        downCount.textContent = data.dislikes_count;

                                        // Atualizar estados visuais
                                        if (data.action === 'added' || data.action === 'updated') {
                                            if (voteType === 'up') {
                                                upButton.classList.add('text-green-600');
                                                downButton.classList.remove('text-red-600');
                                            } else {
                                                downButton.classList.add('text-red-600');
                                                upButton.classList.remove('text-green-600');
                                            }
                                        } else if (data.action === 'removed') {
                                            upButton.classList.remove('text-green-600');
                                            downButton.classList.remove('text-red-600');
                                        }
                                    }
                                })
                                .catch((error) => {
                                    console.error('Erro ao votar:', error);
                                })
                                .finally(() => {
                                    button.disabled = false;
                                });
                        }
                    });
                });
            </script>
        @endauth
    </body>
</html>
