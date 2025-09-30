<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Support\Facades\Log;
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
        Log::info('CommentCreated event constructed', [
            'comment_id' => $comment->id,
            'post_id' => $post->id,
            'channel' => 'post.'.$post->id,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        $channel = 'post.'.$this->post->id;
        Log::info('CommentCreated broadcasting on channel', [
            'channel' => $channel,
            'comment_id' => $this->comment->id,
            'post_id' => $this->post->id,
        ]);

        return [
            new Channel($channel),
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
                'likes_count' => $this->comment->likes_count,
                'dislikes_count' => $this->comment->dislikes_count,
                'depth' => $this->comment->depth,
                'parent_id' => $this->comment->parent_id,
                'post_id' => $this->comment->post_id,
            ],
            'post' => [
                'id' => $this->post->id,
                'comment_count' => $this->post->comment_count,
                'user_id' => $this->post->user_id,
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
