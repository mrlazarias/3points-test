<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class SimpleTestEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    /**
     * @var string|null
     */
    public $timestamp;

    public function __construct(public $message)
    {
        $this->timestamp = now()->toISOString();

        Log::info('SimpleTestEvent criado', [
            'message' => $this->message,
            'timestamp' => $this->timestamp,
        ]);
    }

    public function broadcastOn(): array
    {
        Log::info('SimpleTestEvent - Definindo canal', [
            'channel' => 'post.7',
        ]);

        return [
            new Channel('post.7'),
        ];
    }

    public function broadcastAs(): string
    {
        $eventName = 'simple.test';
        Log::info('SimpleTestEvent - Nome do evento', [
            'event_name' => $eventName,
        ]);

        return $eventName;
    }

    public function broadcastWith(): array
    {
        $data = [
            'message' => $this->message,
            'timestamp' => $this->timestamp,
        ];

        Log::info('SimpleTestEvent - Dados do broadcast', [
            'data' => $data,
        ]);

        return $data;
    }
}
