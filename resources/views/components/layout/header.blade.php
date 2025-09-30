<?php

declare(strict_types=1);

?>

<header
    class="dark:border-dark-border dark:bg-dark-surface fixed top-0 right-0 left-60 z-50 flex h-16 items-center justify-between border-b border-gray-200 bg-white px-8 transition-colors"
>
    <div></div>
    <div class="flex items-center gap-4">
        @auth
            {{-- Notifications --}}
            <div class="relative">
                <button
                    id="notifications-toggle"
                    class="dark:bg-dark-border dark:hover:bg-dark-hover relative flex h-10 w-10 items-center justify-center rounded-lg bg-gray-200 text-gray-600 transition-all hover:bg-gray-300 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white"
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
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span
                        id="notification-badge"
                        class="absolute -top-1 -right-1 hidden h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white"
                    >
                        0
                    </span>
                </button>

                {{-- Notifications Dropdown --}}
                <div
                    id="notifications-dropdown"
                    class="absolute top-12 right-0 hidden w-80 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="border-b border-gray-200 p-4 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Notificações</h3>
                            <button
                                id="clear-notifications"
                                class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            >
                                Limpar todas
                            </button>
                        </div>
                    </div>
                    <div id="notifications-list" class="max-h-96 overflow-y-auto">
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">Nenhuma notificação</div>
                    </div>
                </div>
            </div>
        @endauth

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

    // Sistema de Notificações
    @auth
    document.addEventListener('DOMContentLoaded', function() {
        const notificationToggle = document.getElementById('notifications-toggle');
        const notificationDropdown = document.getElementById('notifications-dropdown');
        const notificationBadge = document.getElementById('notification-badge');
        const notificationList = document.getElementById('notifications-list');

        let notificationCount = 0;

        // Toggle dropdown
        notificationToggle.addEventListener('click', function() {
            const isHidden = notificationDropdown.classList.contains('hidden');
            notificationDropdown.classList.toggle('hidden');

            // Se está abrindo o dropdown, esconder o badge (usuário "viu" as notificações)
            if (isHidden) {
                notificationCount = 0;
                updateNotificationBadge();
            }
        });

        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(event) {
            if (!notificationToggle.contains(event.target) && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });

        // Limpar todas as notificações
        document.getElementById('clear-notifications').addEventListener('click', function(e) {
            e.stopPropagation();

            // Remover todas as notificações
            notificationList.innerHTML = '<div class="p-4 text-center text-gray-500 dark:text-gray-400">Nenhuma notificação</div>';

            // Resetar contador
            notificationCount = 0;
            updateNotificationBadge();
        });

        // Função para adicionar notificação
        function addNotification(notification) {
            const notificationElement = document.createElement('div');
            notificationElement.className = 'border-b border-gray-200 p-4 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700 cursor-pointer';
            // Gerar avatar padrão se não houver foto
            const avatarUrl = notification.from_user.profile_photo_url ||
                `data:image/svg+xml,${encodeURIComponent(`
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                `)}`;

            notificationElement.innerHTML = `
                <div class="flex items-start space-x-3">
                    <img src="${avatarUrl}"
                         alt="${notification.from_user.name}"
                         class="h-8 w-8 rounded-full object-cover">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${notification.title}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${notification.message}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500">${formatTime(notification.created_at)}</p>
                    </div>
                </div>
            `;

            // Adicionar clique para navegar para o perfil ou post
            notificationElement.addEventListener('click', function() {
                // Marcar notificação como lida (remover visualmente)
                notificationElement.style.opacity = '0.5';
                notificationElement.style.pointerEvents = 'none';

                // Reduzir contador de notificações
                notificationCount = Math.max(0, notificationCount - 1);
                updateNotificationBadge();

                // Navegar para URL específica da notificação
                if (notification.url) {
                    window.location.href = notification.url;
                } else if (notification.type === 'follow' && notification.from_user.username) {
                    // Fallback para notificações de follow sem URL
                    window.location.href = `/u/${notification.from_user.username}`;
                } else if (notification.type === 'new_post' && notification.post) {
                    // Fallback para notificações de novo post
                    window.location.href = `/r/${notification.post.subreddit_slug}/${notification.post.slug}`;
                } else if (notification.type === 'comment' && notification.post) {
                    // Fallback para notificações de comentário
                    window.location.href = `/r/${notification.post.subreddit.slug}/${notification.post.slug}`;
                } else if (notification.type === 'post_liked' && notification.post) {
                    // Fallback para notificações de like
                    window.location.href = `/r/${notification.post.subreddit}/${notification.post.slug}`;
                }
            });

            // Remover mensagem "Nenhuma notificação" se existir
            const emptyMessage = notificationList.querySelector('.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            // Adicionar nova notificação no topo
            notificationList.insertBefore(notificationElement, notificationList.firstChild);

            // Atualizar contador
            notificationCount++;
            updateNotificationBadge();
        }

        // Função para atualizar badge
        function updateNotificationBadge() {
            if (notificationCount > 0) {
                notificationBadge.textContent = notificationCount;
                notificationBadge.classList.remove('hidden');
                notificationBadge.classList.add('flex');
            } else {
                notificationBadge.classList.add('hidden');
                notificationBadge.classList.remove('flex');
            }
        }

        // Função para formatar tempo
        function formatTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;

            if (diff < 60000) return 'agora';
            if (diff < 3600000) return `${Math.floor(diff / 60000)}m atrás`;
            if (diff < 86400000) return `${Math.floor(diff / 3600000)}h atrás`;
            return `${Math.floor(diff / 86400000)}d atrás`;
        }

        // Configurar Echo para notificações
        if (typeof window.Echo !== 'undefined') {

            window.Echo.channel('user.{{ Auth::id() }}')
                .listen('.notification.received', (data) => {
                    if (data.notification) {
                        addNotification(data.notification);
                    }
                });
        }
    });
    @endauth
</script>
