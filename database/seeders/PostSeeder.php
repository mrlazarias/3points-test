<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Seeder;

final class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->first();
        $subreddits = Subreddit::all();

        if (! $admin || $subreddits->isEmpty()) {
            return;
        }

        $posts = [
            [
                'title' => 'Bem-vindos ao r/Laravel!',
                'slug' => 'bem-vindos-ao-r-laravel',
                'content' => "# Bem-vindos à comunidade Laravel!\n\nEste é um espaço para discussões sobre o framework **Laravel**.\n\n## O que você pode encontrar aqui:\n\n- Dicas e truques\n- Soluções para problemas comuns\n- Discussões sobre novas features\n- Compartilhamento de projetos\n\nSintam-se à vontade para participar!",
                'type' => 'text',
                'subreddit_id' => $subreddits->where('slug', 'laravel')->first()?->id,
                'user_id' => $admin->id,
                'is_pinned' => true,
            ],
            [
                'title' => 'Laravel 11 - Principais novidades',
                'slug' => 'laravel-11-principais-novidades',
                'content' => "# Laravel 11: O que há de novo?\n\nO Laravel 11 trouxe várias melhorias interessantes:\n\n## Principais mudanças:\n\n1. **Estrutura de aplicação mais limpa**\n2. **Melhor performance**\n3. **Novos helpers**\n4. **Melhorias no Eloquent**\n\nO que vocês acharam das novidades?",
                'type' => 'text',
                'subreddit_id' => $subreddits->where('slug', 'laravel')->first()?->id,
                'user_id' => $admin->id,
            ],
            [
                'title' => 'PHP 8.4 - Features que estão chegando',
                'slug' => 'php-8-4-features-que-estao-chegando',
                'content' => "# PHP 8.4 está chegando!\n\nAlgumas features interessantes que estão sendo desenvolvidas:\n\n- **Property hooks**\n- **Asymmetric visibility**\n- **Lazy objects**\n- **Array find functions**\n\nEstão animados com essas novidades?",
                'type' => 'text',
                'subreddit_id' => $subreddits->where('slug', 'php')->first()?->id,
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Como começar com JavaScript moderno?',
                'slug' => 'como-comecar-com-javascript-moderno',
                'content' => "# Guia para JavaScript moderno\n\nPara quem está começando com JS moderno, algumas dicas:\n\n## Conceitos essenciais:\n\n- **ES6+ features**\n- **Async/await**\n- **Modules**\n- **Frameworks (React, Vue, Angular)**\n\nAlguém tem outras sugestões?",
                'type' => 'text',
                'subreddit_id' => $subreddits->where('slug', 'javascript')->first()?->id,
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Melhores práticas de programação',
                'slug' => 'melhores-praticas-de-programacao',
                'content' => "# Práticas que todo desenvolvedor deveria seguir\n\n## Code Quality:\n\n- **Clean Code**\n- **SOLID principles**\n- **Testing**\n- **Documentation**\n- **Version control**\n\nQuais outras práticas vocês consideram essenciais?",
                'type' => 'text',
                'subreddit_id' => $subreddits->where('slug', 'programacao')->first()?->id,
                'user_id' => $admin->id,
            ],
        ];

        foreach ($posts as $postData) {
            if ($postData['subreddit_id']) {
                Post::query()->firstOrCreate(['slug' => $postData['slug']], $postData);
            }
        }
    }
}
