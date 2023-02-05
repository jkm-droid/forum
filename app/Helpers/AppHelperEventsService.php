<?php

namespace App\Helpers;

use App\Mail\AdminSendMail;
use App\Mail\MemberSendMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppHelperEventsService
{
    public function sendNewMessageNotification($event)
    {
        $details = $event->eventDetails;
        $email = new MemberSendMail('joshwriter53@gmail.com', $details);
        Mail::to($details['recipient_email'])->send($email);
    }

    public function SendAdminEmail($event)
    {
        $topicDetails = $event->details['topic'];
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

    public function SendMemberEmail($event)
    {
        $details = $event->eventDetails;

        Log::channel('daily')->info("member listener");
        Log::channel('daily')->info(implode('',$details));

        $email = new MemberSendMail($details);
        Mail::to($details['receiver'])->send($email);
    }
}
