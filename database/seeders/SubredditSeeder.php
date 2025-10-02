<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Seeder;

final class SubredditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->first();

        if (! $admin) {
            return;
        }

        $subreddits = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'Discussões sobre o framework PHP Laravel',
                'color' => '#ff2d20',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'PHP',
                'slug' => 'php',
                'description' => 'Tudo sobre a linguagem PHP',
                'color' => '#777bb4',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'Discussões sobre JavaScript e desenvolvimento web',
                'color' => '#f7df1e',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Programação',
                'slug' => 'programacao',
                'description' => 'Discussões gerais sobre programação',
                'color' => '#0ea5e9',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Tecnologia',
                'slug' => 'tecnologia',
                'description' => 'Notícias e discussões sobre tecnologia',
                'color' => '#10b981',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($subreddits as $subredditData) {
            Subreddit::query()->firstOrCreate(['slug' => $subredditData['slug']], $subredditData);
        }
    }
}
