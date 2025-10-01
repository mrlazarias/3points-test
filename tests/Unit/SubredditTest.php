<?php

declare(strict_types=1);

use App\Models\CommunityFollow;
use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->subreddit = Subreddit::factory()->create([
        'created_by' => $this->user->id,
    ]);
});

describe('Subreddit Model', function (): void {
    describe('Basic Properties', function (): void {
        it('can be created', function (): void {
            expect($this->subreddit)->toBeInstanceOf(Subreddit::class);
        });

        it('has fillable attributes', function (): void {
            $fillable = [
                'name', 'slug', 'description', 'color', 'created_by', 'is_active',
            ];
            expect($this->subreddit->getFillable())->toEqual($fillable);
        });

        it('casts attributes correctly', function (): void {
            expect($this->subreddit->is_active)->toBeBool();
        });

        it('has default values', function (): void {
            $newSubreddit = Subreddit::factory()->create();
            expect($newSubreddit->is_active)->toBeTrue();
        });
    });

    describe('Relationships', function (): void {
        it('belongs to creator', function (): void {
            expect($this->subreddit->creator)->toBeInstanceOf(User::class);
            expect($this->subreddit->creator->id)->toBe($this->user->id);
        });

        it('has many posts', function (): void {
            Post::factory()->count(3)->create(['subreddit_id' => $this->subreddit->id]);

            expect($this->subreddit->posts)->toHaveCount(3);
            expect($this->subreddit->posts->first())->toBeInstanceOf(Post::class);
        });

        it('has many followers', function (): void {
            $followers = User::factory()->count(2)->create();

            foreach ($followers as $follower) {
                CommunityFollow::factory()->create([
                    'user_id' => $follower->id,
                    'subreddit_id' => $this->subreddit->id,
                ]);
            }

            expect($this->subreddit->followers)->toHaveCount(2);
            expect($this->subreddit->followers->first())->toBeInstanceOf(User::class);
        });
    });

    describe('Follow Management', function (): void {
        it('can check if user is followed', function (): void {
            $follower = User::factory()->create();

            expect($this->subreddit->isFollowedBy($follower))->toBeFalse();

            $this->subreddit->follow($follower);

            expect($this->subreddit->isFollowedBy($follower))->toBeTrue();
        });

        it('can follow a user', function (): void {
            $follower = User::factory()->create();

            $result = $this->subreddit->follow($follower);

            expect($result)->toBeTrue();
            expect($this->subreddit->isFollowedBy($follower))->toBeTrue();
        });

        it('cannot follow same user twice', function (): void {
            $follower = User::factory()->create();

            $this->subreddit->follow($follower);
            $result = $this->subreddit->follow($follower);

            expect($result)->toBeFalse();
        });

        it('can unfollow a user', function (): void {
            $follower = User::factory()->create();

            $this->subreddit->follow($follower);
            $result = $this->subreddit->unfollow($follower);

            expect($result)->toBeTrue();
            expect($this->subreddit->isFollowedBy($follower))->toBeFalse();
        });

        it('cannot unfollow user that is not followed', function (): void {
            $follower = User::factory()->create();

            $result = $this->subreddit->unfollow($follower);

            expect($result)->toBeFalse();
        });
    });

    describe('Content Methods', function (): void {
        it('has name and description', function (): void {
            expect($this->subreddit->name)->toBeString();
            expect($this->subreddit->name)->not->toBeEmpty();
            expect($this->subreddit->description)->toBeString();
            expect($this->subreddit->description)->not->toBeEmpty();
        });

        it('has slug', function (): void {
            expect($this->subreddit->slug)->toBeString();
            expect($this->subreddit->slug)->not->toBeEmpty();
        });

        it('has color', function (): void {
            expect($this->subreddit->color)->toBeString();
            expect($this->subreddit->color)->toMatch('/^#[0-9a-fA-F]{6}$/');
        });
    });

    describe('Validation', function (): void {
        it('has required fields', function (): void {
            expect($this->subreddit->name)->not->toBeEmpty();
            expect($this->subreddit->slug)->not->toBeEmpty();
            expect($this->subreddit->description)->not->toBeEmpty();
            expect($this->subreddit->color)->not->toBeEmpty();
            expect($this->subreddit->created_by)->not->toBeNull();
        });
    });
});
