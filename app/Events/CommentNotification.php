<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Support\Str;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class CommentNotification implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public User $commenter,
        public Post $post,
        public Comment $comment
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        // Só envia notificação se o comentador não for o dono do post
        if ($this->commenter->id === $this->post->user_id) {
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
        return [
            'notification' => [
                'type' => 'comment',
                'title' => 'Novo comentário',
                'message' => $this->commenter->name . ' comentou no seu post',
                'from_user' => [
                    'id' => $this->commenter->id,
                    'name' => $this->commenter->name,
                    'username' => $this->commenter->username,
                    'profile_photo_url' => $this->commenter->getProfilePictureUrl(),
                ],
                'post' => [
                    'id' => $this->post->id,
                    'title' => $this->post->title,
                    'slug' => $this->post->slug,
                    'subreddit' => [
                        'name' => $this->post->subreddit->name,
                        'slug' => $this->post->subreddit->slug,
                    ],
                ],
                'comment' => [
                    'id' => $this->comment->id,
                    'content' => Str::limit(strip_tags($this->comment->content), 100),
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
