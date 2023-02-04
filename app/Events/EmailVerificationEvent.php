<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventDetails;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($eventDetails)
    {
        $this->eventDetails = $eventDetails;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
