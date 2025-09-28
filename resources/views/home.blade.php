<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Reddit Clone</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <h1 class="mb-8 text-3xl font-bold">Reddit Clone - Home</h1>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                <!-- Posts -->
                <div class="lg:col-span-3">
                    <div class="rounded-lg bg-white p-6 shadow">
                        <h2 class="mb-4 text-xl font-semibold">Posts ({{ $posts->count() }})</h2>

                        @forelse ($posts as $post)
                            <div class="mb-4 border-b pb-4 last:border-b-0">
                                <h3 class="text-lg font-medium">{{ $post->title }}</h3>
                                <p class="text-sm text-gray-600">
                                    r/{{ $post->subreddit->slug }} • por {{ $post->user->name }} •
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                                <p class="mt-2 text-gray-700">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">Nenhum post encontrado.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="rounded-lg bg-white p-6 shadow">
                        <h2 class="mb-4 text-lg font-semibold">Comunidades ({{ $subreddits->count() }})</h2>

                        @foreach ($subreddits as $subreddit)
                            <div class="mb-2">
                                <a href="#" class="text-blue-600 hover:underline">r/{{ $subreddit->slug }}</a>
                                <span class="text-sm text-gray-500">({{ $subreddit->posts_count }} posts)</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
