<?php

namespace App\HelperFunctions;

use App\Models\Activity;
use App\Models\Country;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyHelperClass
{

    /**
     * get logged user details
     */
    public function get_logged_user_details(){
        return User::where('id',Auth::user()->id)->first();
    }

    /**
     * get logged admin details
     */
    public function get_logged_admin_details(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::guard('admin')->user();
    }

    /**
     * get the country
     */
    public function get_country($user){
        //get the country
        $countries = Country::get();
        $c = "";
        foreach ($countries as $country){
            if ($country->iso == $user){
                $c = $country->name;
            }
        }

        return $c;
    }

    /**
     * params - table, start_string
     * generate unique alphanumeric id
     */
    public function generateUniqueId($start_string, $db_table, $column_name){
        $table = $db_table;
        $column = $column_name;
        $number = mt_rand(1000000, 9999999);
        $string = $this->random_str(5);

        $id = $start_string.''.$number.''.$string;
        if ($this->checkIfIdExists($id, $table, $column)){
            $this->generateUniqueId($start_string, $db_table, $column_name);
        }

        return $id;
    }

    /**
     * generate a secure string
     */
    public function random_str(
        int $length = 64,
        string $keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
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
