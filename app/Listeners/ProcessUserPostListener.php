<?php

namespace App\Listeners;

use App\Events\ProcessUserPost;
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
    public $delay = 240;

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
     * @param  ProcessUserPost  $event
     * @return void
     */
    public function handle(ProcessUserPost $event)
    {
        $listenerDetails = $event->eventDetails;
    }
}
