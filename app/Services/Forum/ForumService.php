<?php

namespace App\Services\Forum;

use App\Helpers\GetRepetitiveItems;
use App\Models\Category;
use App\Models\Message;
use App\Models\Topic;
use App\Models\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumService
{
    use GetRepetitiveItems;

    public function welcomePage()
    {
        $categories = Category::where('status',1)->orderBy('created_at', 'DESC')->get();
        $topics = Topic::where('status',1)->with('category')->orderBy('created_at', 'DESC')->latest()->paginate(20);
        $forum_list = $this->get_forum_list();

        return view('site.welcome', compact('categories', 'topics','forum_list'))
            ->with('user', $this->get_logged_user_details())
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    public function forumList()
    {
        $forum_list = $this->get_forum_list();

        return view('site.forum_list', compact('forum_list'))
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

}
