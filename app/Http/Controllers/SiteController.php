<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Http\Request;

class SiteController extends Controller
{
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

        return view('site.single_category',compact('category'));
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
}
