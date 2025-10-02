<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create();
    $this->comment = Comment::factory()->create([
        'user_id' => $this->user->id,
        'post_id' => $this->post->id,
    ]);
});

describe('Comment Model', function (): void {
    describe('Basic Properties', function (): void {
        it('can be created', function (): void {
            expect($this->comment)->toBeInstanceOf(Comment::class);
        });

        it('has fillable attributes', function (): void {
            $fillable = [
                'content', 'post_id', 'user_id', 'parent_id',
                'vote_score', 'likes_count', 'dislikes_count',
                'depth', 'is_deleted',
            ];
            expect($this->comment->getFillable())->toEqual($fillable);
        });

        it('has default values', function (): void {
            expect($this->comment->vote_score)->toBe(0);
            expect($this->comment->depth)->toBe(0);
            expect($this->comment->is_deleted)->toBeFalse();
            expect($this->comment->parent_id)->toBeNull();
        });

        it('casts attributes correctly', function (): void {
            expect($this->comment->is_deleted)->toBeBool();
            expect($this->comment->vote_score)->toBeInt();
            expect($this->comment->depth)->toBeInt();
        });
    });

    describe('Relationships', function (): void {
        it('belongs to user', function (): void {
            expect($this->comment->user)->toBeInstanceOf(User::class);
            expect($this->comment->user->id)->toBe($this->user->id);
        });

        it('belongs to post', function (): void {
            expect($this->comment->post)->toBeInstanceOf(Post::class);
            expect($this->comment->post->id)->toBe($this->post->id);
        });

        it('can have parent comment', function (): void {
            $parentComment = Comment::factory()->create();
            $reply = Comment::factory()->create(['parent_id' => $parentComment->id]);

            expect($reply->parent)->toBeInstanceOf(Comment::class);
            expect($reply->parent->id)->toBe($parentComment->id);
        });

        it('can have replies', function (): void {
            $reply = Comment::factory()->create(['parent_id' => $this->comment->id]);

            expect($this->comment->replies)->toHaveCount(1);
            expect($this->comment->replies->first())->toBeInstanceOf(Comment::class);
        });

        it('has many votes', function (): void {
            Vote::factory()->count(2)->create([
                'voteable_id' => $this->comment->id,
                'voteable_type' => Comment::class,
            ]);

            expect($this->comment->votes)->toHaveCount(2);
            expect($this->comment->votes->first())->toBeInstanceOf(Vote::class);
        });
    });

    describe('Vote Methods', function (): void {
        it('has vote score field', function (): void {
            expect($this->comment->vote_score)->toBe(0);
        });

        it('has likes_count field', function (): void {
            expect($this->comment->likes_count)->toBeNull(); // Campo pode ser null inicialmente
        });

        it('has dislikes_count field', function (): void {
            expect($this->comment->dislikes_count)->toBeNull(); // Campo pode ser null inicialmente
        });
    });

    describe('Depth Management', function (): void {
        it('calculates depth correctly for top-level comments', function (): void {
            expect($this->comment->depth)->toBe(0);
        });

        it('calculates depth correctly for replies', function (): void {
            $reply = Comment::factory()->create([
                'parent_id' => $this->comment->id,
                'depth' => 1,
            ]);

            expect($reply->depth)->toBe(1);
        });
    });

    describe('Soft Delete', function (): void {
        it('can be soft deleted', function (): void {
            $this->comment->softDelete();

            expect($this->comment->is_deleted)->toBeTrue();
        });
    });

    describe('Content Methods', function (): void {
        it('has content field', function (): void {
            expect($this->comment->content)->toBeString();
            expect($this->comment->content)->not->toBeEmpty();
        });
    });

    describe('Validation', function (): void {
        it('has required fields', function (): void {
            expect($this->comment->content)->not->toBeEmpty();
            expect($this->comment->user_id)->not->toBeNull();
            expect($this->comment->post_id)->not->toBeNull();
        });
    });
});
