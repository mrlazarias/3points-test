<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class PostLiked implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public User $user,
        public Post $post,
        public string $voteType
    ) {
        Log::info('PostLiked event created', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'vote_type' => $voteType,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Só notificar se o usuário que votou não for o dono do post
        if ($this->user->id === $this->post->user_id) {
            return [];
        }

        return [
            new Channel('user.'.$this->post->user_id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $action = $this->voteType === 'up' ? 'curtiu' : 'não curtiu';

        return [
            'type' => 'post_liked',
            'notification' => [
                'id' => uniqid(),
                'title' => 'Seu post foi curtido!',
                'message' => sprintf('%s %s seu post: %s', $this->user->getDisplayName(), $action, $this->post->title),
                'from_user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->getDisplayName(),
                    'profile_photo_url' => $this->user->getProfilePictureUrl(),
                ],
                'post' => [
                    'id' => $this->post->id,
                    'title' => $this->post->title,
                    'slug' => $this->post->slug,
                    'subreddit' => $this->post->subreddit->name,
                ],
                'created_at' => now()->toISOString(),
                'url' => route('post.show', [$this->post->subreddit->slug, $this->post->slug]),
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
