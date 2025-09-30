<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('community_follows', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subreddit_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Garantir que um usuário só pode seguir uma comunidade uma vez
            $table->unique(['user_id', 'subreddit_id']);

            // Índices para melhor performance
            $table->index(['user_id', 'created_at']);
            $table->index(['subreddit_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_follows');
    }
};
