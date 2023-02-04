<?php

namespace App\Helpers;

use App\Mail\AdminSendMail;
use App\Mail\MemberSendEmail;
use App\Models\Activity;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppHelperService
{
    public function sendNewMessageNotification($event)
    {
        $details = $event->eventDetails;
        $email = new MemberSendEmail('joshwriter53@gmail.com', $details);
        Mail::to($details['recipient_email'])->send($email);
    }

    public function SendAdminEmail($event)
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

    public function SendMemberEmail($event)
    {
        $details = $event->eventDetails;

        Log::channel('daily')->info("member listener");
        Log::channel('daily')->info(implode('',$details));

        $email = new MemberSendEmail($details);
        Mail::to($details['receiver'])->send($email);
    }

    /**
     * get logged user details
     */
    public function get_logged_user_details(){
        return User::where('id',Auth::user()->getAuthIdentifier())->first();
    }

    /**
     * get logged admin details
     */
    public function get_logged_admin_details()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * params - table, start_string
     * generate unique alphanumeric id
     */
    public function generateUniqueId($start_string, $db_table, $column_name){
        $table = $db_table;
        $column = $column_name;
        $number = mt_rand(1000000, 9999999);
        $string = $this->randomStr(5);

        $id = $start_string.''.$number.''.$string;
        if ($this->checkIfIdExists($id, $table, $column)){
            $this->generateUniqueId($start_string, $db_table, $column_name);
        }

        return $id;
    }

    /**
     * generate a secure string
     */
    public function randomStr(int $length = 64,string $keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * check if the id exists in the associated table
     */
    public function checkIfIdExists($id, $table, $column){
        return DB::table($table)->where($column,'=',$id)->exists();
    }

    /**
     * get messages created by user
     */
    public function get_user_messages(){
        $user = $this->get_logged_user_details();

        return Message::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(10);
    }

}
