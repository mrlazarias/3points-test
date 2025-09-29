<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Comment extends Model
{
    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'parent_id',
        'vote_score',
        'likes_count',
        'dislikes_count',
        'depth',
        'is_deleted',
    ];

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Comment, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return MorphMany<Vote, $this>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function updateVoteScore(): void
    {
        $upvotes = $this->votes()->where('vote_type', 'up')->count();
        $downvotes = $this->votes()->where('vote_type', 'down')->count();

        $this->update([
            'vote_score' => $upvotes - $downvotes,
            'likes_count' => $upvotes,
            'dislikes_count' => $downvotes,
        ]);
    }

    public function softDelete(): void
    {
        $this->update(['is_deleted' => true]);
    }

    /**
     * Check if the current user can delete this comment
     */
    public function canBeDeletedBy(?User $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        // Comment author can delete their own comment
        if ($this->user_id === $user->id) {
            return true;
        }
        // Post author can delete any comment on their post
        return $this->post->user_id === $user->id;
    }

    /**
     * Check if the current user can reply to this comment
     */
    public function canBeRepliedToBy(?User $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        // Check if post is locked
        if ($this->post->is_locked) {
            return false;
        }
        // Check if comment is deleted
        return !$this->is_deleted;
    }

    protected static function booted(): void
    {
        self::creating(function (Comment $comment): void {
            if ($comment->parent_id) {
                $parent = self::query()->find($comment->parent_id);
                $comment->depth = $parent ? $parent->depth + 1 : 0;
            }
        });

        self::created(function (Comment $comment): void {
            $comment->post->updateCommentCount();
        });

        self::deleted(function (Comment $comment): void {
            $comment->post->updateCommentCount();
        });
    }

    protected function casts(): array
    {
        return [
            'is_deleted' => 'boolean',
            'vote_score' => 'integer',
            'depth' => 'integer',
        ];
    }
}
