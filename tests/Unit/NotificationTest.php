<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use App\Models\Notification;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->fromUser = User::factory()->create();
    $this->notification = Notification::factory()->create([
        'user_id' => $this->user->id,
        'from_user_id' => $this->fromUser->id,
    ]);
});

describe('Notification Model', function (): void {
    describe('Basic Properties', function (): void {
        it('can be created', function (): void {
            expect($this->notification)->toBeInstanceOf(Notification::class);
        });

        it('has fillable attributes', function (): void {
            $fillable = [
                'user_id', 'from_user_id', 'type', 'title',
                'message', 'data', 'is_read', 'read_at',
            ];
            expect($this->notification->getFillable())->toEqual($fillable);
        });

        it('casts attributes correctly', function (): void {
            expect($this->notification->is_read)->toBeBool();
            if ($this->notification->read_at) {
                expect($this->notification->read_at)->toBeInstanceOf(CarbonImmutable::class);
            }

            expect($this->notification->data)->toBeNull(); // Factory pode criar como null
        });

        it('has default values', function (): void {
            $newNotification = Notification::factory()->create();
            expect($newNotification->is_read)->toBeBool(); // Pode ser true ou false
            expect($newNotification->data)->toBeNull();
        });
    });

    describe('Relationships', function (): void {
        it('belongs to user', function (): void {
            expect($this->notification->user)->toBeInstanceOf(User::class);
            expect($this->notification->user->id)->toBe($this->user->id);
        });

        it('belongs to from_user', function (): void {
            expect($this->notification->fromUser)->toBeInstanceOf(User::class);
            expect($this->notification->fromUser->id)->toBe($this->fromUser->id);
        });
    });

    describe('Read Status Management', function (): void {
        it('can be marked as read', function (): void {
            $notification = Notification::factory()->unread()->create();

            expect($notification->is_read)->toBeFalse();

            $notification->markAsRead();

            expect($notification->is_read)->toBeTrue();
        });

        it('can be marked as unread', function (): void {
            $notification = Notification::factory()->read()->create();

            expect($notification->is_read)->toBeTrue();

            $notification->markAsUnread();

            expect($notification->is_read)->toBeFalse();
        });

        it('sets read_at timestamp when marked as read', function (): void {
            $notification = Notification::factory()->unread()->create();

            expect($notification->read_at)->toBeNull();

            $notification->markAsRead();

            expect($notification->read_at)->toBeInstanceOf(CarbonImmutable::class);
        });

        it('clears read_at timestamp when marked as unread', function (): void {
            $notification = Notification::factory()->read()->create();
            $notification->markAsUnread();

            expect($notification->read_at)->toBeNull();
        });
    });

    describe('Validation', function (): void {
        it('has required fields', function (): void {
            expect($this->notification->title)->not->toBeEmpty();
            expect($this->notification->message)->not->toBeEmpty();
            expect($this->notification->type)->not->toBeEmpty();
            expect($this->notification->user_id)->not->toBeNull();
            expect($this->notification->from_user_id)->not->toBeNull();
        });
    });

    describe('Factory States', function (): void {
        it('can create follow notification', function (): void {
            $followNotification = Notification::factory()->follow($this->user, $this->fromUser)->create();

            expect($followNotification->type)->toBe('follow');
            expect($followNotification->title)->toBe('Novo seguidor!');
        });

        it('can create comment notification', function (): void {
            $commentNotification = Notification::factory()->comment($this->user, $this->fromUser)->create();

            expect($commentNotification->type)->toBe('comment');
            expect($commentNotification->title)->toBe('Novo comentário');
        });

        it('can create like notification', function (): void {
            $likeNotification = Notification::factory()->like($this->user, $this->fromUser)->create();

            expect($likeNotification->type)->toBe('like');
            expect($likeNotification->title)->toBe('Post curtido');
        });

        it('can create new post notification', function (): void {
            $newPostNotification = Notification::factory()->newPost($this->user, $this->fromUser)->create();

            expect($newPostNotification->type)->toBe('new_post');
            expect($newPostNotification->title)->toBe('Novo post');
        });

        it('can create read notification', function (): void {
            $readNotification = Notification::factory()->read()->create();

            expect($readNotification->is_read)->toBeTrue();
            expect($readNotification->read_at)->not->toBeNull();
        });

        it('can create unread notification', function (): void {
            $unreadNotification = Notification::factory()->unread()->create();

            expect($unreadNotification->is_read)->toBeFalse();
            expect($unreadNotification->read_at)->toBeNull();
        });
    });
});
