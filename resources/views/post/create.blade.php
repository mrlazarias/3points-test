<?php

declare(strict_types=1);

?>
declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Criar Post - r/{{ $subreddit->name }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 antialiased">
        <!-- Header -->
        <header class="border-b border-slate-700/50 bg-slate-900/80 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="/" class="group flex items-center space-x-3">
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-r from-orange-500 to-red-500 shadow-lg transition-all duration-300 group-hover:shadow-orange-500/25"
                            >
                                <span class="text-sm font-bold text-white">3P</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-semibold text-white">3Pontos</span>
                                <span class="text-xs text-slate-400">Community</span>
                            </div>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button
                            class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-800 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                        </button>

                        @auth
                            <div class="flex items-center space-x-3">
                                <a
                                    href="{{ route('profile.show') }}"
                                    class="text-sm text-slate-300 transition-colors hover:text-white"
                                >
                                    Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
                                    >
                                        Sair
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-3">
                                <a
                                    href="{{ route('login') }}"
                                    class="rounded-lg bg-slate-700 px-4 py-2 text-sm font-medium text-slate-300 transition-colors hover:bg-slate-600 hover:text-white"
                                >
                                    Entrar
                                </a>
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                >
                                    Registrar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="min-h-screen py-8">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="mb-6 flex items-center space-x-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl shadow-lg"
                            style="background-color: {{ $subreddit->color }}"
                        >
                            <span class="text-lg font-bold text-white">r/</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Criar Post</h1>
                            <p class="text-lg text-slate-400">em r/{{ $subreddit->name }}</p>
                        </div>
                    </div>

                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm text-slate-400">
                        <a href="/" class="transition-colors hover:text-white">Início</a>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                        <a
                            href="{{ route('subreddit.show', $subreddit->slug) }}"
                            class="transition-colors hover:text-white"
                        >
                            r/{{ $subreddit->name }}
                        </a>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                        <span class="text-white">Criar Post</span>
                    </nav>
                </div>

                <!-- Form Card -->
                <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-8 shadow-2xl backdrop-blur-sm">
                    <form action="{{ route('post.store', $subreddit->slug) }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Title Section -->
                        <div class="space-y-3">
                            <label for="title" class="block text-sm font-medium text-slate-200">
                                Título do Post
                                <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    value="{{ old('title') }}"
                                    maxlength="255"
                                    class="@error('title') @enderror w-full rounded-xl border border-red-500 border-slate-600 bg-slate-700/50 px-4 py-4 text-white placeholder-slate-400 backdrop-blur-sm transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20"
                                    placeholder="Digite o título do seu post..."
                                    required
                                />
                                <div class="absolute top-1/2 right-4 -translate-y-1/2 text-xs text-slate-400">
                                    <span id="title-count">0</span>
                                    /255
                                </div>
                            </div>
                            @error('title')
                                <p class="flex items-center text-sm text-red-400">
                                    <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Post Type Selection -->
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-slate-200">Tipo de Post</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <label class="group relative cursor-pointer">
                                    <input
                                        type="radio"
                                        name="type"
                                        value="text"
                                        class="peer sr-only"
                                        {{ old('type', 'text') === 'text' ? 'checked' : '' }}
                                    />
                                    <div
                                        class="rounded-xl border-2 border-slate-600 bg-slate-700/30 p-6 transition-all duration-200 group-hover:border-slate-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:shadow-lg peer-checked:shadow-blue-500/20"
                                    >
                                        <div class="text-center">
                                            <div class="mb-3 text-3xl">📝</div>
                                            <div class="text-lg font-semibold text-white">Texto</div>
                                            <div class="text-sm text-slate-400">Post de texto com Markdown</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="group relative cursor-pointer">
                                    <input
                                        type="radio"
                                        name="type"
                                        value="link"
                                        class="peer sr-only"
                                        {{ old('type') === 'link' ? 'checked' : '' }}
                                    />
                                    <div
                                        class="rounded-xl border-2 border-slate-600 bg-slate-700/30 p-6 transition-all duration-200 group-hover:border-slate-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:shadow-lg peer-checked:shadow-blue-500/20"
                                    >
                                        <div class="text-center">
                                            <div class="mb-3 text-3xl">🔗</div>
                                            <div class="text-lg font-semibold text-white">Link</div>
                                            <div class="text-sm text-slate-400">Compartilhar um link</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="group relative cursor-pointer">
                                    <input
                                        type="radio"
                                        name="type"
                                        value="image"
                                        class="peer sr-only"
                                        {{ old('type') === 'image' ? 'checked' : '' }}
                                    />
                                    <div
                                        class="rounded-xl border-2 border-slate-600 bg-slate-700/30 p-6 transition-all duration-200 group-hover:border-slate-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 peer-checked:shadow-lg peer-checked:shadow-blue-500/20"
                                    >
                                        <div class="text-center">
                                            <div class="mb-3 text-3xl">🖼️</div>
                                            <div class="text-lg font-semibold text-white">Imagem</div>
                                            <div class="text-sm text-slate-400">Compartilhar uma imagem</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content Field (for text posts) -->
                        <div id="content-field" class="hidden space-y-4">
                            <label for="content" class="block text-sm font-medium text-slate-200">
                                Conteúdo (Markdown)
                            </label>

                            <!-- Tabs -->
                            <div class="flex border-b border-slate-600">
                                <button
                                    type="button"
                                    id="edit-tab"
                                    class="border-b-2 border-blue-500 bg-slate-700/50 px-6 py-3 text-sm font-medium text-white"
                                    onclick="switchTab('edit')"
                                >
                                    ✏️ Editar
                                </button>
                                <button
                                    type="button"
                                    id="preview-tab"
                                    class="border-b-2 border-transparent px-6 py-3 text-sm font-medium text-slate-400 hover:text-white"
                                    onclick="switchTab('preview')"
                                >
                                    👁️ Preview
                                </button>
                            </div>

                            <!-- Editor -->
                            <div id="markdown-editor" class="space-y-4">
                                <textarea
                                    id="content"
                                    name="content"
                                    rows="12"
                                    class="@error('content') @enderror w-full rounded-xl border border-red-500 border-slate-600 bg-slate-700/50 px-4 py-4 font-mono text-sm text-white placeholder-slate-400 backdrop-blur-sm transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20"
                                    placeholder="Digite o conteúdo do seu post em Markdown...

Exemplos de formatação:
# Título Principal
## Subtítulo
**Texto em negrito**
*Texto em itálico*
- Lista com marcadores
1. Lista numerada

[Link](https://exemplo.com)
![Imagem](https://exemplo.com/imagem.jpg)

```javascript
// Código com syntax highlighting
function exemplo() {
    return 'Olá mundo!';
}
```"
                                >
{{ old('content') }}</textarea
                                >

                                <!-- Preview -->
                                <div
                                    id="markdown-preview"
                                    class="hidden min-h-[12rem] w-full rounded-xl border border-slate-600 bg-slate-700/50 p-4 backdrop-blur-sm"
                                ></div>
                            </div>

                            <!-- Markdown Guide -->
                            <div class="rounded-xl border border-slate-600 bg-slate-700/30 p-4">
                                <details class="group">
                                    <summary
                                        class="cursor-pointer text-sm font-medium text-slate-300 group-open:text-blue-400"
                                    >
                                        📖 Guia de Markdown
                                    </summary>
                                    <div class="mt-3 space-y-2 text-xs text-slate-400">
                                        <div class="flex items-center space-x-2">
                                            <code class="rounded bg-slate-600 px-2 py-1">**negrito**</code>
                                            <span>→</span>
                                            <strong class="text-white">negrito</strong>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <code class="rounded bg-slate-600 px-2 py-1">*itálico*</code>
                                            <span>→</span>
                                            <em class="text-slate-300">itálico</em>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <code class="rounded bg-slate-600 px-2 py-1">`código`</code>
                                            <span>→</span>
                                            <code class="rounded bg-slate-600 px-1 py-0.5 text-blue-400">código</code>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <code class="rounded bg-slate-600 px-2 py-1"># Título</code>
                                            <span>→</span>
                                            <span class="text-lg font-bold text-white">Título</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <code class="rounded bg-slate-600 px-2 py-1">- Item</code>
                                            <span>→</span>
                                            <span class="text-slate-300">• Item</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <code class="rounded bg-slate-600 px-2 py-1">[Link](url)</code>
                                            <span>→</span>
                                            <a href="#" class="text-blue-400 hover:underline">Link</a>
                                        </div>
                                    </div>
                                </details>
                            </div>

                            @error('content')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- URL Field (for link/image posts) -->
                        <div id="url-field" class="hidden space-y-3">
                            <label for="url" class="block text-sm font-medium text-slate-200">URL</label>
                            <input
                                type="url"
                                id="url"
                                name="url"
                                value="{{ old('url') }}"
                                class="@error('url') @enderror w-full rounded-xl border border-red-500 border-slate-600 bg-slate-700/50 px-4 py-4 text-white placeholder-slate-400 backdrop-blur-sm transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20"
                                placeholder="https://exemplo.com"
                            />
                            @error('url')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="flex flex-col items-center justify-between space-y-4 border-t border-slate-700 pt-8 sm:flex-row sm:space-y-0"
                        >
                            <div class="flex items-center space-x-2 text-sm text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                                <span>Dica: Use Markdown para formatar seu texto</span>
                            </div>

                            <div class="flex space-x-4">
                                <a
                                    href="{{ route('subreddit.show', $subreddit->slug) }}"
                                    class="inline-flex items-center rounded-xl bg-slate-700 px-6 py-3 font-medium text-slate-300 transition-all duration-200 hover:bg-slate-600 hover:text-white hover:shadow-lg"
                                >
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        ></path>
                                    </svg>
                                    Cancelar
                                </a>
                                <button
                                    type="submit"
                                    class="inline-flex transform items-center rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3 font-medium text-white shadow-lg transition-all duration-200 hover:scale-105 hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:shadow-blue-500/25"
                                >
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                        ></path>
                                    </svg>
                                    Criar Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const typeInputs = document.querySelectorAll('input[name="type"]');
                const contentField = document.getElementById('content-field');
                const urlField = document.getElementById('url-field');
                const contentInput = document.getElementById('content');
                const urlInput = document.getElementById('url');

                function toggleFields() {
                    const selectedType = document.querySelector('input[name="type"]:checked')?.value;

                    if (selectedType === 'text') {
                        contentField.classList.remove('hidden');
                        urlField.classList.add('hidden');
                        contentInput.required = true;
                        urlInput.required = false;
                    } else if (selectedType === 'link' || selectedType === 'image') {
                        contentField.classList.add('hidden');
                        urlField.classList.remove('hidden');
                        contentInput.required = false;
                        urlInput.required = true;
                    }
                }

                // Função para alternar entre edição e preview
                function switchTab(tab) {
                    const editTab = document.getElementById('edit-tab');
                    const previewTab = document.getElementById('preview-tab');
                    const contentInput = document.getElementById('content');
                    const previewDiv = document.getElementById('markdown-preview');

                    if (tab === 'edit') {
                        editTab.className =
                            'border-b-2 border-blue-500 bg-slate-700/50 px-6 py-3 text-sm font-medium text-white';
                        previewTab.className =
                            'border-b-2 border-transparent px-6 py-3 text-sm font-medium text-slate-400 hover:text-white';
                        contentInput.classList.remove('hidden');
                        previewDiv.classList.add('hidden');
                    } else {
                        editTab.className =
                            'border-b-2 border-transparent px-6 py-3 text-sm font-medium text-slate-400 hover:text-white';
                        previewTab.className =
                            'border-b-2 border-blue-500 bg-slate-700/50 px-6 py-3 text-sm font-medium text-white';
                        contentInput.classList.add('hidden');
                        previewDiv.classList.remove('hidden');
                        updatePreview();
                    }
                }

                // Função para atualizar o preview do Markdown
                function updatePreview() {
                    const content = document.getElementById('content').value;
                    const preview = document.getElementById('markdown-preview');

                    if (!content.trim()) {
                        preview.innerHTML = '<p class="text-slate-500 italic">Digite algo para ver o preview...</p>';
                        return;
                    }

                    // Simulação básica de Markdown
                    let html = content
                        .replace(/^# (.*$)/gim, '<h1 class="text-2xl font-bold mb-4 text-white">$1</h1>')
                        .replace(/^## (.*$)/gim, '<h2 class="text-xl font-bold mb-3 text-white">$1</h2>')
                        .replace(/^### (.*$)/gim, '<h3 class="text-lg font-bold mb-2 text-white">$1</h3>')
                        .replace(/\*\*(.*?)\*\*/gim, '<strong class="font-bold text-white">$1</strong>')
                        .replace(/\*(.*?)\*/gim, '<em class="italic text-slate-300">$1</em>')
                        .replace(
                            /`(.*?)`/gim,
                            '<code class="rounded bg-slate-600 px-2 py-1 text-blue-400 font-mono text-sm">$1</code>',
                        )
                        .replace(/^\- (.*$)/gim, '<li class="ml-4 text-slate-300">• $1</li>')
                        .replace(/^\d+\. (.*$)/gim, '<li class="ml-4 text-slate-300">$1</li>')
                        .replace(
                            /\[([^\]]+)\]\(([^)]+)\)/gim,
                            '<a href="$2" class="text-blue-400 hover:text-blue-300 underline" target="_blank">$1</a>',
                        )
                        .replace(
                            /!\[([^\]]*)\]\(([^)]+)\)/gim,
                            '<img src="$2" alt="$1" class="max-w-full h-auto rounded-lg my-2" />',
                        )
                        .replace(/\n\n/gim, '</p><p class="mb-3 text-slate-300">')
                        .replace(/\n/gim, '<br>');

                    // Envolver em parágrafo se não começar com tag
                    if (!html.startsWith('<')) {
                        html = '<p class="mb-3 text-slate-300">' + html + '</p>';
                    }

                    preview.innerHTML = html;
                }

                // Event listeners
                typeInputs.forEach((input) => {
                    input.addEventListener('change', toggleFields);
                });

                // Atualizar preview em tempo real
                contentInput.addEventListener('input', function () {
                    if (!document.getElementById('markdown-preview').classList.contains('hidden')) {
                        updatePreview();
                    }
                });

                // Contador de caracteres para o título
                const titleInput = document.getElementById('title');
                const titleCount = document.getElementById('title-count');

                function updateTitleCount() {
                    const count = titleInput.value.length;
                    titleCount.textContent = count;

                    if (count > 200) {
                        titleCount.className = 'text-yellow-400';
                    } else if (count > 240) {
                        titleCount.className = 'text-red-400';
                    } else {
                        titleCount.className = 'text-slate-400';
                    }
                }

                titleInput.addEventListener('input', updateTitleCount);
                updateTitleCount(); // Inicializar contador

                // Tornar funções globais
                window.switchTab = switchTab;

                // Inicializar campos baseado no valor antigo
                toggleFields();
            });
        </script>
    </body>
</html>
<?php 
