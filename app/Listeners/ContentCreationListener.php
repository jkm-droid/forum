<?php

namespace App\Listeners;

use App\Events\ContentCreationEvent;
use App\Jobs\HelperJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentCreationListener implements ShouldQueue
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
     * @param  ContentCreationEvent  $event
     * @return void
     */
    public function handle(ContentCreationEvent $event)
    {
        $eventDetails = $event->_eventDetails;
        $sender = $eventDetails['user']->username;

        if ($eventDetails['purpose'] == "message"){
            //notify to both author and admin
            $details = [
                'recipient_email' => $eventDetails['topic']->user->email,
                'subject' => 'Hey there... you have a new reaction from'.$sender,
                'message' => 'Your post <strong>'.$eventDetails['topic']->title.'</strong> has a new reaction from <strong>'.$sender.'</strong>',
                'username' => $eventDetails['topic']->user->username,
                'purpose' => 'message'
            ];

            HelperJob::dispatch($details);
        }

        if ($eventDetails['purpose'] == "comment"){
            //notify the message's author
            $details = [
                'recipient_email' => $eventDetails['message']->user->email,
                'subject' => 'Hey there... you have a new reaction from '.$sender,
                'message' => 'Your message <strong>'.Str::limit($eventDetails['message']->body,'100','...').'</strong> has a new reaction from <strong>'.$sender.'</strong>',
                'username' => $eventDetails['message']->user->username,
                'purpose' => 'comment'
            ];
            Log::channel('daily')->info(implode('',$details));

            HelperJob::dispatch($details);
        }
    }
}
