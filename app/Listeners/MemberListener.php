<?php

namespace App\Listeners;

use App\Events\MemberEvent;
use App\Jobs\MemberJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class MemberListener
{
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
     * @param  MemberEvent  $event
     * @return void
     */
    public function handle(MemberEvent $event)
    {
        $details = $event->eventDetails;
//        $name = $details['name'];
        Log::channel('daily')->info("member listener");
        Log::channel('daily')->info(implode('',$details));
        MemberJob::dispatch($event->eventDetails);
    }
}
