<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class UserFollowed implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public User $follower,
        public User $following
    ) {
        Log::info('UserFollowed event created', [
            'follower_id' => $follower->id,
            'following_id' => $following->id,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('user.'.$this->following->id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'type' => 'follow',
            'notification' => [
                'id' => uniqid(),
                'title' => 'Novo seguidor!',
                'message' => $this->follower->getDisplayName().' começou a te seguir',
                'from_user' => [
                    'id' => $this->follower->id,
                    'name' => $this->follower->getDisplayName(),
                    'profile_photo_url' => $this->follower->getProfilePictureUrl(),
                    'username' => $this->follower->username,
                ],
                'url' => route('profile.user', $this->follower->username),
                'created_at' => now()->toISOString(),
            ],
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notification.received';
    }
}
