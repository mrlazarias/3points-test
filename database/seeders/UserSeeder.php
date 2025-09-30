<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuários com usernames para teste
        User::query()->create([
            'name' => 'João Silva',
            'username' => 'joaosilva',
            'email' => 'joao@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Desenvolvedor apaixonado por tecnologia',
            'location' => 'São Paulo, SP',
            'is_public' => true,
        ]);

        User::query()->create([
            'name' => 'Maria Santos',
            'username' => 'mariasantos',
            'email' => 'maria@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Designer UX/UI e entusiasta de design',
            'location' => 'Rio de Janeiro, RJ',
            'is_public' => true,
        ]);

        User::query()->create([
            'name' => 'Pedro Costa',
            'username' => 'pedrocosta',
            'email' => 'pedro@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Engenheiro de software especializado em Laravel',
            'location' => 'Belo Horizonte, MG',
            'is_public' => true,
        ]);

        User::query()->create([
            'name' => 'Ana Oliveira',
            'username' => 'anaoliveira',
            'email' => 'ana@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Product Manager e estrategista digital',
            'location' => 'Porto Alegre, RS',
            'is_public' => false, // Perfil privado
        ]);
    }
}
