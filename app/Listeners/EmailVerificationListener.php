<?php

namespace App\Listeners;

use App\Events\EmailVerificationEvent;
use App\Mail\EmailVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailVerificationListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(EmailVerificationEvent $event)
    {
        $details = $event->eventDetails;
        $email = new EmailVerificationMail('joshwriter53@gmail.com', $details);
        Mail::to($details['recipient_email'])->send($email);
    }
}
