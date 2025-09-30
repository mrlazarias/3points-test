<?php

declare(strict_types=1);

?>

@extends('layouts.app')
@section('title', 'Editar Perfil')
@section('content')
<div class="mx-auto max-w-4xl px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="mb-4 flex items-center gap-4">
            <a
                href="{{ route('profile.show') }}"
                class="inline-flex items-center gap-2 text-gray-600 transition-colors hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Voltar ao perfil
            </a>
        </div>
        <h1 class="font-display text-3xl font-bold text-gray-900 dark:text-white">Editar Perfil</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Atualize suas informações pessoais e configurações</p>
    </div>
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
            <div class="mb-2 flex items-center gap-2">
                <svg
                    class="h-5 w-5 text-red-600 dark:text-red-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <span class="font-semibold text-red-800 dark:text-red-200">Erro na validação</span>
            </div>
            <ul class="space-y-1 text-sm text-red-700 dark:text-red-300">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6">
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Configurações</h3>
                <nav class="space-y-2">
                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 rounded-lg bg-orange-50 px-3 py-2 text-sm font-medium text-orange-700 dark:bg-orange-900/20 dark:text-orange-400"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                            />
                        </svg>
                        Informações Pessoais
                    </a>
                    <a
                        href="{{ route('profile.edit-password') }}"
                        class="dark:hover:bg-dark-border flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            />
                        </svg>
                        Segurança
                    </a>
                </nav>
            </div>
        </div>
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="space-y-6">
                <!-- Profile Photos -->
                <div
                    class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6"
                >
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Fotos do Perfil</h3>
                    <!-- Cover Photo -->
                    <div class="mb-6">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Foto de Capa
                        </label>
                        <div class="relative">
                            @if ($user->getCoverPhotoUrl())
                                <img
                                    src="{{ $user->getCoverPhotoUrl() }}"
                                    alt="Cover photo"
                                    class="h-32 w-full rounded-lg object-cover"
                                />
                            @else
                                <div
                                    class="dark:bg-dark-border flex h-32 w-full items-center justify-center rounded-lg bg-gray-100"
                                >
                                    <svg
                                        class="h-8 w-8 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2 flex gap-2">
                            <form
                                method="POST"
                                action="{{ route('profile.upload-cover-photo') }}"
                                enctype="multipart/form-data"
                                class="flex-1"
                            >
                                @csrf
                                <input
                                    type="file"
                                    name="cover_photo"
                                    accept="image/*"
                                    onchange="this.form.submit()"
                                    class="hidden"
                                    id="cover-photo-input"
                                />
                                <label
                                    for="cover-photo-input"
                                    class="dark:bg-dark-border dark:hover:bg-dark-hover inline-flex cursor-pointer items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:text-gray-300"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                        />
                                    </svg>
                                    Alterar Capa
                                </label>
                            </form>
                            @if ($user->getCoverPhotoUrl())
                                <form method="POST" action="{{ route('profile.remove-cover-photo') }}" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-red-100 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-200 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                        Remover
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <!-- Profile Picture -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Foto de Perfil
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                @if ($user->getProfilePictureUrl())
                                    <img
                                        src="{{ $user->getProfilePictureUrl() }}"
                                        alt="Profile picture"
                                        class="h-20 w-20 rounded-full object-cover"
                                    />
                                @else
                                    <div
                                        class="flex h-20 w-20 items-center justify-center rounded-full bg-orange-500 text-2xl font-bold text-white"
                                    >
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <form
                                    method="POST"
                                    action="{{ route('profile.upload-photo') }}"
                                    enctype="multipart/form-data"
                                >
                                    @csrf
                                    <input
                                        type="file"
                                        name="photo"
                                        accept="image/*"
                                        onchange="this.form.submit()"
                                        class="hidden"
                                        id="profile-photo-input"
                                    />
                                    <label
                                        for="profile-photo-input"
                                        class="dark:bg-dark-border dark:hover:bg-dark-hover inline-flex cursor-pointer items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:text-gray-300"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                            />
                                        </svg>
                                        Alterar
                                    </label>
                                </form>
                                @if ($user->getProfilePictureUrl())
                                    <form method="POST" action="{{ route('profile.remove-photo') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-2 rounded-lg bg-red-100 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-200 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
                                            </svg>
                                            Remover
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Personal Information Form -->
                <div
                    class="dark:border-dark-border dark:bg-dark-surface rounded-2xl border border-gray-200 bg-white p-6"
                >
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Informações Pessoais</h3>
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Name -->
                            <div>
                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Nome completo *
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                                />
                            </div>
                            <!-- Username -->
                            <div>
                                <label
                                    for="username"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Nome de usuário
                                </label>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    value="{{ old('username', $user->username) }}"
                                    class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                                    placeholder="ex: joao123"
                                />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Usado na URL do seu perfil: /u/joao123
                                </p>
                            </div>
                        </div>
                        <!-- Email -->
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email *
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                            />
                        </div>
                        <!-- Bio -->
                        <div>
                            <label for="bio" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Biografia
                            </label>
                            <textarea
                                id="bio"
                                name="bio"
                                rows="3"
                                class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                                placeholder="Conte um pouco sobre você..."
                            >
{{ old('bio', $user->bio) }}</textarea
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 500 caracteres</p>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Location -->
                            <div>
                                <label
                                    for="location"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Localização
                                </label>
                                <input
                                    type="text"
                                    id="location"
                                    name="location"
                                    value="{{ old('location', $user->location) }}"
                                    class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                                    placeholder="ex: São Paulo, Brasil"
                                />
                            </div>
                            <!-- Website -->
                            <div>
                                <label
                                    for="website"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Website
                                </label>
                                <input
                                    type="url"
                                    id="website"
                                    name="website"
                                    value="{{ old('website', $user->website) }}"
                                    class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                                    placeholder="https://seusite.com"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Birth Date -->
                            <div>
                                <label
                                    for="birth_date"
                                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Data de nascimento
                                </label>
                                <input
                                    type="date"
                                    id="birth_date"
                                    name="birth_date"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                    class="dark:border-dark-border dark:bg-dark-surface w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500"
                                />
                            </div>
                            <!-- Privacy -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Privacidade
                                </label>
                                <div class="flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        id="is_public"
                                        name="is_public"
                                        value="1"
                                        {{ old('is_public', $user->is_public) ? 'checked' : '' }}
                                        class="dark:border-dark-border dark:bg-dark-surface h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                                    />
                                    <label for="is_public" class="text-sm text-gray-700 dark:text-gray-300">
                                        Perfil público (outros usuários podem ver)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-2.5 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/40"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
