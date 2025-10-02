<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Subreddit>
 */
final class SubredditFactory extends Factory
{
    protected $model = Subreddit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'color' => fake()->hexColor(),
            'created_by' => User::factory(),
            'is_active' => true,
        ];
    }

    /**
     * Create an inactive subreddit
     */
    public function inactive(): self
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a subreddit with specific color
     */
    public function withColor(string $color): self
    {
        return $this->state(fn (array $attributes): array => [
            'color' => $color,
        ]);
    }

    /**
     * Create a tech subreddit
     */
    public function tech(): self
    {
        return $this->state(fn (array $attributes): array => [
            'name' => fake()->randomElement([
                'Laravel Community',
                'PHP Developers',
                'JavaScript News',
                'React Community',
                'Vue.js Developers',
                'Node.js Community',
                'Python Programming',
                'Web Development',
                'Software Engineering',
                'Tech News',
            ]),
            'description' => fake()->randomElement([
                'Discussion about web development and programming',
                'Latest news and updates from the tech world',
                'Community for developers and programmers',
                'Share your projects and get feedback',
                'Learning resources and tutorials',
            ]),
            'color' => fake()->randomElement(['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']),
        ]);
    }

    /**
     * Create a gaming subreddit
     */
    public function gaming(): self
    {
        return $this->state(fn (array $attributes): array => [
            'name' => fake()->randomElement([
                'Gaming Community',
                'Indie Games',
                'Game Development',
                'Gaming News',
                'PC Gaming',
                'Console Gaming',
                'Mobile Gaming',
                'Retro Gaming',
            ]),
            'description' => fake()->randomElement([
                'Discussion about video games and gaming culture',
                'Share your gaming experiences and reviews',
                'Latest gaming news and updates',
                'Community for gamers of all types',
            ]),
            'color' => fake()->randomElement(['#DC2626', '#EA580C', '#CA8A04', '#059669']),
        ]);
    }
}
