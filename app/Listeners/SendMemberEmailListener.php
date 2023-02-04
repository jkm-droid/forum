<?php

namespace App\Listeners;

use App\Events\SendMemberEmailEvent;
use App\Mail\MemberSendEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMemberEmailListener implements ShouldQueue
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
     * @param  SendMemberEmailEvent  $event
     * @return void
     */
    public function handle(SendMemberEmailEvent $event)
    {
        $details = $event->eventDetails;

        Log::channel('daily')->info("member listener");
        Log::channel('daily')->info(implode('',$details));

        $email = new MemberSendEmail($details);
        Mail::to($details['receiver'])->send($email);
    }
}
