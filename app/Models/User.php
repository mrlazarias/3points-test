<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'location',
        'website',
        'birth_date',
        'is_public',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatar = $this->getFirstMedia('profile-pictures');

        return $avatar?->getUrl();
    }

    /**
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany<Subreddit, $this>
     */
    public function subreddits(): HasMany
    {
        return $this->hasMany(Subreddit::class, 'created_by');
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return BelongsToMany<Subreddit, $this>
     */
    public function followedCommunities(): BelongsToMany
    {
        return $this->belongsToMany(Subreddit::class, 'community_follows', 'user_id', 'subreddit_id')
            ->withTimestamps();
    }

    /**
     * Get the user's profile picture URL.
     */
    public function getProfilePictureUrl(): ?string
    {
        $avatar = $this->getFirstMedia('profile-pictures');

        return $avatar?->getUrl();
    }

    /**
     * Get the user's cover photo URL.
     */
    public function getCoverPhotoUrl(): ?string
    {
        $cover = $this->getFirstMedia('cover-photos');

        return $cover?->getUrl();
    }

    /**
     * Get the user's display name (username or name).
     */
    public function getDisplayName(): string
    {
        return $this->username ?: $this->name;
    }

    /**
     * Get the user's age from birth date.
     */
    public function getAge(): ?int
    {
        if (! $this->birth_date) {
            return null;
        }

        return $this->birth_date->age;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_public' => 'boolean',
        ];
    }
}
