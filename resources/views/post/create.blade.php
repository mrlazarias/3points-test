<?php

declare(strict_types=1);

?>
@extends('layouts.app')

@section('title', 'Criar Post - ' . $subreddit->name)

@section('content')
    <div class="min-h-screen bg-gray-900 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="mb-4 flex items-center space-x-3">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold text-white"
                        style="background-color: {{ $subreddit->color }}"
                    >
                        r/
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Criar Post em r/{{ $subreddit->name }}</h1>
                        <p class="text-gray-400">{{ $subreddit->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="rounded-lg bg-gray-800 p-6">
                <form action="{{ route('post.store', $subreddit->slug) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Título -->
                    <div>
                        <label for="title" class="mb-2 block text-sm font-medium text-gray-300">Título do Post</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            class="@error('title') @enderror w-full rounded-lg border border-gray-600 border-red-500 bg-gray-700 px-4 py-3 text-white placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                            placeholder="Digite o título do seu post..."
                            required
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
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
                        <textarea
                            id="content"
                            name="content"
                            rows="8"
                            class="@error('content') @enderror w-full rounded-lg border border-gray-600 border-red-500 bg-gray-700 px-4 py-3 text-white placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                            placeholder="Digite o conteúdo do seu post em Markdown..."
                        >
{{ old('content') }}</textarea
                        >
                        <p class="mt-1 text-sm text-gray-400">Você pode usar Markdown para formatar seu texto</p>
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
                    <div class="flex justify-end space-x-4">
                        <a
                            href="{{ route('subreddit.show', $subreddit->slug) }}"
                            class="rounded-lg bg-gray-600 px-6 py-3 text-white transition-colors hover:bg-gray-700"
                        >
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700"
                        >
                            Criar Post
                        </button>
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

            typeInputs.forEach((input) => {
                input.addEventListener('change', toggleFields);
            });

            // Inicializar campos baseado no valor antigo
            toggleFields();
        });
    </script>
@endsection
<?php 
