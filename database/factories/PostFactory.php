<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(3, true),
            'type' => fake()->randomElement(['text', 'link', 'image']),
            'url' => fake()->optional(0.3)->url(),
            'user_id' => User::factory(),
            'subreddit_id' => Subreddit::factory(),
            'vote_score' => fake()->numberBetween(0, 100),
            'comment_count' => fake()->numberBetween(0, 50),
            'is_pinned' => false,
            'is_locked' => false,
        ];
    }

    /**
     * Create a text post
     */
    public function text(): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'text',
            'url' => null,
            'content' => fake()->paragraphs(5, true),
        ]);
    }

    /**
     * Create a link post
     */
    public function link(): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'link',
            'url' => fake()->url(),
            'content' => fake()->sentence(),
        ]);
    }

    /**
     * Create an image post
     */
    public function image(): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'image',
            'url' => fake()->imageUrl(),
            'content' => fake()->sentence(), // Sempre tem conteúdo
        ]);
    }

    /**
     * Create a pinned post
     */
    public function pinned(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_pinned' => true,
        ]);
    }

    /**
     * Create a locked post
     */
    public function locked(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_locked' => true,
        ]);
    }

    /**
     * Create a popular post
     */
    public function popular(): self
    {
        return $this->state(fn (array $attributes): array => [
            'vote_score' => fake()->numberBetween(100, 1000),
            'comment_count' => fake()->numberBetween(50, 200),
        ]);
    }
}
