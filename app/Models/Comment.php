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
     * @return BelongsTo<\App\Models\Comment, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<\App\Models\Comment, $this>
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

        $this->update(['vote_score' => $upvotes - $downvotes]);
    }

    public function softDelete(): void
    {
        $this->update(['is_deleted' => true]);
    }

    protected static function booted(): void
    {
        self::creating(function (Comment $comment): void {
            if ($comment->parent_id) {
                $parent = self::find($comment->parent_id);
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
