<?php

declare(strict_types=1);

?>
@extends('layouts.app')

@section('title', 'Home - Reddit Clone')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="rounded-lg border bg-white shadow-sm">
                    <div class="border-b p-6">
                        <h1 class="text-2xl font-bold text-gray-900">Página inicial</h1>
                        <p class="mt-1 text-gray-600">Os melhores posts de todas as comunidades</p>
                    </div>

                    <div class="divide-y">
                        @forelse ($posts as $post)
                            <x-post-card :post="$post" />
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                <p>Nenhum post encontrado.</p>
                                <p class="mt-2 text-sm">Seja o primeiro a compartilhar algo!</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($posts->hasPages())
                        <div class="border-t p-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <x-sidebar :subreddits="$subreddits" />
            </div>
        </div>
    </div>
@endsection
<?php 
