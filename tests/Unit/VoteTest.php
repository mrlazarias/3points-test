<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create();
    $this->comment = Comment::factory()->create();
    $this->vote = Vote::factory()->create([
        'user_id' => $this->user->id,
        'voteable_id' => $this->post->id,
        'voteable_type' => Post::class,
    ]);
});

describe('Vote Model', function (): void {
    describe('Basic Properties', function (): void {
        it('can be created', function (): void {
            expect($this->vote)->toBeInstanceOf(Vote::class);
        });

        it('has fillable attributes', function (): void {
            $fillable = [
                'user_id', 'voteable_id', 'voteable_type', 'vote_type',
            ];
            expect($this->vote->getFillable())->toEqual($fillable);
        });

        it('casts attributes correctly', function (): void {
            expect($this->vote->user_id)->toBeInt();
            expect($this->vote->voteable_id)->toBeInt();
            expect($this->vote->voteable_type)->toBeString();
            expect($this->vote->vote_type)->toBeString();
        });

        it('has default values', function (): void {
            $newVote = Vote::factory()->create();
            expect(['up', 'down'])->toContain($newVote->vote_type);
        });
    });

    describe('Relationships', function (): void {
        it('belongs to user', function (): void {
            expect($this->vote->user)->toBeInstanceOf(User::class);
            expect($this->vote->user->id)->toBe($this->user->id);
        });

        it('has polymorphic relationship with posts', function (): void {
            expect($this->vote->voteable)->toBeInstanceOf(Post::class);
            expect($this->vote->voteable->id)->toBe($this->post->id);
        });

        it('has polymorphic relationship with comments', function (): void {
            $commentVote = Vote::factory()->create([
                'user_id' => $this->user->id,
                'voteable_id' => $this->comment->id,
                'voteable_type' => Comment::class,
            ]);

            expect($commentVote->voteable)->toBeInstanceOf(Comment::class);
            expect($commentVote->voteable->id)->toBe($this->comment->id);
        });
    });

    describe('Vote Types', function (): void {
        it('can be an upvote', function (): void {
            $upvote = Vote::factory()->create(['vote_type' => 'up']);
            expect($upvote->vote_type)->toBe('up');
        });

        it('can be a downvote', function (): void {
            $downvote = Vote::factory()->create(['vote_type' => 'down']);
            expect($downvote->vote_type)->toBe('down');
        });

        it('only allows valid vote types', function (): void {
            expect(['up', 'down'])->toContain($this->vote->vote_type);
        });
    });

    describe('Validation', function (): void {
        it('has required fields', function (): void {
            expect($this->vote->user_id)->not->toBeNull();
            expect($this->vote->voteable_id)->not->toBeNull();
            expect($this->vote->voteable_type)->not->toBeEmpty();
            expect($this->vote->vote_type)->not->toBeEmpty();
        });

        it('requires valid voteable_type', function (): void {
            expect([Post::class, Comment::class])->toContain($this->vote->voteable_type);
        });

        it('requires valid vote_type', function (): void {
            expect(['up', 'down'])->toContain($this->vote->vote_type);
        });
    });

    describe('Factory States', function (): void {
        it('can create upvote', function (): void {
            $upvote = Vote::factory()->upvote()->create();
            expect($upvote->vote_type)->toBe('up');
        });

        it('can create downvote', function (): void {
            $downvote = Vote::factory()->downvote()->create();
            expect($downvote->vote_type)->toBe('down');
        });

        it('can create vote for post', function (): void {
            $post = Post::factory()->create();
            $vote = Vote::factory()->forPost($post)->create();

            expect($vote->voteable_id)->toBe($post->id);
            expect($vote->voteable_type)->toBe(Post::class);
        });

        it('can create vote for comment', function (): void {
            $comment = Comment::factory()->create();
            $vote = Vote::factory()->forComment($comment)->create();

            expect($vote->voteable_id)->toBe($comment->id);
            expect($vote->voteable_type)->toBe(Comment::class);
        });
    });
});
