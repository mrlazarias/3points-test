<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

final class Subreddit extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'created_by',
        'is_active',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        self::creating(function (Subreddit $subreddit): void {
            if (blank($subreddit->slug)) {
                $subreddit->slug = Str::slug($subreddit->name);
            }
        });
    }
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
