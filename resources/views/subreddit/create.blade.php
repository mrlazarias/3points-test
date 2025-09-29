<?php

declare(strict_types=1);

?>

@extends('layouts.app')

@section('title', 'Criar Comunidade')

@section('content')
    <div class="min-h-screen bg-slate-900 py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-white">Criar Nova Comunidade</h1>
                <p class="mt-2 text-slate-400">Crie uma comunidade para compartilhar ideias e conectar pessoas</p>
            </div>

            <!-- Form -->
            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-8 shadow-xl backdrop-blur-sm">
                <form action="{{ route('subreddit.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nome da Comunidade -->
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-300">
                            Nome da Comunidade *
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ex: Laravel Brasil, Tecnologia, Programação..."
                            class="w-full rounded-lg border border-slate-600 bg-slate-700 px-4 py-3 text-white placeholder-slate-400 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            required
                            maxlength="50"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <p class="mt-1 text-xs text-slate-500">Máximo 50 caracteres</p>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-slate-300">
                            Descrição *
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Descreva o propósito e tema da sua comunidade..."
                            class="w-full resize-none rounded-lg border border-slate-600 bg-slate-700 px-4 py-3 text-white placeholder-slate-400 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                            required
                            maxlength="500"
                        >
{{ old('description') }}</textarea
                        >
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <p class="mt-1 text-xs text-slate-500">Máximo 500 caracteres</p>
                    </div>

                    <!-- Cor da Comunidade -->
                    <div>
                        <label for="color" class="mb-2 block text-sm font-medium text-slate-300">
                            Cor da Comunidade *
                        </label>
                        <div class="flex items-center space-x-4">
                            <input
                                type="color"
                                id="color"
                                name="color"
                                value="{{ old('color', '#0ea5e9') }}"
                                class="h-12 w-20 cursor-pointer rounded-lg border border-slate-600 bg-slate-700 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                                required
                            />
                            <div class="flex-1">
                                <input
                                    type="text"
                                    id="color-text"
                                    value="{{ old('color', '#0ea5e9') }}"
                                    placeholder="#0ea5e9"
                                    class="w-full rounded-lg border border-slate-600 bg-slate-700 px-4 py-3 text-white placeholder-slate-400 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                                    pattern="^#[0-9A-Fa-f]{6}$"
                                />
                            </div>
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror

                        <p class="mt-1 text-xs text-slate-500">Escolha uma cor que represente sua comunidade</p>
                    </div>

                    <!-- Preview da Comunidade -->
                    <div class="rounded-lg border border-slate-600 bg-slate-700 p-4">
                        <h3 class="mb-3 text-sm font-medium text-slate-300">Preview da Comunidade</h3>
                        <div class="flex items-center space-x-3">
                            <div
                                id="preview-color"
                                class="h-8 w-8 rounded-full"
                                style="background-color: #0ea5e9"
                            ></div>
                            <div>
                                <div id="preview-name" class="font-medium text-white">Nome da Comunidade</div>
                                <div id="preview-description" class="text-sm text-slate-400">
                                    Descrição da comunidade aparecerá aqui...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a
                            href="{{ url()->previous() }}"
                            class="rounded-lg border border-slate-600 bg-slate-700 px-6 py-3 text-slate-300 transition-colors hover:bg-slate-600 hover:text-white"
                        >
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/20 focus:outline-none"
                        >
                            Criar Comunidade
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informações Adicionais -->
            <div class="mt-8 rounded-lg border border-slate-700/50 bg-slate-800/30 p-6">
                <h3 class="mb-4 text-lg font-semibold text-white">Dicas para uma boa comunidade</h3>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li class="flex items-start space-x-2">
                        <span class="mt-1 text-blue-400">•</span>
                        <span>Escolha um nome claro e descritivo que reflita o tema da comunidade</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="mt-1 text-blue-400">•</span>
                        <span>Escreva uma descrição detalhada para ajudar outros usuários a entender o propósito</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="mt-1 text-blue-400">•</span>
                        <span>Seja ativo e engajado para manter a comunidade viva</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="mt-1 text-blue-400">•</span>
                        <span>Estabeleça regras claras para manter um ambiente respeitoso</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

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
@endsection
