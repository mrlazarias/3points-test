<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Criar Post - r/{{ $subreddit->name }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background-color: #111827; color: #f9fafb; min-height: 100vh">
        <!-- Header -->
        <header style="background-color: #1f2937; border-bottom: 1px solid #374151; padding: 1rem 1.5rem">
            <div
                style="
                    max-width: 80rem;
                    margin: 0 auto;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >
                <div style="display: flex; align-items: center; gap: 1rem">
                    <a
                        href="/"
                        style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit"
                    >
                        <div
                            style="
                                width: 2rem;
                                height: 2rem;
                                background-color: #f97316;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <span style="color: white; font-weight: bold; font-size: 0.875rem">3P</span>
                        </div>
                        <span style="font-size: 1.25rem; font-weight: 600">3Pontos</span>
                        <span style="color: #9ca3af; font-size: 0.875rem">Community</span>
                    </a>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem">
                    <a
                        href="{{ route('subreddit.show', $subreddit->slug) }}"
                        style="color: #9ca3af; text-decoration: none; font-size: 0.875rem"
                        onmouseover="this.style.color='#f9fafb'"
                        onmouseout="this.style.color='#9ca3af'"
                    >
                        ← Voltar para r/{{ $subreddit->slug }}
                    </a>

                    @auth
                        <!-- User Menu -->
                        <div style="display: flex; align-items: center; gap: 0.75rem">
                            <a
                                href="{{ route('profile.show') }}"
                                style="
                                    display: flex;
                                    align-items: center;
                                    gap: 0.5rem;
                                    color: #d1d5db;
                                    text-decoration: none;
                                    font-size: 0.875rem;
                                "
                                onmouseover="this.style.color='#f9fafb'"
                                onmouseout="this.style.color='#d1d5db'"
                            >
                                @if (Auth::user()->getFirstMedia('profile-pictures'))
                                    <img
                                        src="{{ Auth::user()->getFirstMedia('profile-pictures')->getUrl() }}"
                                        alt="Foto de perfil"
                                        style="
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 1px solid #374151;
                                        "
                                    />
                                @else
                                    <div
                                        style="
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            background-color: #2563eb;
                                            border-radius: 50%;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 0.75rem;
                                            font-weight: bold;
                                            color: white;
                                        "
                                    >
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0">
                                @csrf
                                <button
                                    type="submit"
                                    style="
                                        padding: 0.5rem 1rem;
                                        background-color: #dc2626;
                                        color: white;
                                        border: none;
                                        border-radius: 0.5rem;
                                        font-size: 0.875rem;
                                        cursor: pointer;
                                        transition: background-color 0.2s;
                                    "
                                    onmouseover="this.style.backgroundColor='#b91c1c'"
                                    onmouseout="this.style.backgroundColor='#dc2626'"
                                >
                                    Sair
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Auth Links -->
                        <div style="display: flex; align-items: center; gap: 0.75rem">
                            <a
                                href="{{ route('login') }}"
                                style="
                                    color: #9ca3af;
                                    text-decoration: none;
                                    font-size: 0.875rem;
                                    transition: color 0.2s;
                                "
                                onmouseover="this.style.color='#f9fafb'"
                                onmouseout="this.style.color='#9ca3af'"
                            >
                                Entrar
                            </a>
                            <a
                                href="{{ route('register') }}"
                                style="
                                    padding: 0.5rem 1rem;
                                    background-color: #2563eb;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    transition: background-color 0.2s;
                                "
                                onmouseover="this.style.backgroundColor='#1d4ed8'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                            >
                                Registrar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <div style="max-width: 80rem; margin: 0 auto; padding: 2rem 1.5rem">
        <div class="min-h-screen bg-gray-900 py-8">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <div class="mb-6 flex items-center space-x-4">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full text-lg font-bold text-white shadow-lg"
                            style="background-color: {{ $subreddit->color }}"
                        >
                            r/
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Criar Post em r/{{ $subreddit->name }}</h1>
                            <p class="text-gray-400 text-lg">{{ $subreddit->description }}</p>
                        </div>
                    </div>
                    
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm text-gray-400">
                        <a href="/" class="hover:text-white transition-colors">Início</a>
                        <span>›</span>
                        <a href="{{ route('subreddit.show', $subreddit->slug) }}" class="hover:text-white transition-colors">r/{{ $subreddit->name }}</a>
                        <span>›</span>
                        <span class="text-white">Criar Post</span>
                    </nav>
                </div>

                <!-- Form -->
                <div class="rounded-xl bg-gray-800 p-8 shadow-2xl border border-gray-700">
                <form action="{{ route('post.store', $subreddit->slug) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Título -->
                    <div>
                        <label for="title" class="mb-2 block text-sm font-medium text-gray-300">
                            Título do Post
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                maxlength="255"
                                class="@error('title') border-red-500 @enderror w-full rounded-lg border border-gray-600 bg-gray-700 px-4 py-3 pr-16 text-white placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                                placeholder="Digite o título do seu post..."
                                required
                            />
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xs text-gray-400">
                                <span id="title-count">0</span>/255
                            </div>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tipo de Post -->
                    <div>
                        <label class="mb-3 block text-sm font-medium text-gray-300">Tipo de Post</label>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="type"
                                    value="text"
                                    class="peer sr-only"
                                    {{ old('type', 'text') === 'text' ? 'checked' : '' }}
                                />
                                <div
                                    class="rounded-lg border-2 border-gray-600 bg-gray-700 p-4 transition-colors peer-checked:border-blue-500 peer-checked:bg-blue-900/20"
                                >
                                    <div class="text-center">
                                        <div class="mb-2 text-2xl">📝</div>
                                        <div class="font-medium text-white">Texto</div>
                                        <div class="text-sm text-gray-400">Post de texto com Markdown</div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="type"
                                    value="link"
                                    class="peer sr-only"
                                    {{ old('type') === 'link' ? 'checked' : '' }}
                                />
                                <div
                                    class="rounded-lg border-2 border-gray-600 bg-gray-700 p-4 transition-colors peer-checked:border-blue-500 peer-checked:bg-blue-900/20"
                                >
                                    <div class="text-center">
                                        <div class="mb-2 text-2xl">🔗</div>
                                        <div class="font-medium text-white">Link</div>
                                        <div class="text-sm text-gray-400">Compartilhar um link</div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="type"
                                    value="image"
                                    class="peer sr-only"
                                    {{ old('type') === 'image' ? 'checked' : '' }}
                                />
                                <div
                                    class="rounded-lg border-2 border-gray-600 bg-gray-700 p-4 transition-colors peer-checked:border-blue-500 peer-checked:bg-blue-900/20"
                                >
                                    <div class="text-center">
                                        <div class="mb-2 text-2xl">🖼️</div>
                                        <div class="font-medium text-white">Imagem</div>
                                        <div class="text-sm text-gray-400">Compartilhar uma imagem</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('type')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                                <!-- Conteúdo (para posts de texto) -->
                                <div id="content-field" class="hidden">
                                    <label for="content" class="mb-2 block text-sm font-medium text-gray-300">
                                        Conteúdo (Markdown)
                                    </label>
                                    
                                    <!-- Tabs para alternar entre edição e preview -->
                                    <div class="mb-3">
                                        <div class="flex border-b border-gray-600">
                                            <button
                                                type="button"
                                                id="edit-tab"
                                                class="px-4 py-2 text-sm font-medium text-white border-b-2 border-blue-500 bg-gray-700"
                                                onclick="switchTab('edit')"
                                            >
                                                ✏️ Editar
                                            </button>
                                            <button
                                                type="button"
                                                id="preview-tab"
                                                class="px-4 py-2 text-sm font-medium text-gray-400 border-b-2 border-transparent hover:text-white"
                                                onclick="switchTab('preview')"
                                            >
                                                👁️ Preview
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Editor de Markdown -->
                                    <div id="markdown-editor" class="space-y-3">
                                        <textarea
                                            id="content"
                                            name="content"
                                            rows="12"
                                            class="@error('content') border-red-500 @enderror w-full rounded-lg border border-gray-600 bg-gray-700 px-4 py-3 text-white placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-blue-500 font-mono text-sm"
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
                                        >{{ old('content') }}</textarea>
                                        
                                        <!-- Preview do Markdown -->
                                        <div
                                            id="markdown-preview"
                                            class="hidden w-full rounded-lg border border-gray-600 bg-gray-800 px-4 py-3 min-h-[12rem] prose prose-invert prose-sm max-w-none"
                                            style="color: #e5e7eb;"
                                        ></div>
                                    </div>

                                    <!-- Guia de Markdown -->
                                    <div class="mt-3 p-3 bg-gray-800 rounded-lg border border-gray-600">
                                        <details class="group">
                                            <summary class="cursor-pointer text-sm font-medium text-gray-300 group-open:text-blue-400">
                                                📖 Guia de Markdown
                                            </summary>
                                            <div class="mt-2 text-xs text-gray-400 space-y-1">
                                                <div><strong>**negrito**</strong> → <strong>negrito</strong></div>
                                                <div><em>*itálico*</em> → <em>itálico</em></div>
                                                <div><code>`código`</code> → <code>código</code></div>
                                                <div><code># Título</code> → <h1 style="display: inline; font-size: 1.2em; font-weight: bold;">Título</h1></div>
                                                <div><code>- Item</code> → Lista com marcadores</div>
                                                <div><code>[Link](url)</code> → <a href="#" style="color: #60a5fa;">Link</a></div>
                                            </div>
                                        </details>
                                    </div>

                                    @error('content')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                    <!-- URL (para posts de link/imagem) -->
                    <div id="url-field" class="hidden">
                        <label for="url" class="mb-2 block text-sm font-medium text-gray-300">URL</label>
                        <input
                            type="url"
                            id="url"
                            name="url"
                            value="{{ old('url') }}"
                            class="@error('url') @enderror w-full rounded-lg border border-gray-600 border-red-500 bg-gray-700 px-4 py-3 text-white placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                            placeholder="https://exemplo.com"
                        />
                        @error('url')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-700">
                        <div class="flex items-center space-x-2 text-sm text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Dica: Use Markdown para formatar seu texto</span>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a
                                href="{{ route('subreddit.show', $subreddit->slug) }}"
                                class="inline-flex items-center px-6 py-3 rounded-lg bg-gray-600 text-white font-medium transition-all duration-200 hover:bg-gray-700 hover:shadow-lg"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </a>
                            <button
                                type="submit"
                                class="inline-flex items-center px-8 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transform hover:scale-105"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Criar Post
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                                editTab.className = 'px-4 py-2 text-sm font-medium text-white border-b-2 border-blue-500 bg-gray-700';
                                previewTab.className = 'px-4 py-2 text-sm font-medium text-gray-400 border-b-2 border-transparent hover:text-white';
                                contentInput.classList.remove('hidden');
                                previewDiv.classList.add('hidden');
                            } else {
                                editTab.className = 'px-4 py-2 text-sm font-medium text-gray-400 border-b-2 border-transparent hover:text-white';
                                previewTab.className = 'px-4 py-2 text-sm font-medium text-white border-b-2 border-blue-500 bg-gray-700';
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
                                preview.innerHTML = '<p class="text-gray-500 italic">Digite algo para ver o preview...</p>';
                                return;
                            }

                            // Simulação básica de Markdown (você pode usar uma biblioteca como marked.js)
                            let html = content
                                .replace(/^# (.*$)/gim, '<h1 class="text-2xl font-bold mb-4 text-white">$1</h1>')
                                .replace(/^## (.*$)/gim, '<h2 class="text-xl font-bold mb-3 text-white">$1</h2>')
                                .replace(/^### (.*$)/gim, '<h3 class="text-lg font-bold mb-2 text-white">$1</h3>')
                                .replace(/\*\*(.*?)\*\*/gim, '<strong class="font-bold text-white">$1</strong>')
                                .replace(/\*(.*?)\*/gim, '<em class="italic text-gray-300">$1</em>')
                                .replace(/`(.*?)`/gim, '<code class="bg-gray-700 px-2 py-1 rounded text-blue-400 font-mono text-sm">$1</code>')
                                .replace(/^\- (.*$)/gim, '<li class="ml-4 text-gray-300">• $1</li>')
                                .replace(/^\d+\. (.*$)/gim, '<li class="ml-4 text-gray-300">$1</li>')
                                .replace(/\[([^\]]+)\]\(([^)]+)\)/gim, '<a href="$2" class="text-blue-400 hover:text-blue-300 underline" target="_blank">$1</a>')
                                .replace(/!\[([^\]]*)\]\(([^)]+)\)/gim, '<img src="$2" alt="$1" class="max-w-full h-auto rounded-lg my-2" />')
                                .replace(/\n\n/gim, '</p><p class="mb-3 text-gray-300">')
                                .replace(/\n/gim, '<br>');

                            // Envolver em parágrafo se não começar com tag
                            if (!html.startsWith('<')) {
                                html = '<p class="mb-3 text-gray-300">' + html + '</p>';
                            }

                            preview.innerHTML = html;
                        }

                        // Event listeners
                        typeInputs.forEach((input) => {
                            input.addEventListener('change', toggleFields);
                        });

                        // Atualizar preview em tempo real
                        contentInput.addEventListener('input', function() {
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
                                titleCount.className = 'text-gray-400';
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
        </div>
    </div>
</body>
</html>

<?php
