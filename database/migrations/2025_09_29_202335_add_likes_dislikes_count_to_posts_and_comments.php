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
        Schema::table('posts', function (Blueprint $table): void {
            $table->integer('likes_count')->default(0)->after('vote_score');
            $table->integer('dislikes_count')->default(0)->after('likes_count');
        });

        Schema::table('comments', function (Blueprint $table): void {
            $table->integer('likes_count')->default(0)->after('vote_score');
            $table->integer('dislikes_count')->default(0)->after('likes_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropColumn(['likes_count', 'dislikes_count']);
        });

        Schema::table('comments', function (Blueprint $table): void {
            $table->dropColumn(['likes_count', 'dislikes_count']);
        });
    }
};
