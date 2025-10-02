<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
final class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->paragraphs(2, true),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'parent_id' => null,
            'vote_score' => 0,
            'is_deleted' => false,
            'depth' => 0,
        ];
    }

    /**
     * Create a reply comment
     */
    public function reply(?Comment $parent = null): self
    {
        $parent ??= Comment::factory()->create();

        return $this->state(fn (array $attributes): array => [
            'parent_id' => $parent->id,
            'depth' => $parent->depth + 1,
        ]);
    }

    /**
     * Create a nested reply (reply to a reply)
     */
    public function nested(Comment $parent): self
    {
        return $this->state(fn (array $attributes): array => [
            'parent_id' => $parent->id,
            'depth' => $parent->depth + 1,
        ]);
    }

    /**
     * Create a deleted comment
     */
    public function deleted(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_deleted' => true,
            'content' => '[deleted]',
        ]);
    }

    /**
     * Create a popular comment
     */
    public function popular(): self
    {
        return $this->state(fn (array $attributes): array => [
            'vote_score' => fake()->numberBetween(50, 200),
        ]);
    }

    /**
     * Create a short comment
     */
    public function short(): self
    {
        return $this->state(fn (array $attributes): array => [
            'content' => fake()->sentence(),
        ]);
    }

    /**
     * Create a long comment
     */
    public function long(): self
    {
        return $this->state(fn (array $attributes): array => [
            'content' => fake()->paragraphs(5, true),
        ]);
    }

    /**
     * Create a comment with markdown
     */
    public function withMarkdown(): self
    {
        return $this->state(fn (array $attributes): array => [
            'content' => fake()->randomElement([
                'This is **bold** text and *italic* text.',
                'Here is some `code` and a [link](https://example.com).',
                '# Heading\n\nThis is a paragraph with **bold** and *italic* text.',
                '```php\n<?php\necho "Hello World";\n```',
                '> This is a quote\n\nAnd some regular text below.',
            ]),
        ]);
    }
}
