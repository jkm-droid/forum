<?php

namespace App\HelperFunctions;

use App\Models\Category;
use App\Models\ForumList;

trait GetRepetitiveItems
{
    /**
     * get all the categories
     */

    public  function get_all_categories(){
        return Category::orderBy('created_at', 'DESC')->take(20)->get();
    }

    /**
     * get forum list
     */

    public function get_forum_list(){
        return ForumList::orderBy('created_at', 'DESC')->get();
    }

    /**
     * get 5 forum list
     */

    public function get_top_forum_list(){
        return ForumList::orderBy('created_at', 'DESC')->take(5)->get();
    }
}
