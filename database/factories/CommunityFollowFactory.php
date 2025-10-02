<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CommunityFollow;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommunityFollow>
 */
final class CommunityFollowFactory extends Factory
{
    protected $model = CommunityFollow::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'subreddit_id' => Subreddit::factory(),
        ];
    }

    /**
     * Create a follow relationship with specific user
     */
    public function forUser(?User $user = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => $user ?? User::factory(),
        ]);
    }

    /**
     * Create a follow relationship with specific subreddit
     */
    public function forSubreddit(?Subreddit $subreddit = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'subreddit_id' => $subreddit ?? Subreddit::factory(),
        ]);
    }
}
