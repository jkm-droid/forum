<?php

namespace App\Services\Forum;

use App\Helpers\GetRepetitiveItems;
use App\Models\Category;
use App\Models\Topic;

class CategoryService
{
    use GetRepetitiveItems;

    public function singleCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category_topics = Topic::where('status', 1)->where('category_id', $category->id)->orderBy('created_at', 'DESC')->paginate(20);

        return view('site.single_category',compact('category','category_topics'))
            ->with('i', (request()->input('page',1) - 1) * 20)
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $this->get_logged_user_details());
    }
}
