<?php

namespace App\Http\Controllers;

use App\HelperFunctions\GetRepetitiveItems;
use App\Models\Category;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    use GetRepetitiveItems;

    public function __construct(){
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
    }

    /**
     *show home page with alongside all categories
     * and latest topics
     */
    public function show_welcome_page(){
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $topics = Topic::orderBy('created_at', 'DESC')->latest()->paginate(20);
        return view('site.welcome', compact('categories', 'topics'))
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

        $messages = Message::where('topic_id', $topic->id)->latest()->paginate(10);

        return view('site.single_topic', compact('topic', 'messages'))
            ->with('i', (request()->input('page',1) - 1) * 10);
    }

    /**
     * show all the top topics, rank them based on their messages
     */

    public function show_top_topics(){
        $top_topics = Topic::orderBy('views', 'DESC')->take(20)->get();

        return view('site.top_topics', compact('top_topics'))
            ->with('categories', $this->get_all_categories());
    }

}
