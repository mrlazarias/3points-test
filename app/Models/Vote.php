<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Vote extends Model
{
    /** @use HasFactory<VoteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voteable_id',
        'voteable_type',
        'vote_type',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function voteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isUpvote(): bool
    {
        return $this->vote_type === 'up';
    }

    public function isDownvote(): bool
    {
        return $this->vote_type === 'down';
    }

    protected static function booted(): void
    {
        self::created(function (Vote $vote): void {
            $vote->voteable->updateVoteScore();
        });

        self::updated(function (Vote $vote): void {
            $vote->voteable->updateVoteScore();
        });

        self::deleted(function (Vote $vote): void {
            $vote->voteable->updateVoteScore();
        });
    }
}
