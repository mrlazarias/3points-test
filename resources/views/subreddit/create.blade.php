<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Criar Comunidade - 3Pontos Community</title>
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
                        <a
                            href="/"
                            class="rounded-lg px-4 py-2 text-slate-300 transition-colors hover:bg-slate-800 hover:text-white"
                        >
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold text-white">Criar Nova Comunidade</h1>
                <p class="mt-3 text-lg text-slate-400">
                    Crie uma comunidade para compartilhar ideias e conectar pessoas
                </p>
            </div>

            <!-- Form Card -->
            <div
                class="overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-xl backdrop-blur-sm"
            >
                <div class="border-b border-slate-700/50 bg-slate-800/30 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Informações da Comunidade</h2>
                    <p class="mt-1 text-sm text-slate-400">Preencha os dados para criar sua comunidade</p>
                </div>

                <form action="{{ route('subreddit.store') }}" method="POST" class="space-y-6 p-6">
                    @csrf

                    <!-- Nome da Comunidade -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-slate-300">Nome da Comunidade *</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ex: Laravel Brasil, Tecnologia, Programação..."
                            class="w-full rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-3 text-white placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            required
                            maxlength="50"
                        />
                        @error('name')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-slate-500">Máximo 50 caracteres</p>
                    </div>

                    <!-- Descrição -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-slate-300">Descrição *</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Descreva o propósito e tema da sua comunidade..."
                            class="w-full resize-none rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-3 text-white placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            required
                            maxlength="500"
                        >
{{ old('description') }}</textarea
                        >
                        @error('description')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-slate-500">Máximo 500 caracteres</p>
                    </div>

                    <!-- Cor da Comunidade -->
                    <div class="space-y-2">
                        <label for="color" class="block text-sm font-medium text-slate-300">Cor da Comunidade *</label>
                        <div class="flex items-center space-x-4">
                            <input
                                type="color"
                                id="color"
                                name="color"
                                value="{{ old('color', '#0ea5e9') }}"
                                class="h-12 w-20 cursor-pointer rounded-lg border border-slate-600 bg-slate-700/50 transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                                required
                            />
                            <div class="flex-1">
                                <input
                                    type="text"
                                    id="color-text"
                                    value="{{ old('color', '#0ea5e9') }}"
                                    placeholder="#0ea5e9"
                                    class="w-full rounded-lg border border-slate-600 bg-slate-700/50 px-4 py-3 text-white placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:bg-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                                    pattern="^#[0-9A-Fa-f]{6}$"
                                />
                            </div>
                        </div>
                        @error('color')
                            <p class="text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-slate-500">Escolha uma cor que represente sua comunidade</p>
                    </div>

                    <!-- Preview da Comunidade -->
                    <div class="rounded-lg border border-slate-600/50 bg-slate-700/30 p-4">
                        <h3 class="mb-3 text-sm font-medium text-slate-300">Preview da Comunidade</h3>
                        <div class="flex items-center space-x-3">
                            <div
                                id="preview-color"
                                class="h-10 w-10 rounded-full shadow-lg"
                                style="background-color: #0ea5e9"
                            ></div>
                            <div class="flex-1">
                                <div id="preview-name" class="font-semibold text-white">Nome da Comunidade</div>
                                <div id="preview-description" class="text-sm text-slate-400">
                                    Descrição da comunidade aparecerá aqui...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex items-center justify-end space-x-4 border-t border-slate-700/50 pt-6">
                        <a
                            href="{{ url()->previous() }}"
                            class="rounded-lg border border-slate-600 bg-slate-700/50 px-6 py-3 text-slate-300 transition-all duration-200 hover:border-slate-500 hover:bg-slate-600 hover:text-white"
                        >
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-3 font-semibold text-white transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-lg hover:shadow-blue-500/25 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                        >
                            Criar Comunidade
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informações Adicionais -->
            <div
                class="mt-8 overflow-hidden rounded-2xl border border-slate-700/50 bg-slate-800/30 shadow-xl backdrop-blur-sm"
            >
                <div class="border-b border-slate-700/50 bg-slate-800/50 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Dicas para uma boa comunidade</h3>
                    <p class="mt-1 text-sm text-slate-400">Siga essas dicas para criar uma comunidade engajada</p>
                </div>
                <div class="p-6">
                    <ul class="space-y-4 text-sm text-slate-300">
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/20">
                                <span class="text-xs font-semibold text-blue-400">1</span>
                            </div>
                            <span>Escolha um nome claro e descritivo que reflita o tema da comunidade</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/20">
                                <span class="text-xs font-semibold text-blue-400">2</span>
                            </div>
                            <span>
                                Escreva uma descrição detalhada para ajudar outros usuários a entender o propósito
                            </span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/20">
                                <span class="text-xs font-semibold text-blue-400">3</span>
                            </div>
                            <span>Seja ativo e engajado para manter a comunidade viva</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="mt-1 flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/20">
                                <span class="text-xs font-semibold text-blue-400">4</span>
                            </div>
                            <span>Estabeleça regras claras para manter um ambiente respeitoso</span>
                        </li>
                    </ul>
                </div>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const nameInput = document.getElementById('name');
                const descriptionInput = document.getElementById('description');
                const colorInput = document.getElementById('color');
                const colorTextInput = document.getElementById('color-text');
                const previewColor = document.getElementById('preview-color');
                const previewName = document.getElementById('preview-name');
                const previewDescription = document.getElementById('preview-description');

                // Sincronizar inputs de cor
                colorInput.addEventListener('input', function () {
                    colorTextInput.value = this.value;
                    previewColor.style.backgroundColor = this.value;
                });

                colorTextInput.addEventListener('input', function () {
                    if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                        colorInput.value = this.value;
                        previewColor.style.backgroundColor = this.value;
                    }
                });

                // Atualizar preview em tempo real
                nameInput.addEventListener('input', function () {
                    previewName.textContent = this.value || 'Nome da Comunidade';
                });

                descriptionInput.addEventListener('input', function () {
                    previewDescription.textContent = this.value || 'Descrição da comunidade aparecerá aqui...';
                });

                // Validação em tempo real
                colorTextInput.addEventListener('blur', function () {
                    if (!this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                        this.classList.add('border-red-500');
                    } else {
                        this.classList.remove('border-red-500');
                    }
                });
            });
        </script>
    </body>
</html>
