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
        Schema::create('comments', function (Blueprint $table): void {
            $table->id();
            $table->longText('content'); // Suporte para Markdown
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->integer('vote_score')->default(0); // Cache do score total
            $table->integer('depth')->default(0); // Nível de aninhamento
            $table->boolean('is_deleted')->default(false); // Soft delete para manter thread
            $table->timestamps();

            $table->index(['post_id', 'parent_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['vote_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
