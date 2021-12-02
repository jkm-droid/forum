<?php

namespace App\HelperFunctions;

use App\Models\Category;

trait GetRepetitiveItems
{
    /**
     * get all the categories
     */

    public  function get_all_categories(){
        return Category::orderBy('created_at', 'DESC')->get();
    }
}
