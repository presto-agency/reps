<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckNewMessage implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * CheckNewMessage constructor.
     */
    public function __construct()
    {


    }

    public function broadcastOn()
    {
        return 'ChatCheckMessage';
    }

    public function broadcastWith()
    {
        return [
            'check'   => true,
            'message' => 'New message in chat'
        ];
    }
}
