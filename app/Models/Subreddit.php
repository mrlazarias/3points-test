<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    /**
     * @return BelongsToMany<User, $this>
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_follows', 'subreddit_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Verifica se um usuário está seguindo esta comunidade
     */
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('user_id', $user->id)->exists();
    }

    /**
     * Seguir uma comunidade
     */
    public function follow(User $user): bool
    {
        if ($this->isFollowedBy($user)) {
            return false; // Já está seguindo
        }

        $this->followers()->attach($user->id);

        return true;
    }

    /**
     * Deixar de seguir uma comunidade
     */
    public function unfollow(User $user): bool
    {
        if (! $this->isFollowedBy($user)) {
            return false; // Não está seguindo
        }

        $this->followers()->detach($user->id);

        return true;
    }

    /**
     * Contar número de seguidores
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
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
