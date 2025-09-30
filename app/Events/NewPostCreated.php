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

final class NewPostCreated implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public User $author,
        public Post $post
    ) {
        Log::info('NewPostCreated event created', [
            'author_id' => $author->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Notificar todos os seguidores do autor
        $followerIds = $this->author->followers()->pluck('users.id');

        $channels = [];
        foreach ($followerIds as $followerId) {
            $channels[] = new Channel('user.'.$followerId);
        }

        return $channels;
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'type' => 'new_post',
            'notification' => [
                'id' => uniqid(),
                'title' => 'Novo post de alguém que você segue!',
                'message' => sprintf('%s criou um novo post: %s', $this->author->getDisplayName(), $this->post->title),
                'from_user' => [
                    'id' => $this->author->id,
                    'name' => $this->author->getDisplayName(),
                    'profile_photo_url' => $this->author->getProfilePictureUrl(),
                    'username' => $this->author->username,
                ],
                'post' => [
                    'id' => $this->post->id,
                    'title' => $this->post->title,
                    'slug' => $this->post->slug,
                    'subreddit' => $this->post->subreddit->name,
                    'subreddit_slug' => $this->post->subreddit->slug,
                ],
                'url' => route('post.show', [$this->post->subreddit->slug, $this->post->slug]),
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
