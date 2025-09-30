<?php

declare(strict_types=1);

?>
declare(strict_types=1); ?>
@extends('layouts.app')

@section('title', 'Criar Comunidade - 3Pontos Community')

@section('content')
    <div class="mx-auto max-w-3xl px-8 py-12">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="font-display mb-2 text-3xl font-bold text-white">Criar Nova Comunidade</h1>
            <p class="text-gray-400">Preencha as informações abaixo para criar sua comunidade</p>
        </div>

        {{-- Form --}}
        <div class="border-dark-border bg-dark-surface rounded-2xl border p-8">
            <form action="{{ route('subreddit.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-white">
                        Nome da Comunidade
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        maxlength="50"
                        class="border-dark-border bg-dark-bg w-full rounded-lg border px-4 py-3 text-white placeholder-gray-600 transition-all focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none"
                        placeholder="Ex: Laravel, JavaScript, Gaming..."
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">O nome da sua comunidade (máximo 50 caracteres)</p>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-white">
                        Descrição
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        required
                        maxlength="500"
                        class="border-dark-border bg-dark-bg w-full rounded-lg border px-4 py-3 text-white placeholder-gray-600 transition-all focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none"
                        placeholder="Descreva sobre o que é sua comunidade..."
                    >
{{ old('description') }}</textarea
                    >
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-gray-500">
                        Uma breve descrição da sua comunidade (máximo 500 caracteres)
                    </p>
                </div>

                {{-- Color Picker --}}
                <div>
                    <label for="color" class="mb-2 block text-sm font-semibold text-white">Cor da Comunidade</label>
                    <div class="flex items-center gap-4">
                        <input
                            type="color"
                            id="color"
                            name="color"
                            value="{{ old('color', '#f97316') }}"
                            class="border-dark-border h-12 w-12 cursor-pointer rounded-lg border-2 bg-transparent"
                        />
                        <div>
                            <p class="text-sm text-gray-300">Escolha uma cor para representar sua comunidade</p>
                            <p class="text-xs text-gray-500">Será usada no avatar e tema da comunidade</p>
                        </div>
                    </div>
                    @error('color')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preview --}}
                <div class="border-dark-border bg-dark-bg rounded-xl border p-6">
                    <p class="mb-4 text-sm font-semibold text-gray-400">Preview da Comunidade</p>
                    <div class="flex items-center gap-4">
                        <div
                            id="preview-avatar"
                            class="flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-500 text-2xl font-bold text-white"
                        >
                            L
                        </div>
                        <div>
                            <h3 id="preview-name" class="font-display text-xl font-bold text-white">r/Laravel</h3>
                            <p id="preview-description" class="text-sm text-gray-400">
                                Discussões sobre o framework PHP Laravel
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-4">
                    <a
                        href="/"
                        class="border-dark-border bg-dark-border hover:bg-dark-hover rounded-lg border px-6 py-3 text-sm font-semibold text-gray-400 transition-all"
                    >
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-3 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/40"
                    >
                        Criar Comunidade
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Real-time preview
        const nameInput = document.getElementById('name');
        const descriptionInput = document.getElementById('description');
        const colorInput = document.getElementById('color');
        const previewName = document.getElementById('preview-name');
        const previewDescription = document.getElementById('preview-description');
        const previewAvatar = document.getElementById('preview-avatar');

        nameInput?.addEventListener('input', function () {
            const value = this.value || 'Nome da Comunidade';
            previewName.textContent = `r/${value}`;
            previewAvatar.textContent = value.charAt(0).toUpperCase() || 'C';
        });

        descriptionInput?.addEventListener('input', function () {
            previewDescription.textContent = this.value || 'Descrição da comunidade...';
        });

        colorInput?.addEventListener('input', function () {
            // Usar uma variável CSS para a cor do preview
            document.documentElement.style.setProperty('--preview-color', this.value);
            previewAvatar.style.backgroundColor = this.value;
        });
    </script>
@endpush
<?php 
