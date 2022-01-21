<?php

namespace App\Listeners;

use App\Events\AdminEvent;
use App\Events\HelperEvent;
use App\Jobs\AdminJob;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdminListener
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
     * @param  AdminEvent  $event
     * @return void
     */
    public function handle(AdminEvent $event)
    {
        $topicDetails = $event->details;
        $admins = Admin::get();

        foreach ($admins as $admin){
            $emailInfo = [
                'admin_username'=>$admin->username,
                'admin_email'=>$admin->email,
                'subject'=>"New Topic Creation Notification",
                'title'=>$topicDetails->title,
                'author'=>$topicDetails->author,
            ];

            AdminJob::dispatch($emailInfo);
        }
    }
}
