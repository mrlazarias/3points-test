<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserFollow>
 */
final class UserFollowFactory extends Factory
{
    protected $model = UserFollow::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // follower
            'following_id' => User::factory(), // following
        ];
    }

    /**
     * Create a follow relationship with specific follower
     */
    public function follower(?User $user = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => $user ?? User::factory(),
        ]);
    }

    /**
     * Create a follow relationship with specific user being followed
     */
    public function following(?User $user = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'following_id' => $user ?? User::factory(),
        ]);
    }
}
