<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
final class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['follow', 'comment', 'like', 'new_post']);

        return [
            'user_id' => User::factory(),
            'from_user_id' => User::factory(),
            'type' => $type,
            'title' => $this->getTitleForType($type),
            'message' => $this->getMessageForType($type),
            'data' => null,
            'is_read' => fake()->boolean(30), // 30% chance of being read
            'read_at' => fake()->optional(0.3)->dateTimeBetween('-1 week'),
        ];
    }

    /**
     * Create a follow notification
     */
    public function follow(?User $user = null, ?User $fromUser = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'follow',
            'title' => 'Novo seguidor!',
            'message' => ($fromUser ?? User::factory()->create())->name.' começou a te seguir',
            'from_user_id' => $fromUser ?? User::factory(),
        ]);
    }

    /**
     * Create a comment notification
     */
    public function comment(?User $user = null, ?User $fromUser = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'comment',
            'title' => 'Novo comentário',
            'message' => ($fromUser ?? User::factory()->create())->name.' comentou no seu post',
            'from_user_id' => $fromUser ?? User::factory(),
            'data' => [
                'post_id' => fake()->numberBetween(1, 100),
                'post_title' => fake()->sentence(),
            ],
        ]);
    }

    /**
     * Create a like notification
     */
    public function like(?User $user = null, ?User $fromUser = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'like',
            'title' => 'Post curtido',
            'message' => ($fromUser ?? User::factory()->create())->name.' curtiu seu post',
            'from_user_id' => $fromUser ?? User::factory(),
            'data' => [
                'post_id' => fake()->numberBetween(1, 100),
                'post_title' => fake()->sentence(),
            ],
        ]);
    }

    /**
     * Create a new post notification
     */
    public function newPost(?User $user = null, ?User $fromUser = null): self
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'new_post',
            'title' => 'Novo post',
            'message' => ($fromUser ?? User::factory()->create())->name.' criou um novo post',
            'from_user_id' => $fromUser ?? User::factory(),
            'data' => [
                'post_id' => fake()->numberBetween(1, 100),
                'post_title' => fake()->sentence(),
                'community_name' => fake()->words(2, true),
            ],
        ]);
    }

    /**
     * Create a read notification
     */
    public function read(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_read' => true,
            'read_at' => fake()->dateTimeBetween('-1 week'),
        ]);
    }

    /**
     * Create an unread notification
     */
    public function unread(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Create a recent notification
     */
    public function recent(): self
    {
        return $this->state(fn (array $attributes): array => [
            'created_at' => fake()->dateTimeBetween('-1 hour'),
            'updated_at' => fake()->dateTimeBetween('-1 hour'),
        ]);
    }

    /**
     * Create an old notification
     */
    public function old(): self
    {
        return $this->state(fn (array $attributes): array => [
            'created_at' => fake()->dateTimeBetween('-1 month', '-1 week'),
            'updated_at' => fake()->dateTimeBetween('-1 month', '-1 week'),
        ]);
    }

    /**
     * Get title for notification type
     */
    private function getTitleForType(string $type): string
    {
        return match ($type) {
            'follow' => fake()->randomElement([
                'Novo seguidor!',
                'Alguém começou a te seguir',
                'Nova conexão',
            ]),
            'comment' => fake()->randomElement([
                'Novo comentário',
                'Alguém comentou no seu post',
                'Novo comentário recebido',
            ]),
            'like' => fake()->randomElement([
                'Post curtido',
                'Seu post foi curtido',
                'Nova curtida',
            ]),
            'new_post' => fake()->randomElement([
                'Novo post',
                'Nova publicação',
                'Post de alguém que você segue',
            ]),
            default => 'Nova notificação'
        };
    }

    /**
     * Get message for notification type
     */
    private function getMessageForType(string $type): string
    {
        return match ($type) {
            'follow' => fake()->name().' começou a te seguir',
            'comment' => fake()->name().' comentou no seu post',
            'like' => fake()->name().' curtiu seu post',
            'new_post' => fake()->name().' criou um novo post',
            default => 'Você tem uma nova notificação'
        };
    }
}
