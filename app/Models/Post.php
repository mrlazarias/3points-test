<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

final class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'type',
        'url',
        'subreddit_id',
        'user_id',
        'vote_score',
        'likes_count',
        'dislikes_count',
        'comment_count',
        'is_pinned',
        'is_locked',
    ];

    /**
     * @return BelongsTo<Subreddit, $this>
     */
    public function subreddit(): BelongsTo
    {
        return $this->belongsTo(Subreddit::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return MorphMany<Vote, $this>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
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

    public function updateCommentCount(): void
    {
        $count = $this->comments()->where('is_deleted', false)->count();
        $this->update(['comment_count' => $count]);
    }

    protected static function booted(): void
    {
        self::creating(function (Post $post): void {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'vote_score' => 'integer',
            'comment_count' => 'integer',
        ];
    }
}
