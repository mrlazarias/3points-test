<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class AddUsernamesToExistingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:add-usernames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Add usernames to existing users who don't have one";

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Adicionando usernames para usuários existentes...');

        $usersWithoutUsername = User::query()
            ->whereNull('username')
            ->orWhere('username', '')
            ->get();

        if ($usersWithoutUsername->isEmpty()) {
            $this->info('Todos os usuários já possuem username!');

            return self::SUCCESS;
        }

        $this->info(sprintf('Encontrados %d usuários sem username.', $usersWithoutUsername->count()));

        $bar = $this->output->createProgressBar($usersWithoutUsername->count());
        $bar->start();

        foreach ($usersWithoutUsername as $user) {
            $username = $this->generateUniqueUsername($user->name);

            $user->update(['username' => $username]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Usernames adicionados com sucesso!');

        return self::SUCCESS;
    }

    /**
     * Generate a unique username based on the user's name
     */
    private function generateUniqueUsername(string $name): string
    {
        // Remove acentos e caracteres especiais
        $username = Str::slug($name, '');

        // Remove espaços e converte para minúsculo
        $username = mb_strtolower(str_replace(' ', '', $username));

        // Se estiver vazio, usar um nome genérico
        if ($username === '' || $username === '0') {
            $username = 'user';
        }

        // Verificar se já existe e adicionar número se necessário
        $originalUsername = $username;
        $counter = 1;

        while (User::query()->where('username', $username)->exists()) {
            $username = $originalUsername.$counter;
            $counter++;
        }

        return $username;
    }
}
