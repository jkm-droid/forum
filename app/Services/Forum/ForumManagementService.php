<?php

namespace App\Services\Forum;

use App\Helpers\GetRepetitiveItems;
use App\Models\Category;
use App\Models\Message;
use App\Models\Topic;
use App\Models\View;
use Illuminate\Support\Facades\Auth;

class ForumManagementService
{
    use GetRepetitiveItems;

    public function welcomePage()
    {
        $categories = Category::where('status',1)->orderBy('created_at', 'DESC')->get();
        $topics = Topic::where('status',1)->with('category')->orderBy('created_at', 'DESC')->latest()->paginate(20);
        $forum_list = $this->get_forum_list();

//        if (Auth::check()) {
//            $user = $this->get_logged_user_details();
//
//            $view = View::where('user_id', $user->id)->where('topic_id', $topic->id)->first();
//            if ($view->isViewed == 1)
//                $isViewed = 1;
//            else
//                $isViewed = 0;
//        }

        return view('site.welcome', compact('categories', 'topics','forum_list'))
            ->with('user', $this->get_logged_user_details())
            ->with('i', (request()->input('page',1) - 1) * 20);
//            ->with('isViewed', $isViewed);
    }

    public function singleCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category_topics = Topic::where('status', 1)->where('category_id', $category->id)->orderBy('created_at', 'DESC')->paginate(20);

        return view('site.single_category',compact('category','category_topics'))
            ->with('i', (request()->input('page',1) - 1) * 20)
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $this->get_logged_user_details());
    }

    public function showTopic($slug)
    {
        $topic = Topic::where('slug', $slug)->first();

        //register views
        if (Auth::check()) {
            $user = $this->get_logged_user_details();
            if (!$user->views()->where('topic_id', $topic->id)->first()) {
                $topic->views = $topic->views + 2;
                $topic->update();

                $view = new View();
                $view->user_id = $user->id;
                $view->topic_id = $topic->id;
                $view->isViewed = 1;
                $view->save();
            }
        }else{
            $topic->incrementViewCount();
        }

        $messages = Message::where('topic_id', $topic->id)->latest()->paginate(10);

        return view('site.single_topic', compact('topic', 'messages'))
            ->with('i', (request()->input('page',1) - 1) * 10)
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function topTopics()
    {
        $top_topics = Topic::where('status',1)->orderBy('views', 'DESC')->take(20)->get();

        return view('site.top_topics', compact('top_topics'))
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    public function getSingleMessage($message_id)
    {
        $message = Message::where('message_id', $message_id)->first();

        return view('site.single_message', compact('message'))
            ->with('forum_list', $this->get_forum_list())
            ->with('user', $this->get_logged_user_details());
    }

    public function forumList()
    {
        $forum_list = $this->get_forum_list();

        return view('site.forum_list', compact('forum_list'))
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

}
