<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\ForumList;
use Illuminate\Support\Facades\Auth;

trait GetRepetitiveItems
{
    /**
     * get all the categories
     */

    public  function get_all_categories(){
        return Category::where('status',1)->orderBy('created_at', 'DESC')->take(20)->get();
    }

    /**
     * get forum list
     */

    public function get_forum_list(){
        return ForumList::where('status',1)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * get logged user details
     */
    public function get_logged_user_details(){
        $user = '';
        if (Auth::check()){
            $user = \App\Models\User::where('id',Auth::user()->id)->first();
        }

        return $user;
    }

}
