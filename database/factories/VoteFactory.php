<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vote>
 */
final class VoteFactory extends Factory
{
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'voteable_id' => Post::factory(),
            'voteable_type' => Post::class,
            'vote_type' => fake()->randomElement(['up', 'down']),
        ];
    }

    /**
     * Create an upvote
     */
    public function upvote(): self
    {
        return $this->state(fn (array $attributes): array => [
            'vote_type' => 'up',
        ]);
    }

    /**
     * Create a downvote
     */
    public function downvote(): self
    {
        return $this->state(fn (array $attributes): array => [
            'vote_type' => 'down',
        ]);
    }

    /**
     * Create a vote on a post
     */
    public function forPost(?Post $post = null): self
    {
        $post ??= Post::factory()->create();

        return $this->state(fn (array $attributes): array => [
            'voteable_id' => $post->id,
            'voteable_type' => Post::class,
        ]);
    }

    /**
     * Create a vote on a comment
     */
    public function forComment(?Comment $comment = null): self
    {
        $comment ??= Comment::factory()->create();

        return $this->state(fn (array $attributes): array => [
            'voteable_id' => $comment->id,
            'voteable_type' => Comment::class,
        ]);
    }

    /**
     * Create an upvote on a post
     */
    public function upvotePost(?Post $post = null): self
    {
        return $this->upvote()->forPost($post);
    }

    /**
     * Create a downvote on a post
     */
    public function downvotePost(?Post $post = null): self
    {
        return $this->downvote()->forPost($post);
    }

    /**
     * Create an upvote on a comment
     */
    public function upvoteComment(?Comment $comment = null): self
    {
        return $this->upvote()->forComment($comment);
    }

    /**
     * Create a downvote on a comment
     */
    public function downvoteComment(?Comment $comment = null): self
    {
        return $this->downvote()->forComment($comment);
    }
}
