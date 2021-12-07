<?php

namespace App\Http\Controllers;

use App\HelperFunctions\GetRepetitiveItems;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    use GetRepetitiveItems;

    public function __construct(){

    }

    /**
     *show home page with alongside all categories
     * and latest topics
     */
    public function show_welcome_page(){
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $topics = Topic::with('category')->orderBy('created_at', 'DESC')->latest()->paginate(20);
        $forum_list = $this->get_forum_list();


        return view('site.welcome', compact('categories', 'topics','forum_list'))
            ->with('user', $this->get_logged_user_details())
            ->with('i', (request()->input('page',1) - 1) * 20);
    }

    /**
     * show a single category based on its slug alongside
     * all its topics
     */

    public function show_single_category($slug){
        $category = Category::where('slug', $slug)->first();
        $category_topics = Topic::where('category_id', $category->id)->orderBy('created_at', 'DESC')->get();

        return view('site.single_category',compact('category','category_topics'));
    }

    /**
     * show a single topic alongside the body, messages and comments
     */

    public function show_topic($slug){
        $topic = Topic::where('slug', $slug)->first();

        //register views
        $topic->incrementViewCount();

        $messages = Message::where('topic_id', $topic->id)->latest()->paginate(10);

        return view('site.single_topic', compact('topic', 'messages'))
            ->with('i', (request()->input('page',1) - 1) * 10)
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * show all the top topics, rank them based on their messages
     */

    public function show_top_topics(){
        $top_topics = Topic::orderBy('views', 'DESC')->take(20)->get();

        return view('site.top_topics', compact('top_topics'))
            ->with('user', $this->get_logged_user_details())
            ->with('forum_list', $this->get_forum_list())
            ->with('categories', $this->get_all_categories());
    }

    /**
     * show all the categories
     */

    public function show_forum_list(){
        $forum_list = $this->get_forum_list();

        return view('site.forum_list', compact('forum_list'))
            ->with('user', $this->get_logged_user_details())
            ->with('categories', $this->get_all_categories());
    }

}
