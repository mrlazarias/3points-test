<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class CommentCreated implements ShouldBroadcastNow
{
    use Dispatchable;

    use InteractsWithSockets;

    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Comment $comment, public Post $post)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('post.'.$this->post->id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'comment' => [
                'id' => $this->comment->id,
                'content' => $this->comment->content,
                'user' => [
                    'id' => $this->comment->user->id,
                    'name' => $this->comment->user->name,
                    'profile_photo_url' => $this->comment->user->profile_photo_url ?? null,
                ],
                'created_at' => $this->comment->created_at->toISOString(),
                'vote_score' => $this->comment->vote_score,
                'depth' => $this->comment->depth,
                'parent_id' => $this->comment->parent_id,
            ],
            'post' => [
                'id' => $this->post->id,
                'comment_count' => $this->post->comment_count,
            ],
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'comment.created';
    }
}
