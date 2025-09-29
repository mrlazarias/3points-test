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
        Schema::create('posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content'); // Suporte para Markdown
            $table->string('type')->default('text'); // text, link, image
            $table->string('url')->nullable(); // Para posts de link
            $table->foreignId('subreddit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('vote_score')->default(0); // Cache do score total
            $table->integer('comment_count')->default(0); // Cache do número de comentários
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->index(['subreddit_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['vote_score', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
