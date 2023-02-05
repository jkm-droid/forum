<?php

namespace App\Helpers;

use App\Mail\AdminSendMail;
use App\Mail\MemberSendMail;
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
