<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * This event class performs three function
 * 1. Sending various email to admins
 * 2. Sending various emails to members
 * 3. Saving system logs
 */
class AppHelperEvent
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
