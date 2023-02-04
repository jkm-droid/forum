<?php

namespace App\Listeners;

use App\Events\ProcessUserPostEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessUserPostListener implements ShouldQueue
{

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'sqs';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 20;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProcessUserPostEvent  $event
     * @return void
     */
    public function handle(ProcessUserPostEvent $event)
    {
        $listenerDetails = $event->eventDetails;
    }
}
