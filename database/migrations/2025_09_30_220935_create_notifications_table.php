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
        Schema::create('notifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário que recebe a notificação
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade'); // Usuário que gerou a notificação
            $table->string('type'); // like, comment, follow, follow_back, new_post
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Dados adicionais (post_id, comment_id, etc.)
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Índices para performance
            $table->index('user_id');
            $table->index('from_user_id');
            $table->index('type');
            $table->index('is_read');
            $table->index(['user_id', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
