<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use App\Models\Vote;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->subreddit = Subreddit::factory()->create();
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id,
        'subreddit_id' => $this->subreddit->id,
    ]);
});

describe('Post Model', function (): void {
    describe('Basic Properties', function (): void {
        it('can be created', function (): void {
            expect($this->post)->toBeInstanceOf(Post::class);
        });

        it('has fillable attributes', function (): void {
            $fillable = [
                'title', 'slug', 'content', 'type', 'url',
                'subreddit_id', 'user_id', 'vote_score',
                'likes_count', 'dislikes_count', 'comment_count', 'is_pinned', 'is_locked',
            ];
            expect($this->post->getFillable())->toEqual($fillable);
        });

        it('casts attributes correctly', function (): void {
            expect($this->post->is_pinned)->toBeBool();
            expect($this->post->is_locked)->toBeBool();
            expect($this->post->vote_score)->toBeInt();
            expect($this->post->comment_count)->toBeInt();
        });

        it('has default values', function (): void {
            $newPost = Post::factory()->create([
                'vote_score' => 0,
                'comment_count' => 0,
                'is_pinned' => false,
                'is_locked' => false,
            ]);
            expect($newPost->vote_score)->toBe(0);
            expect($newPost->comment_count)->toBe(0);
            expect($newPost->is_pinned)->toBeFalse();
            expect($newPost->is_locked)->toBeFalse();
        });
    });

    describe('Relationships', function (): void {
        it('belongs to user', function (): void {
            expect($this->post->user)->toBeInstanceOf(User::class);
            expect($this->post->user->id)->toBe($this->user->id);
        });

        it('belongs to subreddit', function (): void {
            expect($this->post->subreddit)->toBeInstanceOf(Subreddit::class);
            expect($this->post->subreddit->id)->toBe($this->subreddit->id);
        });

        it('has many comments', function (): void {
            Comment::factory()->count(3)->create(['post_id' => $this->post->id]);

            expect($this->post->comments)->toHaveCount(3);
            expect($this->post->comments->first())->toBeInstanceOf(Comment::class);
        });

        it('has many votes', function (): void {
            Vote::factory()->count(2)->create([
                'voteable_id' => $this->post->id,
                'voteable_type' => Post::class,
            ]);

            expect($this->post->votes)->toHaveCount(2);
            expect($this->post->votes->first())->toBeInstanceOf(Vote::class);
        });
    });

    describe('Vote Methods', function (): void {
        it('has vote score field', function (): void {
            expect($this->post->vote_score)->toBeInt();
        });

        it('has likes_count field', function (): void {
            expect($this->post->likes_count)->toBeNull(); // Campo pode ser null inicialmente
        });

        it('has dislikes_count field', function (): void {
            expect($this->post->dislikes_count)->toBeNull(); // Campo pode ser null inicialmente
        });
    });

    describe('Content Methods', function (): void {
        it('has title and content', function (): void {
            expect($this->post->title)->toBeString();
            expect($this->post->title)->not->toBeEmpty();
            expect($this->post->content)->toBeString();
            expect($this->post->content)->not->toBeEmpty();
        });

        it('has slug', function (): void {
            expect($this->post->slug)->toBeString();
            expect($this->post->slug)->not->toBeEmpty();
        });

        it('has type', function (): void {
            expect($this->post->type)->toBeString();
            expect(['text', 'link', 'image'])->toContain($this->post->type);
        });
    });

    describe('Factory States', function (): void {
        it('can create text post', function (): void {
            $textPost = Post::factory()->text()->create();

            expect($textPost->type)->toBe('text');
            expect($textPost->url)->toBeNull();
        });

        it('can create link post', function (): void {
            $linkPost = Post::factory()->link()->create();

            expect($linkPost->type)->toBe('link');
            expect($linkPost->url)->not->toBeNull();
        });

        it('can create image post', function (): void {
            $imagePost = Post::factory()->image()->create();

            expect($imagePost->type)->toBe('image');
            expect($imagePost->url)->not->toBeNull();
        });

        it('can create pinned post', function (): void {
            $pinnedPost = Post::factory()->pinned()->create();

            expect($pinnedPost->is_pinned)->toBeTrue();
        });

        it('can create locked post', function (): void {
            $lockedPost = Post::factory()->locked()->create();

            expect($lockedPost->is_locked)->toBeTrue();
        });

        it('can create popular post', function (): void {
            $popularPost = Post::factory()->popular()->create();

            expect($popularPost->vote_score)->toBeGreaterThanOrEqual(100);
            expect($popularPost->comment_count)->toBeGreaterThanOrEqual(50);
        });
    });

    describe('Validation', function (): void {
        it('has required fields', function (): void {
            expect($this->post->title)->not->toBeEmpty();
            expect($this->post->content)->not->toBeEmpty();
            expect($this->post->type)->not->toBeEmpty();
            expect($this->post->user_id)->not->toBeNull();
            expect($this->post->subreddit_id)->not->toBeNull();
        });
    });
});
