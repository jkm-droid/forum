<?php

namespace App\Listeners;

use App\Events\SendAdminEmailEvent;
use App\Mail\AdminSendMail;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendAdminEmailListener implements ShouldQueue
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
     * @param  SendAdminEmailEvent  $event
     * @return void
     */
    public function handle(SendAdminEmailEvent $event)
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

            $mail = new AdminSendMail($emailInfo);
            Mail::to($admin->email)->send($mail);
        }
    }
}
